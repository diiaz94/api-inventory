<?php

namespace App\Http\Controllers;

use App\Product;
use App\Store;
use App\Sale;
use App\StoreInventory;
use Illuminate\Http\Request;

class StoreInventoryController extends Controller
{
    public function incrementStoreInventory(Request $request){
        $store_id = $request->input("store_id");
        $product_id = $request->input("product_id");
        $store = Store::find($store_id);
        $product = Product::find($product_id);
        $count = $request->input("count");
        $buy_at = $request->input("buy_at");


        if($store == null) return response()->json(['msg'=>'Tienda inexistente.'],404);
        if($product == null)return response()->json(['msg'=>'Producto inexistente.'],404);

        $entry = new StoreInventory([
                'count'=>(int)$count,
                'buy_at'=>$buy_at,
                'product_id'=>$product_id
            ]);
        if($entry != null  ){
            $store->inventory()->save($entry);
            return $entry;
        }else{
            return response()->json(['msg'=>'Ha ocurrido un error inesperado.'],500);
        }
    }

    public function decrementStoreInventory(Request $request)
    {
        $store_id = $request->input("store_id");
        $product_id = $request->input("product_id");
        $store = Store::find($store_id);
        $product = Product::find($product_id);
        $count = $request->input("count");

        if($store == null) return response()->json(['msg'=>'Tienda inexistente.'],404);
        if($product == null)return response()->json(['msg'=>'Producto inexistente.'],404);
        if($count == 0) return response()->json(['msg'=>'La cantidad debe ser mayor a 0.'],401);

        $entriesSum = Store::find($store_id)
            ->inventory
            ->where("product_id",$product_id)
            ->where("count",">",0)
            ->sum("count");
        //return $entriesSum;
        if($entriesSum>=$count){
            $entries = Store::find($store_id)
                ->inventory
                ->where("product_id",$product_id)
                ->where("count",">",0);

            $this->decrementInventary($entries,$count);
            return response()->json(['remaining'=>$entriesSum - $request->input("count")]);
        }else{
            return response()->json(['msg'=>'No hay suficientes productos.'],403);
        }
    }

    public function sellProduct(Request $request){
        $store_id = $request->input("store_id");
        $product_id = $request->input("product_id");
        $store = Store::find($store_id);
        $product = Product::find($product_id);
        $count = $request->input("count");
        $sale_at = $request->input("sale_at");

        if($store == null) return response()->json(['msg'=>'Tienda inexistente.'],404);
        if($product == null)return response()->json(['msg'=>'Producto inexistente.'],404);
        if($count == 0) return response()->json(['msg'=>'La cantidad debe ser mayor a 0.'],401);

        $entriesSum = Store::find($store_id)
            ->inventory
            ->where("product_id",$product_id)
            ->where("count",">",0)
            ->sum("count");
        //return $entriesSum;
        if($entriesSum>=$count){
            $entries = Store::find($store_id)
                ->inventory
                ->where("product_id",$product_id)
                ->where("count",">",0);

            $sale = new Sale([
                'count'=>(int)$count,
                'sell_at'=>date("Y-m-d h:i:s"),
                'product_id'=>$product_id
            ]);

            if($sale != null  ){
                $store->sales()->save($sale);
                $this->decrementInventary($entries,$count);
                return response()->json(['msg'=>'Productos vendidos exitosamente.','sale'=>$sale]);
            }else{
                return response()->json(['msg'=>'Ha ocurrido un error inesperado.'],500);
            }
        }else{
            return response()->json(['msg'=>'No hay suficientes productos.'],403);
        }
    }

    public function getInventory($store_id){
        $store = Store::find($store_id);
        if($store == null) return response()->json(['msg'=>'Tienda inexistente.'],404);

        if (isset($_GET['buy_at']) && !empty($_GET['buy_at']) && \DateTime::createFromFormat('Y-m-d H:i:s', $_GET['buy_at']) == FALSE) {
            return response()->json(['msg'=>'El formato de la fecha no es válida.'],401);
        }

        $entries = Store::find($store_id)
            ->inventory
            ->where("count",">",0);

        if(isset($_GET['buy_at'])){
          return  $entries->where("buy_at",">=",$_GET['buy_at'])
                ->groupBy('product_id')->map(function($item){
                    return $item->sum('count');
                });
        }else{
          return $entries->groupBy('product_id')->map(function($item){
                    return $item->sum('count');
                });
        }
    }

    private function decrementInventary($entries,$count){
        foreach ($entries as $entry) {
            $entry_count = $entry->count;
            if($count <= 0) break;
            $entry->count = $entry_count > $count ? $entry_count - $count : 0;
            $count = $count - $entry_count;
            $entry->save();
        }
    }

}
