<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::group(['middleware' => ['cors']], function () {
    Route::get('providers','ProviderController@index');
    Route::get('providers/{id}','ProviderController@show');
    Route::post('providers','ProviderController@store');
    Route::put('providers/{id}','ProviderController@update');
    Route::delete('providers/{id}','ProviderController@delete');

    Route::get('products','ProductController@index');
    Route::get('products/{id}','ProductController@show');
    Route::post('products','ProductController@store');
    Route::put('products/{id}','ProductController@update');
    Route::delete('products/{id}','ProductController@delete');

    Route::get('stores','StoreController@index');
    Route::get('stores/{id}','StoreController@show');
    Route::post('stores','StoreController@store');
    Route::put('stores/{id}','StoreController@update');
    Route::delete('stores/{id}','StoreController@delete');

    Route::post('stores/products/increment','StoreInventoryController@incrementStoreInventory');
    Route::post('stores/products/decrement','StoreInventoryController@decrementStoreInventory');
    Route::post('stores/products/sales','StoreInventoryController@sellProduct');
    Route::get('stores/products/inventory/{store_id}','StoreInventoryController@getInventory');
});

