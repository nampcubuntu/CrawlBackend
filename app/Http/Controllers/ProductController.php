<?php

namespace App\Http\Controllers;

use App\Models\Config;
use App\Models\Product;
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
    public function store(Request $request)
    {
        //
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
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
