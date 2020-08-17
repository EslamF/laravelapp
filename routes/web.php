<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

// Route::get('/home', 'HomeController@index')->name('home');
Route::get('/home', function() {
    return view('index');
});
Route::group([
    'namespace' => 'Dashboard'
],function() {
    Route::group([
        'namespace' => 'Materials',
        'prefix' => 'materials'
    ], function() {
        Route::group([
            'prefix' => 'type'
        ], function() {
            Route::get('get-all', 'MaterialTypeController@getAllPaginate')->name('material.type.list');
            Route::get('create', 'MaterialTypeController@createPage')->name('material.type.create_page');
            Route::post('store', 'MaterialTypeController@create')->name('material.type.store');
            Route::post('delete', 'MaterialTypeController@delete')->name('material.type.delete');
            Route::get('edit/{type_id}', 'MaterialTypeController@editPage')->name('material.type.edit_page');
            Route::post('update', 'MaterialTypeController@update')->name('material.type.update');

        });
    });

    Route::group([
        'namespace' => 'Orders',
        'prefix'    => 'orders'
    ],function() {
        Route::group([
            'prefix' => 'receiving-material'
        ],function() {

            Route::get('get-all', 'ReceivingMaterialController@getAllPaginate')->name('order.receiving.material');
            Route::get('create', 'ReceivingMaterialController@createPage')->name('order.receiving_material.create_page');
            Route::post('store','ReceivingMaterialController@store')->name('receiving.material.store');
            Route::get('edit/{material_id}', 'ReceivingMaterialController@editPage')->name('receiving.material.edit_page');
            Route::post('update', 'ReceivingMaterialController@update')->name('receiving.material.update');
            Route::post('delete', 'ReceivingMaterialController@delete')->name('receiving.material.delete');
        });

        Route::group([
            'prefix' => 'spreading-material'
        ],function() {
            Route::get('get-all', 'SpreadingMaterialController@getAllPaginate')->name('spreading.material.list');
            Route::get('create', 'SpreadingMaterialController@createPage')->name('spreading.material.create_page');
            Route::post('store', 'SpreadingMaterialController@store')->name('spreading.material.store');
            Route::get('edit/{spreading_id}', 'SpreadingMaterialController@editPage')->name('spreading.material.edit_page');
            Route::post('update', 'SpreadingMaterialController@update')->name('spreading.material.update');
            Route::post('delete', 'SpreadingMaterialController@delete')->name('spreading.material.delete');

        });

        Route::group([
            'prefix' => 'cutting'
        ],function() {
            Route::get('get-all', 'CuttingOrderController@getAllPaginate')->name('cutting.material.list');
            Route::get('create', 'CuttingOrderController@createPage')->name('cutting.material.create_page');
            Route::post('store', 'CuttingOrderController@store')->name('cutting.material.store');
            Route::get('edit/{cutting_order_id}', 'CuttingOrderController@editPage')->name('cutting.material.edit_page');
            Route::post('update', 'CuttingOrderController@update')->name('cutting.material.update');
            Route::post('delete', 'CuttingOrderController@delete')->name('cutting.material.delete');

        });

        Route::group([
            'prefix' => 'produce'
        ], function() {
            Route::get('get-all', 'ProduceOrderController@getAllPaginate')->name('produce.order.list');
            Route::get('create', 'ProduceOrderController@createPage')->name('produce.order.create');
            Route::post('store', 'ProduceOrderController@store')->name('produce.order.store');
            Route::get('edit/{produce_id}', 'ProduceOrderController@editPage')->name('produce.order.edit_page');
            Route::post('update', 'ProduceOrderController@update')->name('produce.order.update');
            Route::post('delete', 'ProduceOrderController@delete')->name('produce.order.delete');


        });
    });

});