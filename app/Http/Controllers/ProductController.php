<?php

namespace App\Http\Controllers;

use App\Models\Config;
use App\Models\Product;
use GuzzleHttp\Handler\Proxy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public $controller;

    public function __construct(ConfigController $controller)
    {
        $this->controller = $controller;
    }
    public function index($id)
    {

        $products = Product::where('config_id', $id)->paginate(24);
        return response()->json(['message' => 'Product list', 'results' => $products], 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function updateProducts(Request $request)
    {
        $configs = Config::all();
        
    }

    /**
     * Display the specified resource.
     */
    public function rematchedProduct(string $id)
    {
        try {
            $product = Product::findOrFail($id);
            if(!empty($product)){
                $config = Config::findOrFail($product->config_id);
                $this->controller->getConfigTableInfo($config,$product->url,['agent'=>true,'skipdiskcache'=>true]);
            }
            return response()->json(['message' => 'Product update successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to update product', 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        try {
            $product = Product::findOrFail($id);
            return view('layout.content.form.product-edit', ['product' => $product]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            Log::error("ERROR: Không tìm thấy sản phẩm");
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function show($id)
    {
        try {
            $product = Product::findOrFail($id);
            return response()->json(['product'=>$product],200,['message'=>'Lấy sản phẩm thành công']);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            Log::error("ERROR: Không tìm thấy sản phẩm");
        }
    }

    public function update(Request $request,$id){
    
        try {
            $product = Product::findOrFail($id);
            $product->title = $request->input('title');
            $product->price = $request->input('price');
            $product->promo = $request->input('promo');
            $product->shippingcost = $request->input('shippingcost');
            $product->brand = $request->input('brand');
            $product->reference = $request->input('reference');
            $product->mpn = $request->input('mpn');
            $product->ean = $request->input('ean');
            $product->imageurl = $request->input('imageurl');
            $product->available = $request->input('available');
            $product->spec = $request->input('spec');
            $product->description = $request->input('description');
            $product->save();

            return response()->json(['product'=>$product],200,['message'=>'Cập nhật sản phẩm thành công']);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            Log::error("ERROR: Không tìm thấy sản phẩm");
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            Product::destroy($id);
            return response()->json(['message' => 'Product delete successfully !'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to delete config', 'message' => $e->getMessage()], 500);
        }
    }
}
