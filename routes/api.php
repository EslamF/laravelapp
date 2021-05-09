<?php

use Illuminate\Http\Request;
// use Symfony\Component\Routing\Route;

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

Route::group([

    'middleware' => 'api',
    'namespace' => 'Api'

], function ($router) {

    Route::post('/login' , 'AuthController@login'); 

    Route::group(['middleware' => 'auth:api'] , function(){

        Route::get('spreading_users'                  , 'MainController@spreading_users');
        Route::get('factories'                        , 'MainController@factories');


        Route::get('spreading_material_orders'  , 'SpreadingMaterialController@index');
        Route::get('spreading_material_orders/show' , 'SpreadingMaterialController@show');
        Route::post('spreading_material_orders/store'  , 'SpreadingMaterialController@store');
        Route::post('spreading_material_orders/update' , 'SpreadingMaterialController@update');

        Route::get('receiving_products_orders'  , 'ReceivingProductController@index');
        Route::get('receiving_products_orders/show' , 'ReceivingProductController@show');
        Route::post('receiving_products_orders/store'  , 'ReceivingProductController@store');

        Route::get('sort_orders'         , 'SortOrderController@index');
        //Route::get('sort_orders/show'    , 'SortOrderController@show');
        Route::post('sort_orders/store'  , 'SortOrderController@store');


    });

});