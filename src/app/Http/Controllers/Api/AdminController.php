<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Shop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    public function addProducts(Request $request){
        try{

            $validateProduct = Validator::make($request->all(), [
                'name' => ['required'],
                'shopId' => ['required']
            ]);

            if ($validateProduct->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'Error Validate',
                    'errors' => $validateProduct->errors()
                ], 401);
            }



            Product::create([
                'name' => $request->name,
                'user_id' => $request->user()->id,
                'shop_id' => $request->shopId,
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Product Created',
            ], 201);

        }catch (\Throwable $th){
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ]);
        }
    }

    public function getProducts(){
        $products = Product::all();

        return response()->json([
            'status' => true,
            'products' => $products
        ]);
    }

    public function updateProducts(Request $request, $id){
        try{
            $validateProduct = Validator::make($request->all(), [
                'name' => ['required'],
            ]);

            if ($validateProduct->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'Error Validate',
                    'errors' => $validateProduct->errors()
                ], 401);
            }

            $products = Product::findOrFail($id);

            $products->update([
                'name' => $request->name
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Shop updated',

            ], 201);

        }catch (\Throwable $th){
            return response()->json([
                'status' => true,
                'message' => $th->getMessage()
            ]);
        }
    }

    public function deleteProducts($id){
        Product::destroy($id);

        return response()->json([
            'status' => true,
            'message' => "Delete $id"
        ], 200);
    }
}
