<?php

namespace App\Http\Controllers;

use App\Product;
use App\Provider;
use Illuminate\Http\Request;

class ProviderController extends Controller
{
    public function index(Request $request){
        return response()->json([
            "success" => true,
            "total"=>Provider::all()->count(),
            "data"=>Provider::skip((int)$request->input("start"))->take((int)$request->input("limit"))->get()
        ]);
    }

    public function show($id){
        return Provider::find($id);
    }

    public function store(Request $request){
        $provider = Provider::create($request->all());
        $product = Product::find($request->input("product"));
        if($product != null) $provider->products()->attach($request->input("product"));
        return $provider;
    }

    public function update(Request $request,$id){
        $provider = Provider::findOrFail($id);
        $provider->update($request->all());
        return $provider;
    }

    public function delete(Request $request,$id){
        $provider = Provider::find($id);
        if($provider) {
            $provider->delete();
            return 204;
        }else{
            return 404;
        }
    }



}
