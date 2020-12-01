<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
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

Auth::routes(['register' => false, 'verify' => true]);

Route::group([
    'middleware' => ['auth']
], function () {

    Route::get('/', function () {
        return redirect('/home');
    });

    Route::group([
        'namespace' => 'Dashboard'
    ],  function () {
        Route::group([
            'namespace' => 'Options'
        ], function () {

            Route::get('/home', function () {
                return view('index');
            });

            Route::group([
                'prefix' => 'size'
            ], function () {
                Route::get('get-all', 'SizeController@getAllPaginate')->name('size.list');
                Route::get('get', 'SizeController@getAll')->name('size.get_all');
                Route::get('create', 'SizeController@createPage')->name('size.create_page');
                Route::post('store', 'SizeController@create')->name('size.store');
                Route::post('delete', 'SizeController@delete')->name('size.delete');
                Route::get('edit/{type_id}', 'SizeController@editPage')->name('size.edit_page');
                Route::post('update', 'SizeController@update')->name('size.update');
            });
        });

        Route::group(
            [
                'namespace' => 'Users'
            ],
            function () {
                Route::group([
                    'prefix' => 'roles',
                ], function () {
                    Route::get('get-all', 'RoleController@getAllPaginate')->name('role.list')->middleware('can:show-role');
                    Route::get('create', 'RoleController@createPage')->name('role.create_page')->middleware('can:add-role');
                    Route::post('store', 'RoleController@create')->name('role.store')->middleware('can:add-role');
                    Route::post('delete', 'RoleController@delete')->name('role.delete')->middleware('can:delete-role');
                    Route::get('edit/{type_id}', 'RoleController@editPage')->name('role.edit_page')->middleware('can:edit-role');
                    Route::post('update', 'RoleController@update')->name('role.update')->middleware('can:edit-role');
                });

                Route::group([
                    'prefix' => 'employees',
                ], function () {
                    Route::get('get-all-paginate', 'EmployeeController@getAllPaginate')->name('employee.list')->middleware('can:show-employee');
                    Route::get('get-all', 'EmployeeController@getAll')->name('employee.get_all')->middleware('can:show-employee');
                    Route::get('create', 'EmployeeController@createPage')->name('employee.create_page')->middleware('can:add-employee');
                    Route::post('store', 'EmployeeController@create')->name('employee.store')->middleware('can:add-employee');
                    Route::post('delete', 'EmployeeController@delete')->name('employee.delete')->middleware('can:delete-employee');
                    Route::get('edit/{type_id}', 'EmployeeController@editPage')->name('employee.edit_page')->middleware('can:edit-employee');
                    Route::post('update', 'EmployeeController@update')->name('employee.update')->middleware('can:edit-employee');
                });

                Route::group([
                    'prefix' => 'customers',
                ], function () {
                    Route::get('get-all', 'CustomerController@getAllPaginate')->name('customer.list')->middleware('can:show-customer');
                    Route::get('create', 'CustomerController@createPage')->name('customer.create_page')->middleware('can:add-customer');
                    Route::post('store', 'CustomerController@create')->name('customer.store')->middleware('can:add-customer');
                    Route::post('delete', 'CustomerController@delete')->name('customer.delete')->middleware('can:delete-customer');
                    Route::get('edit/{type_id}', 'CustomerController@editPage')->name('customer.edit_page')->middleware('can:edit-customer');
                    Route::post('update', 'CustomerController@update')->name('customer.update')->middleware('can:edit-customer');
                    Route::get('search/{phone}', 'CustomerController@searchByPhone')->name('customer_search')->middleware('can:search-customer');
                    Route::get('get/{id}', 'CustomerController@getById')->name('customer.get_by_id')->middleware('can:search-customer');
                });

                Route::group([
                    'prefix' => 'suppliers',
                ], function () {
                    Route::get('get-all', 'SupplierController@getAllPaginate')->name('supplier.list')->middleware('can:show-supplier');
                    Route::get('create', 'SupplierController@createPage')->name('supplier.create_page')->middleware('can:add-supplier');
                    Route::post('store', 'SupplierController@create')->name('supplier.store')->middleware('can:add-supplier');
                    Route::post('delete', 'SupplierController@delete')->name('supplier.delete')->middleware('can:delete-supplier');
                    Route::get('edit/{type_id}', 'SupplierController@editPage')->name('supplier.edit_page')->middleware('can:edit-supplier');
                    Route::post('update', 'SupplierController@update')->name('supplier.update')->middleware('can:edit-supplier');
                });
            }
        );



        Route::group([
            'namespace' => 'Materials',
            'prefix' => 'materials'
        ], function () {
            Route::group([
                'prefix' => 'type'
            ], function () {
                Route::get('get-all', 'MaterialTypeController@getAllPaginate')->name('material.type.list')->middleware('can:show-materials');
                Route::get('create', 'MaterialTypeController@createPage')->name('material.type.create_page')->middleware('can:add-materials');
                Route::post('store', 'MaterialTypeController@create')->name('material.type.store')->middleware('can:add-materials');
                Route::post('delete', 'MaterialTypeController@delete')->name('material.type.delete')->middleware('can:delete-materials');
                Route::get('edit/{type_id}', 'MaterialTypeController@editPage')->name('material.type.edit_page')->middleware('can:edit-materials');
                Route::post('update', 'MaterialTypeController@update')->name('material.type.update')->middleware('can:edit-materials');
            });
        });
        Route::group([
            'namespace' => 'Organization',

        ], function () {

            Route::group([
                'prefix' => 'shipping'

            ], function () {
                Route::get('get-all', 'ShippingCompanyController@getAllPaginate')->name('shippingcompany.list')->middleware('can:show-shapping');
                Route::post('test', 'ShippingCompanyController@test')->name('shippingcompany.test');
                Route::get('create', 'ShippingCompanyController@createPage')->name('shippingcompany.create_page')->middleware('can:add-shapping');
                Route::post('store', 'ShippingCompanyController@create')->name('shippingcompany.store')->middleware('can:add-shapping');
                Route::post('delete', 'ShippingCompanyController@destroy')->name('shippingcompany.delete_company')->middleware('can:delete-shapping');
                Route::get('edit/{type_id}', 'ShippingCompanyController@editPage')->name('shippingcompany.edit_page')->middleware('can:edit-shapping');
                Route::post('update', 'ShippingCompanyController@update')->name('shippingcompany.update')->middleware('can:edit-shapping');
                Route::get('get', 'ShippingCompanyController@getAll')->name('shippingcompany.get_all')->middleware('can:show-shapping');
            });

            Route::group([
                'prefix' => 'factory'
            ], function () {
                Route::get('get-all', 'FactoryController@getAllPaginate')->name('factory.list')->middleware('can:show-factory');
                Route::get('get-by-id/{factory_type_id}', 'FactoryController@getByType')->name('factory.by_type');
                Route::get('get', 'FactoryController@getAll')->name('factory_get_all')->middleware('can:show-factory');
                Route::get('get-by-cutting/{id}', 'FactoryController@getFactoryByCuttingOrder')->name('factory_by_cutting')->middleware('can:show-factory');
                Route::get('get/{id}', 'FactoryController@getById')->name('factory.get_by_id')->middleware('can:show-factory');
                Route::get('create', 'FactoryController@createPage')->name('factory.create_page')->middleware('can:show-factory');
                Route::post('store', 'FactoryController@create')->name('factory.store')->middleware('can:show-factory');
                Route::post('delete', 'FactoryController@delete')->name('factory.delete')->middleware('can:show-factory');
                Route::get('edit/{type_id}', 'FactoryController@editPage')->name('factory.edit_page')->middleware('can:show-factory');
                Route::post('update', 'FactoryController@update')->name('factory.update')->middleware('can:show-factory');

                Route::group([
                    'prefix' => 'type'
                ], function () {
                    Route::get('get', 'FactoryTypeController@getAll')->name('factory.type_all')->middleware('can:show-typefactory');
                    Route::get('get-all', 'FactoryTypeController@getAllPaginate')->name('factory.type.list')->middleware('can:show-typefactory');
                    Route::get('create', 'FactoryTypeController@createPage')->name('factory.type.create_page')->middleware('can:add-typefactory');
                    Route::post('store', 'FactoryTypeController@create')->name('factory.type.store')->middleware('can:add-typefactory');
                    Route::post('delete', 'FactoryTypeController@delete')->name('factory.type.delete')->middleware('can:delete-typefactory');
                    Route::get('edit/{type_id}', 'FactoryTypeController@editPage')->name('factory.type.edit_page')->middleware('can:edit-typefactory');
                    Route::post('update', 'FactoryTypeController@update')->name('factory.type.update')->middleware('can:edit-typefactory');
                });
            });
        });

        Route::group([
            'namespace' => 'Orders',
            'prefix'    => 'orders'
        ], function () {
            Route::group([
                'prefix' => 'receiving-material'
            ], function () {

                Route::get('get-all', 'ReceivingMaterialController@getAllPaginate')->name('order.receiving.material')->middleware('can:show-matrialreceiving');
                Route::get('create', 'ReceivingMaterialController@createPage')->name('order.receiving_material.create_page')->middleware('can:add-matrialreceiving');
                Route::post('store', 'ReceivingMaterialController@store')->name('receiving.material.store')->middleware('can:add-matrialreceiving');
                Route::get('edit/{material_id}', 'ReceivingMaterialController@editPage')->name('receiving.material.edit_page')->middleware('can:edit-matrialreceiving');
                Route::post('update', 'ReceivingMaterialController@update')->name('receiving.material.update')->middleware('can:edit-matrialreceiving');
                Route::post('delete', 'ReceivingMaterialController@delete')->name('receiving.material.delete')->middleware('can:delete-matrialreceiving');
                Route::get('check-weight/{material_code}', 'ReceivingMaterialController@checkWeight')->middleware('can:show-matrialreceiving');
            });

            Route::group([
                'prefix' => 'spreading-material'
            ], function () {
                Route::get('get-all-hold', 'SpreadingMaterialController@getAllPaginateForHold')->name('spreading.material.hold_list')->middleware('can:show-spreading');
                Route::get('get-all-used', 'SpreadingMaterialController@getAllPaginateForUsed')->name('spreading.material.used_list')->middleware('can:show-spreading');
                Route::get('get-counter', 'SpreadingMaterialController@counterList')->name('spreading.material.counter_list')->middleware('can:show-spreading');
                Route::get('get', 'SpreadingMaterialController@getAll')->name('spreading.get_all')->middleware('can:show-spreading');
                Route::get('create', 'SpreadingMaterialController@createPage')->name('spreading.material.create_page')->middleware('can:add-spreading');
                Route::post('store', 'SpreadingMaterialController@store')->name('spreading.material.store')->middleware('can:add-spreading');
                Route::get('edit/{spreading_id}', 'SpreadingMaterialController@editPage')->name('spreading.material.edit_page')->middleware('can:edit-spreading');
                Route::post('update', 'SpreadingMaterialController@update')->name('spreading.material.update')->middleware('can:edit-spreading');
                Route::post('delete', 'SpreadingMaterialController@delete')->name('spreading.material.delete')->middleware('can:delete-spreading');
            });

            Route::group([
                'prefix' => 'cutting'
            ], function () {
                Route::get('all', 'CuttingOrderController@outerList')->name('cutting.outer_list');
                Route::get('get-all-used', 'CuttingOrderController@getAllForUsed')->name('cutting.material.used_list');
                Route::get('get-all-hold', 'CuttingOrderController@getAllForHold')->name('cutting.material.hold_list');
                Route::get('get-inner_list', 'CuttingOrderController@getAllCounterInnerList')->name('cutting.material.counter_inner_list');
                Route::get('get-factory-list', 'CuttingOrderController@companyList')->name('cutting.factory_list');
                Route::get('get', 'CuttingOrderController@getAll')->name('cutting_order.all');
                Route::get('get-order-products/{id}', 'CuttingOrderController@getWithProduct')->name('cutting_order.show_products');
                Route::get('add_to_order/{id}', 'CuttingOrderController@addExtraCreate')->name('cutting_order.add_page');
                Route::post('store-extra', 'CuttingOrderController@storeExtra')->name('cutting_order.store_extra');
                Route::get('create', 'CuttingOrderController@createPage')->name('cutting.material.create_page');
                Route::post('store', 'CuttingOrderController@store')->name('cutting.material.store');
                Route::get('edit/{cutting_order_id}', 'CuttingOrderController@editPage')->name('cutting.material.edit_page');
                Route::post('update', 'CuttingOrderController@update')->name('cutting.material.update');
                Route::post('delete', 'CuttingOrderController@delete')->name('cutting.material.delete');
                Route::post('delete-product', 'CuttingOrderController@deleteProduct')->name('cutting.delete_product');
                Route::post('delet-products', 'CuttingOrderController@deleteProductsFromOrder')->name('cutting.delete_products');
                Route::get('inner-factory-edit/{cutting_order_id}', 'CuttingOrderController@innerOrderEdit')->name('cutting.inner_factory_edit_data');
                Route::get('inner-edit-page/{cutting_order_id}', 'CuttingOrderController@innerEditPage')->name('cutting.inner_factory_edit');
                Route::get('cutting-order-employees', 'CuttingOrderController@cuttingOrderEmployee')->name('cutting_order.employee');
                Route::post('inner-order-update', 'CuttingOrderController@updateCuttingOrder')->name('cutting_order.update_inneer');
            });

            Route::group([
                'prefix' => 'produce'
            ], function () {
                Route::get('get-all', 'ProduceOrderController@getAllPaginate')->name('produce.order.list')->middleware('can:show-produceorder');
                Route::get('get', 'ProduceOrderController@getAll')->name('produce_order.get_all')->middleware('can:show-produceorder');
                Route::get('create', 'ProduceOrderController@createPage')->name('produce.order.create')->middleware('can:add-produceorder');
                Route::post('store', 'ProduceOrderController@store')->name('produce.order.store')->middleware('can:add-produceorder');
                Route::get('edit/{produce_id}', 'ProduceOrderController@editPage')->name('produce.order.edit_page')->middleware('can:edit-produceorder');
                Route::post('update', 'ProduceOrderController@update')->name('produce.order.update')->middleware('can:edit-produceorder');
                Route::post('delete', 'ProduceOrderController@delete')->name('produce.order.delete')->middleware('can:delete-produceorder');
            });

            Route::group([
                'prefix' => 'receiving-products'
            ], function () {
                Route::get('get-all', 'ReceivingProductController@getAllPaginate')->name('receiving.product.list')->middleware('can:show-receivingproduct');
                Route::get('get', 'ReceivingProductController@getAll')->name('receiving_orders.get_all')->middleware('can:show-receivingproduct');
                Route::get('list/{id}', 'ReceivingProductController@productsToReceive')->name('products_to_receive')->middleware('can:edit-receivingproduct');
                Route::post('status', 'ReceivingProductController@changeStatus')->name('order_status')->middleware('can:show-receivingproduct');
                Route::get('/received/list/{id}', 'ReceivingProductController@productsReceived')->name('products_received')->middleware('can:edit-receivingproduct');
                Route::get('produce-products/{id}', 'ReceivingProductController@orderProduct')->name('receiving_products')->middleware('can:edit-receivingproduct');
                Route::get('create', 'ReceivingProductController@createPage')->name('receiving.product.create')->middleware('can:add-receivingproduct');
                Route::post('store', 'ReceivingProductController@store')->name('receiving.product.store')->middleware('can:add-receivingproduct');
                Route::get('edit/{receiving_id}', 'ReceivingProductController@editPage')->name('receiving.product.edit_page')->middleware('can:edit-receivingproduct');
                Route::post('update', 'ReceivingProductController@update')->name('receiving.product.update')->middleware('can:edit-receivingproduct');
                Route::post('delete', 'ReceivingProductController@delete')->name('receiving.product.delete')->middleware('can:delete-receivingproduct');
                Route::post('change-status', 'ReceivingProductController@approveOrUnapprove')->name('receiving_product.change_status')->middleware('can:delete-receivingproduct');
            });

            Route::group([
                'prefix' => 'sort'
            ], function () {
                Route::get('get-all', 'SortOrderController@getAllPaginate')->name('sort.order.list')->middleware('can:show-receivingproduct');
                Route::get('create', 'SortOrderController@createPage')->name('sort.order.create_page')->middleware('can:add-receivingproduct');
                Route::post('store', 'SortOrderController@store')->name('sort.order.store')->middleware('can:add-receivingproduct');
                Route::get('edit/{sort_id}', 'SortOrderController@editPage')->name('sort.order.edit_page')->middleware('can:edit-receivingproduct');
                Route::post('update', 'SortOrderController@update')->name('sort.order.update')->middleware('can:edit-receivingproduct');
                Route::post('delete', 'SortOrderController@delete')->name('sort.order.delete')->middleware('can:delete-receivingproduct');
                Route::get('products/{sort_id}', 'SortOrderController@showSortedProducts')->name('sort.product.list')->middleware('can:show-receivingproduct');
                Route::post('product', 'SortOrderController@SortProduct')->name('sort.product')->middleware('can:add-receivingproduct');
                Route::post('remove-product', 'SortOrderController@removeSortedProduct')->name('product.sort.delete')->middleware('can:delete-receivingproduct');
            });

            Route::group([
                'prefix' => 'fix-product'
            ], function () {
                Route::get('create', 'FixProductOrderController@createPage')->name('fix.product.create_page')->middleware('can:add-receivingordersfix');
                Route::post('store', 'FixProductOrderController@store')->name('fix.product.store')->middleware('can:add-receivingordersfix');
                Route::get('get-all', 'FixProductOrderController@getAllPaginate')->name('fix.product.list')->middleware('can:show-receivingordersfix');
                Route::post('delete', 'FixProductOrderController@delete')->name('fix.product.delete')->middleware('can:delete-receivingordersfix');
            });

            Route::group([
                'prefix' => 'receive-damaged-product'
            ], function () {
                Route::get('create', 'ReceivingDamagedOrdersController@createPage')->name('receiving.damaged_product.create_page')->middleware('can:add-receivingordersfix');
                Route::post('store', 'ReceivingDamagedOrdersController@store')->name('receiving.damaged_product.store')->middleware('can:add-receivingordersfix');
            });


            Route::group([
                'prefix' => 'send-end-product'
            ], function () {
                Route::get('get-all', 'SendEndProductController@getAllPaginate')->name('send.end_product.list')->middleware('can:show-sendorders');
                Route::get('get-all-saved/{save_order}', 'SendEndProductController@getSavedProdacts')->name('send.end_product.get_order')->middleware('can:add-sendorders');
                Route::get('create', 'SendEndProductController@create')->name('send.end_product.create_page')->middleware('can:add-sendorders');
                Route::post('store', 'SendEndProductController@store')->name('send.end_product.store')->middleware('can:add-sendorders');
                Route::post('edit/{product_id}', 'SendEndProductController@edit')->name('send.end_product.edit_page')->middleware('can:edit-sendorders');
                Route::post('update', 'SendEndProductController@update')->name('send.end_product.update')->middleware('can:edit-sendorders');
                Route::post('delete', 'SendEndProductController@delete')->name('send.end_product.delete')->middleware('can:delete-sendorders');
                Route::get('get-order/{order_code}', 'SendEndProductController@getOrder')->name('send.end_product.get_order')->middleware('can:add-sendorders');
                Route::post('delete', 'SendEndProductController@delete')->name('send.end_product.delete')->middleware('can:delete-sendorders');
                Route::post('check-if-sorted', 'SendEndProductController@checkIfSorted')->name('send_end_product.check_if_sorted')->middleware('can:add-sendorders');
            });

            Route::group([
                'prefix' => 'store-end-product'
            ], function () {
                Route::get('get-all', 'StoreProductOrderController@getAllPaginate')->name('store.end_product.list')->middleware('can:show-storeorders');
                Route::get('create', 'StoreProductOrderController@create')->name('store.end_product.create_page')->middleware('can:add-storeorders');
                Route::get('order/{id}', 'StoreProductOrderController@getShippingOrder')->name('store.end_product.shipping_list')->middleware('can:show-storeorders');
                Route::post('store', 'StoreProductOrderController@store')->name('store.end_product.store')->middleware('can:add-storeorders');
                Route::post('edit/{product_id}', 'StoreProductOrderController@edit')->name('store.end_product.edit_page')->middleware('can:edit-storeorders');
                Route::post('update', 'StoreProductOrderController@update')->name('store.end_product.update')->middleware('can:edit-storeorders');
                Route::post('delete', 'StoreProductOrderController@delete')->name('store.end_product.delete')->middleware('can:delete-storeorders');
                Route::get('get-order/{order_code}', 'StoreProductOrderController@getOrder')->name('store.end_product.get_order')->middleware('can:show-storeorders');
                Route::post('delete', 'StoreProductOrderController@delete')->name('store.end_product.delete')->middleware('can:delete-storeorders');
            });

            Route::group([
                'prefix' => 'buy'
            ], function () {
                Route::get('create', 'BuyOrderController@createPage')->name('buy.create_page')->middleware('can:add-buyorders');
                Route::get('get-all-paginate', 'BuyOrderController@getAllPaginate')->name('buy.list_page')->middleware('can:show-buyorders');
                Route::get('get-material/{mq_r_code}', 'BuyOrderController@cuttingOrdersByMaterial')->name('buy_get_cut_ids')->middleware('can:show-buyorders');
                Route::post('receive-order', 'BuyOrderController@receiveOrder')->name('buy.receive_order')->middleware('can:edit-buyorders');
                Route::post('delete-order', 'BuyOrderController@deleteOrder')->name('buy.delete_order')->middleware('can:delete-buyorders');
                Route::get('show-order/{id}', 'BuyOrderController@showOrderPage')->name('buy.show_order')->middleware('can:show-buyorders');
                Route::get('show/{id}', 'BuyOrderController@showOrder')->name('buy.show')->middleware('can:show-buyorders');
                Route::get('order-status/{id}', 'BuyOrderController@getOrderStatus')->name('buy.order_status')->middleware('can:show-buyorders');
                Route::post('update', 'BuyOrderController@updateOrder')->name('buy.update_order')->middleware('can:edit-buyorders');
                Route::post('remove-item', 'BuyOrderController@removeItem')->name('buy.remove_item')->middleware('can:delete-buyorders');
                Route::get('by-shipping/{id}', 'BuyOrderController@buyOrdersWithShippingId')->name('buy.get_buy_shipping')->middleware('can:add-buyorders');
            });


            Route::group([
                'prefix' => 'process'
            ], function () {
                Route::get('get-list', 'OrderProcessController@getAllPaginate')->name('process.get_list')->middleware('can:show-process');
                Route::get('get', 'OrderProcessController@getNewOrders')->name('process.orders_list')->middleware('can:show-process');
                Route::get('get-to-prepare/{id}', 'OrderProcessController@getToPrepare')->name('process.prepare_order_page')->middleware('can:show-process');
                Route::get('get-order/{id}', 'OrderProcessController@prepareOrder')->name('process.order')->middleware('can:add-process');
                Route::post('validate-prod', 'OrderProcessController@validateProduct')->name('process.validate_product')->middleware('can:show-process');
                Route::post('save-order', 'OrderProcessController@saveOrder')->name('process.save_order')->middleware('can:add-process');
                Route::get('ready-orders-page', 'OrderProcessController@readyOrderPage')->name('process.ready_orders_page')->middleware('can:add-process');
                Route::get('ready-order-page/{id}', 'OrderProcessController@readySingleOrderPage')->name('process.ready_order_page')->middleware('can:add-process');
                Route::get('ready-order/{id}', 'OrderProcessController@readyOrder')->name('process.ready_order')->middleware('can:add-process');
                Route::get('done-orders', 'OrderProcessController@doneOrder')->name('process.done_orders_page')->middleware('can:add-process');
                Route::get('done-order-page/{id}', 'OrderProcessController@doneOrderPage')->name('process.done_order_page')->middleware('can:add-process');
                Route::group([
                    'prefix' => 'ready-orders'
                ], function () {
                    Route::get('get-all-packaged', 'ShippingOrderController@packagedList')->name('shipping.list_packaged_orders');
                    Route::get('create-package/{shipping_order_id}', 'ShippingOrderController@packagePage')->name('shipping.create_package_page');
                    Route::get('package/{shipping_order_id}', 'ShippingOrderController@orderToPackage')->name('shipping.order_to_package');
                    Route::post('can-package', 'ShippingOrderController@canPackage')->name('shipping.can_package');
                    Route::post('package-orders', 'ShippingOrderController@packageOrders')->name('shipping.package_orders');
                });
            });

            Route::group([
                'prefix' => 'shipping'
            ], function () {
                Route::get('get-all-paginate', 'ShippingOrderController@index')->name('shipping.get_list');
                Route::get('add-order', 'ShippingOrderController@create')->name('shipping.create_page');
                Route::post('create-order', 'ShippingOrderController@store')->name('shipping.store_order');
                Route::get('get/{id}', 'ShippingOrderController@get')->name('shipping.get');
                Route::get('get-order/{id}', 'ShippingOrderController@getShippingOrder')->name('shipping.get_order');
                Route::get('ready-orders', 'ShippingOrderController@readyToShip')->name('shipping.ready_orders');
                Route::post('save-to-order', 'ShippingOrderController@saveToOrder')->name('shipping.save_to_order');
                Route::post('delete', 'ShippingOrderController@deleteOrder')->name('delete_shipping_order');
                Route::post('update', 'ShippingOrderController@update')->name('shipping.update_order');
                Route::post('update-order-status', 'ShippingOrderController@importShippingStatus')->name('shipping.update_order_status');
                Route::post('import-excel', 'ShippingOrderController@importShippingStatus')->name('shipping.import_excel');
            });
        });

        Route::group([
            'namespace' => 'Products',
            'prefix'    => 'product'
        ], function () {
            Route::get('get-all', 'ProductController@getAllPaginate')->name('product.list');
            Route::get('create', 'ProductController@createPage')->name('product.create_page');
            Route::post('store', 'ProductController@store')->name('product.store');
            Route::get('edit/{product_id}', 'ProductController@editPage')->name('product.edit_page');
            Route::post('update', 'ProductController@update')->name('product.update');
            Route::post('delete', 'ProductController@delete')->name('product.delete');

            Route::group([
                'prefix' => 'type'
            ], function () {
                Route::get('get', 'ProductTypeController@getAll')->name('product.type.get_all');
                Route::get('get-all', 'ProductTypeController@getAllPaginate')->name('product.type.list');
                Route::get('create', 'ProductTypeController@createPage')->name('product.type.create_page');
                Route::post('store', 'ProductTypeController@create')->name('product.type.store');
                Route::post('delete', 'ProductTypeController@delete')->name('product.type.delete');
                Route::get('edit/{type_id}', 'ProductTypeController@editPage')->name('product.type.edit_page');
                Route::post('update', 'ProductTypeController@update')->name('product.type.update');
            });
        });
    });
});
