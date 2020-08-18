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
        'namespace'=>'Users'
    ],function (){
        
        Route::group([
            'prefix'=>'customers',
        ],function(){
            Route::get('get-all', 'CustomerController@getAllPaginate')->name('customer.list');
            Route::get('create', 'CustomerController@createPage')->name('customer.create_page');
            Route::post('store', 'CustomerController@create')->name('customer.store');
            Route::post('delete', 'CustomerController@delete')->name('customer.delete');
            Route::get('edit/{type_id}', 'CustomerController@editPage')->name('customer.edit_page');
            Route::post('update', 'CustomerController@update')->name('customer.update');
        });

        Route::group([
            'prefix'=>'suppliers',
        ],function(){
            Route::get('get-all', 'SupplierController@getAllPaginate')->name('supplier.list');
            Route::get('create', 'SupplierController@createPage')->name('supplier.create_page');
            Route::post('store', 'SupplierController@create')->name('supplier.store');
            Route::post('delete', 'SupplierController@delete')->name('supplier.delete');
            Route::get('edit/{type_id}', 'SupplierController@editPage')->name('supplier.edit_page');
            Route::post('update', 'SupplierController@update')->name('supplier.update');
        });
    });



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
    });Route::group([
        'namespace' => 'Organization',
        'prefix' => 'factory'

    ], function() {
        Route::get('get-all', 'FactoryController@getAllPaginate')->name('factory.list');
        Route::get('create', 'FactoryController@createPage')->name('factory.create_page');
        Route::post('store', 'FactoryController@create')->name('factory.store');
        Route::post('delete', 'FactoryController@delete')->name('factory.delete');
        Route::get('edit/{type_id}', 'FactoryController@editPage')->name('factory.edit_page');
        Route::post('update', 'FactoryController@update')->name('factory.update');

        Route::group([
            'prefix' => 'type'
        ], function() {
            Route::get('get-all', 'FactoryTypeController@getAllPaginate')->name('factory.type.list');
            Route::get('create', 'FactoryTypeController@createPage')->name('factory.type.create_page');
            Route::post('store', 'FactoryTypeController@create')->name('factory.type.store');
            Route::post('delete', 'FactoryTypeController@delete')->name('factory.type.delete');
            Route::get('edit/{type_id}', 'FactoryTypeController@editPage')->name('factory.type.edit_page');
            Route::post('update', 'FactoryTypeController@update')->name('factory.type.update');

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

    });

});