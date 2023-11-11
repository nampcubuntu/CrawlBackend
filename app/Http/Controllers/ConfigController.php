<?php

namespace App\Http\Controllers;

use App\Jobs\SaveProductJob;
use Illuminate\Http\Request;
use App\Models\Config;
use App\Models\Product;
use Exception;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class ConfigController extends Controller
{
    const MAX_ATTEMPTS = 3;
    const INITIAL_BACKOFF = 2;
    const CONNECTION_TIMEOUT = 30;
    const TIMEOUT = 80;

    /**
     * Display a listing of the resource.
     */
    
    public function __construct()
    {
 
    }

    public function index()
    {
        $configs = Config::all();
        return response()->json(['message' => 'Domain list', 'data' => $configs], 201);
    }

    public function gx($url, $options = [])
    {
        set_time_limit(600);//10 min
        $proxys = [];
        $proxys[0] = ['proxy'=>'hub-us-8.litport.net:31337','user_pwd'=>'5zavFQ:U42LBR'];
        $proxys[1] = ['proxy'=>'hub-us-10.litport.net:31337','user_pwd'=>'2L861L:m2aEuF'];
        $proxys[2] = ['proxy'=>'hub-us-8.litport.net:31337','user_pwd'=>'23MJ29:qX52dY'];

        $exists = Cache::has($url);
        if (empty($exists) || !empty($options['skipdiskcache'])) {
            // echo "Bypass cache";
            $attempts = 0;
            $backoff = self::INITIAL_BACKOFF;

            $curl = curl_init($url);

            curl_setopt_array($curl, [
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_CONNECTTIMEOUT => self::CONNECTION_TIMEOUT,
                CURLOPT_TIMEOUT => self::TIMEOUT,
                CURLOPT_SSL_VERIFYHOST => 2,
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_HEADER => true
            ]);

            if (!empty($options['proxy'])) {
                Log::channel('curl_log')->info('PROXY: ', ['proxy'=>$options['proxy']]);
                curl_setopt($curl, CURLOPT_PROXY, $options['proxy']);
            }

            if (!empty($options['user_pwd'])) {
                Log::channel('curl_log')->info('USER PWD: ', ['user_pwd'=>$options['user_pwd']]);
                curl_setopt($curl, CURLOPT_PROXYUSERPWD, $options['user_pwd']);
            }

            if (!empty($options['postdata']) || !empty($options['jsondata'])) {
              
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
                curl_setopt($curl, CURLOPT_POST, true);

                if (!empty($options['postdata'])) {
                    Log::channel('curl_log')->info('POST ARRAY: ',['postdata'=> $options['postdata']]);
                    curl_setopt($curl, CURLOPT_POSTFIELDS, $options['postdata']);
                } else {
                    Log::channel('curl_log')->info('POST JSON: ',['jsondata'=>$options['jsondata']]);
                    curl_setopt($curl, CURLOPT_POSTFIELDS, $options['jsondata']);
                }
            }

            if (!empty($options['headers'])) {
                Log::channel('curl_log')->info('HEADERS: ',['headers'=>$options['headers']]);
                curl_setopt($curl, CURLOPT_HTTPHEADER, $options['headers']);
            }

            if (!empty($options['cookie_jar_path'])) {
                Log::channel('curl_log')->info('COOKIE FILE: ',['cookie_jar_path'=> $options['cookie_jar_path']]);
                $cookie_jar_path = public_path() . $options['cookie_jar_path'];
                curl_setopt($curl, CURLOPT_COOKIEJAR, $cookie_jar_path);
            }

            if (!empty($options['use_cookie_file'])) {
                Log::channel('curl_log')->info('USE COOKIE FILE: ',['use_cookie_file'=>$options['use_cookie_file']]);
                curl_setopt($curl, CURLOPT_COOKIEFILE, $options['use_cookie_file']);
            }

            if (!empty($options['set_cookie'])) {
                Log::channel('curl_log')->info('SET COOKIE: ',['set_cookie'=>$options['set_cookie']]);
                curl_setopt($curl, CURLOPT_COOKIE, $options['set_cookie']);
            }

            $useProxy = false;
            while ($attempts < self::MAX_ATTEMPTS) {
                // Kiểm tra xem proxy có cần được sử dụng
                if ($useProxy) {
                    if (!empty($proxys[$attempts]['proxy']) && empty($options['proxy'])) {
                        Log::channel('curl_log')->info('PROXY RETRY: ',['proxy_retry'=>$proxys[$attempts]['proxy']]);
                        curl_setopt($curl, CURLOPT_PROXY, $proxys[$attempts]['proxy']);
                    }
                    if (!empty($proxys[$attempts]['user_pwd']) && empty($options['user_pwd'])) {
                        Log::channel('curl_log')->info('USER PWD RETRY: ',['user_pwd_retry'=>$proxys[$attempts]['user_pwd']]);
                        curl_setopt($curl, CURLOPT_PROXYUSERPWD, $proxys[$attempts]['user_pwd']);
                    }
                }
                
                $response = curl_exec($curl);
                $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

                if ($response === false || $httpcode !== 200) {
                    $attempts++;

                    $status = [];
                    $status['URL'] = $url;
                    $status['HTTPCODE'] = $httpcode;
                    $status['ATTEMPTS'] = $attempts;
                    $status['BACKOFF'] = $backoff;
                    Log::channel('curl_log')->info('RETRY: ',$status);

                    sleep($backoff);
                    $backoff *= 2;
                    $useProxy = true;
                } else {
                    

                    try {
                        // Lấy kích thước header từ phản hồi
                        $header_size = curl_getinfo($curl, CURLINFO_HEADER_SIZE);
                        $header_str = substr($response, 0, $header_size);
                        $response_headers = [];
                        foreach (explode("\r\n", $header_str) as $i => $line) {
                            if ($i === 0) {
                                $response_headers['HTTP Status'] = $line;
                            } else {
                                list($key, $value) = array_pad(explode(': ', $line, 2), 2, null);
                                if ($key !== null && $value !== null) {
                                    $response_headers[$key] = $value;
                                }
                            }
                        }
                        // Tạo một mảng để chứa tất cả thông tin phản hồi
                        $response_info = [
                            'info' => curl_getinfo($curl),
                            'Status Line' => '',
                            'Headers' => $response_headers,
                            'data' => $response,
                            'httpcode' => $httpcode
                        ];
                        Cache::put($url, $response_info, 86400);
                        // Log::channel('curl_log')->debug('CHECK DATA: ', $response_info);
                        return $response_info;
                        // break;
                    } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
                        var_dump(1);
                        Log::channel('curl_log')->error('Lỗi xảy ra trong quá trình xử lý!'. $e->getMessage());
                    }
                }
            }


            if ($response === false || $httpcode !== 200) {
                $error = curl_error($curl);
                Log::channel('curl_log')->error("cURL Error: " . $error);
                $response_info = [
                    'info' => curl_getinfo($curl),
                    'Status Line' => '',
                    'Headers' => '',
                    'data' => $response,
                    'httpcode' => $httpcode
                ];
            }

            curl_close($curl);
        } else {
            // echo 'Retrieve cache';
            return Cache::get($url);
        }
    }

    public function gxv(array $xp,$userNameXPath = null)
    {
        try {
            $encoding = mb_detect_encoding($xp['data']);
            $html = mb_convert_encoding($xp['data'], "UTF-8", $encoding);
            libxml_use_internal_errors(true);
            $dom = new \DOMDocument();
            $dom->loadHTML($html);
            libxml_clear_errors();
            $xpath =  new \DOMXPath($dom);

            $results = [];
            $elements = $xpath->query($userNameXPath);
            
            if ($elements !== false) {
                foreach ($elements as $element) {
                    $xpathValue = trim($element->textContent);
                    $results[] = $xpathValue;
                }
            }
            return $results ?: [''];
        } catch (Exception $e) {
            Log::error("ERROR: " . $e->getMessage());
        }
    }

    public function extractFromTo($inputString, $startPattern, $endPattern) {
        // Find the start position of the substring
        $startPosition = strpos($inputString, $startPattern);
        if ($startPosition === false) {
            return "Start pattern not found";
        }
        $startPosition += strlen($startPattern); // Adjust to start after the start pattern
    
        // Find the end position of the substring
        $endPosition = strpos($inputString, $endPattern, $startPosition);
        if ($endPosition === false) {
            return "End pattern not found";
        }
    
        // Extract and return the substring
        return substr($inputString, $startPosition, $endPosition - $startPosition);
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        try {
            $newConfig = [
                'url' => $request->input('url'),
            ];
            $config = Config::create($newConfig);

            return response()->json(['message' => 'Domain created successfully', 'data' => $config], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to create domain', 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        try {
            $config = Config::findOrFail($id);
            return view('layout.content.form.config-edit', ['config' => $config]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            Log::error("ERROR: Không tìm thấy cấu hình");
        }
    }

    public function productSave($product)
    {
        try {
            Product::updateOrInsert(['url' => $product['url']],$product);
            return response(200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            Log::error("ERROR: Thêm ko thành công !");
        }
    }

    public function getConfigTableInfo($config, $url,$options = [])
    {
  
       
            $producttitlexpath =  $config->producttitlexpath;
            $productpricexpath =  $config->productpricexpath;
            $productdiscountpricexpath =  $config->productdiscountpricexpath;
            $productbrandxpath =  $config->productbrandxpath;
            $productreferencexpath =  $config->productreferencexpath;
            $productmpnxpath =  $config->productmpnxpath;
            $producteanxpath =  $config->producteanxpath;
            $productimageurlxpath =  $config->productimageurlxpath;
            $productdescriptionxpath =  $config->productdescriptionxpath;
            $xp = $this->gx($url,$options);
  
            if ($xp['httpcode'] == 200) {
                $title = $this->gxv($xp, $producttitlexpath)[0];
                $price = $this->gxv($xp, $productpricexpath)[0];
                $promo = $this->gxv($xp, $productdiscountpricexpath)[0];
                $brand = $this->gxv($xp, $productbrandxpath)[0];
                $reference = $this->gxv($xp, $productreferencexpath)[0];
                $mpn = $this->gxv($xp, $productmpnxpath)[0];
                $ean = $this->gxv($xp, $producteanxpath)[0];
                $image = $this->gxv($xp, $productimageurlxpath)[0];
                $description = $this->gxv($xp, $productdescriptionxpath)[0];

                $result = array();
                $result['url'] = $url;
                $result['title'] = !empty($title) ? $title : "";
                $result['price'] = !empty($price) ? $price : "";
                $result['promo'] = !empty($promo) ? $promo : "";
                $result['shippingcost'] = "";
                $result['brand'] = !empty($brand) ? $brand : "";
                $result['reference'] = !empty($reference) ? $reference : "";
                $result['mpn'] = !empty($mpn) ? $mpn : "";
                $result['ean'] = !empty($ean) ? $ean : "";
                $result['imageurl'] = !empty($image) ? $image : "";
                $result['available'] = '';
                $result['description'] = !empty($description) ? $description : "";
                $result['config_id'] = $config->id;
                eval($config->textareaHookcode);
                $result['description'] = trim(preg_replace('/\s+/', ' ', $result['description']));
                $result['title'] = trim(preg_replace('/\s+/', ' ', $result['title']));

                // $ids = $this->gxv($xp,'//*[@class="dropdown__list"]/li/span/@data-value|//ul[@data-test="secVariantsCarousel"]/li/a/@data-value');
                // foreach($ids as $id){
                //     $xp2 = $this->gx("https://api.proxycrawl.com/?token=H2DBSSjhpsJgHI2NTk9K6A&url=https://www.chanel.com/us/p/loadVariant?sku=$id&nobrand=null&axisType=fashion&isPearlResponse=",['skipdiskcache'=>true]);       
                //     $json = substr($xp2['data'], strpos($xp2['data'], '{'), strrpos($xp2['data'], '}') - strpos($xp2['data'], '{') + 1);
                //     $data = json_decode($json,TRUE);
                //     // echo '<pre>';
                //     // var_dump($xp2);
                //     // echo '</pre>';
                //     $result['titles'][] = $data['title'];
                //     $result['prices'][] = $data['priceValue'];
                //     $result['discountprices'][] = $data['priceValue'];
                //     $result['references'][] = $data['ProductCode'];
                //     $result['mpns'][] = $data['baseProduct'];
                //     $result['eans'][] = $data['ProductCode'];
                //     if($data['sellableOnline']){
                //         $result['availables'][] = 'In Stock';
                //     }else{
                //         $result['availables'][] = 'Out Of Stock';
                //     }

                if(isset($options['agent']) && !empty($options)){
                    $this->productSave($result);
                }

                $result['httpcode'] = $xp['httpcode'];
                return $result;
    
            }else{
                $result = array();
                $result['id'] = '';
                $result['url'] = '';
                $result['orginurl'] = '';
                $result['title'] = '';
                $result['price'] = '';
                $result['promo'] = '';
                $result['shippingcost'] = "";
                $result['brand'] = '';
                $result['reference'] = '';
                $result['mpn'] = '';
                $result['ean'] = '';
                $result['imageurl'] = '';
                $result['available'] = '';
                $result['description'] = '';
                $result['httpcode'] = 0;

                return $result;
            }
    }


    function getAllConfigTables($config_id)
    {

        $config = Config::findOrFail($config_id);
        $productconfigurationurl = $config->productconfigurationurl;
        if (!empty($productconfigurationurl)) {
            $configs = array();
            $urls = explode('|', $productconfigurationurl);
            foreach ($urls as $k => $url) {
                $configs[] = $this->getConfigTableInfo($config, $url);
            }
            return response()->json(['message' => 'Get all configs', 'configs' => $configs], 200);
        }
        return response()->json(['message' => 'Get all configs'], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateConfig(Request $request, string $id)
    {

        $config = Config::find($id);
        if (!empty($config)) {
            $config->productconfigurationurl = $request->input('productconfigurationurl');
            $config->url = $request->input('url');
            $config->sitemapurl = $request->input('sitemapurl');
            $config->sitemaplevel1xpath = $request->input('sitemaplevel1xpath');
            $config->sitemaplevel2xpath = $request->input('sitemaplevel2xpath');
            $config->sitemaplevel3xpath = $request->input('sitemaplevel3xpath');
            $config->sitemapsubcategoryxpath = $request->input('sitemapsubcategoryxpath');
            $config->productxpath = $request->input('productxpath');
            $config->paginationxpath = $request->input('paginationxpath');
            $config->textareaHookcode = $request->input('textareaHookcode');
            $config->producttitlexpath = $request->input('producttitlexpath');
            $config->productpricexpath = $request->input('productpricexpath');
            $config->productdiscountpricexpath = $request->input('productdiscountpricexpath');
            $config->productbrandxpath = $request->input('productbrandxpath');
            $config->productreferencexpath = $request->input('productreferencexpath');
            $config->productmpnxpath = $request->input('productmpnxpath');
            $config->producteanxpath = $request->input('producteanxpath');
            $config->productimageurlxpath = $request->input('productimageurlxpath');
            $config->productdescriptionxpath = $request->input('productdescriptionxpath');
            $config->agentHookcode = $request->input('agentHookcode');
            $config->save();

            return response()->json(['message' => 'successfully', 'data' => $config], 200);
        } else {
            return response()->json(['message' => 'not found', 'data' => $config], 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            Config::destroy($id);
            return response()->json(['message' => 'Config delete successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to delete config', 'message' => $e->getMessage()], 500);
        }
    }


    public function agentHookCode(Request $request)
    {
        $config_id = $request->input('config_id');
        $config = Config::findOrFail($config_id);

        $links = [];
        $agentHookCode = $request->input('agentHookCode');
        eval($agentHookCode);
        $links = array_unique($links);
        foreach($links as $link){
            SaveProductJob::dispatch($this,$config,$link,['agent'=>true,'skipdiskcache'=>true]);
        }
        return response()->json(['message' => 'Đang crawl sản phẩm ...'], 200);
    }
}
