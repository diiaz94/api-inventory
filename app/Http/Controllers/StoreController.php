<?php

namespace App\Http\Controllers;

use App\Store;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    public function index(Request $request){
        return response()->json([
            "success" => true,
            "total"=>Store::all()->count(),
            "data"=>Store::skip((int)$request->input("start"))->take((int)$request->input("limit"))->get()
        ]);
    }

    public function show($id){
        return Store::find($id);
    }

    public function store(Request $request){
        $store = Store::create($request->all());
        return $store;
    }

    public function update(Request $request,$id){
        $store = Store::findOrFail($id);
        $store->update($request->all());
        return $store;
    }

    public function delete(Request $request,$id){
        $store = Store::find($id);
        if($store) {
            $store->delete();
            return 204;
        }else{
            return 404;
        }
    }



}

