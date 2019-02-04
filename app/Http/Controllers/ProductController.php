<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Input;

class ProductController extends Controller
{
    public function index(Request $request){
        return response()->json([
            "success" => true,
            "total"=>Product::all()->count(),
            "data"=>Product::skip((int)$request->input("start"))->take((int)$request->input("limit"))->get()
        ]);
    }

    public function show($id){
        return response()->json([
            "success" => true,
            "data"=>Product::find($id)
        ]);
    }

    public function store(Request $request){
        $product = Product::create($request->all());
        $product->providers()->attach($request->input("provider"));
        return response()->json([
            "success" => true,
            "data"=>$product
        ]);
    }

    public function update(Request $request,$id){
        $product = Product::findOrFail($id);
        $product->update($request->all());
        return response()->json([
            "success" => true,
            "data"=>$product
        ]);
    }

    public function delete(Request $request,$id){
        $product = Product::find($id);
        if($product) {
            $product->delete();
            return 204;
        }else{
            return 404;
        }
    }
}
