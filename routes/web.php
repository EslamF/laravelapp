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

        Route::group([
            'prefix' => 'receiving-products'
        ], function() {
            Route::get('get-all', 'ReceivingProductController@getAllPaginate')->name('receiving.product.list');
            Route::get('create', 'ReceivingProductController@createPage')->name('receiving.product.create');
            Route::post('store', 'ReceivingProductController@store')->name('receiving.product.store');
            Route::get('edit/{receiving_id}', 'ReceivingProductController@editPage')->name('receiving.product.edit_page');
            Route::post('update', 'ReceivingProductController@update')->name('receiving.product.update');
            Route::post('delete', 'ReceivingProductController@delete')->name('receiving.product.delete');
        });

        Route::group([
            'prefix' => 'sort'
        ],function() {
            Route::get('get-all', 'SortOrderController@getAllPaginate')->name('sort.order.list');
            Route::get('create', 'SortOrderController@createPage')->name('sort.order.create_page');
            Route::post('store', 'SortOrderController@store')->name('sort.order.store');
            Route::get('edit/{sort_id}', 'SortOrderController@editPage')->name('sort.order.edit_page');
            Route::post('update', 'SortOrderController@update')->name('sort.order.update');
            Route::post('delete', 'SortOrderController@delete')->name('sort.order.delete');
            Route::get('products/{sort_id}', 'SortOrderController@showSortedProducts')->name('sort.product.list');
            Route::post('product', 'SortOrderController@SortProduct')->name('sort.product');
            Route::post('remove-product', 'SortOrderController@removeSortedProduct')->name('product.sort.delete');
            
        });

        Route::group([
            'prefix' => 'fix-product'
        ],function() {
            Route::get('create', 'FixProductOrderController@createPage')->name('fix.product.create_page');
            Route::post('store', 'FixProductOrderController@store')->name('fix.product.store');
            Route::get('get-all', 'FixProductOrderController@getAllPaginate')->name('fix.product.list');
        });
    });

    Route::group([
        'namespace' => 'Products',
        'prefix'    => 'product'
    ], function() {
        Route::get('get-all', 'ProductController@getAllPaginate')->name('product.list');
        Route::get('create', 'ProductController@createPage')->name('product.create_page');
        Route::post('store', 'ProductController@store')->name('product.store');
        Route::get('edit/{product_id}', 'ProductController@editPage')->name('product.edit_page');
        Route::post('update', 'ProductController@update')->name('product.update');
        Route::post('delete', 'ProductController@delete')->name('product.delete');

        Route::group([
            'prefix' => 'type'
        ], function() {
            Route::get('get-all', 'ProductTypeController@getAllPaginate')->name('product.type.list');
            Route::get('create', 'ProductTypeController@createPage')->name('product.type.create_page');
            Route::post('store', 'ProductTypeController@create')->name('product.type.store');
            Route::post('delete', 'ProductTypeController@delete')->name('product.type.delete');
            Route::get('edit/{type_id}', 'ProductTypeController@editPage')->name('product.type.edit_page');
            Route::post('update', 'ProductTypeController@update')->name('product.type.update');
        });
    });
});