<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Models\Orders\BuyOrder;
use App\Models\Products\Product;
use Illuminate\Support\Facades\Log;
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

    Route::get('/home', 'HomeController@home')->name('home_page');

    Route::group([
        'namespace' => 'Dashboard' , 
        'middleware' => ['auto-check-permission']
    ],  function () {
        Route::group([
            'namespace' => 'Options'
        ], function () {

           

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
                    Route::get('get-all', 'RoleController@getAllPaginate')->name('role.list');
                    Route::get('create', 'RoleController@createPage')->name('role.create_page');
                    Route::post('store', 'RoleController@create')->name('role.store');
                    Route::post('delete', 'RoleController@delete')->name('role.delete');
                    Route::get('edit/{type_id}', 'RoleController@editPage')->name('role.edit_page');
                    Route::post('update', 'RoleController@update')->name('role.update');
                });

                Route::group([
                    'prefix' => 'employees',
                ], function () {
                    Route::get('get-all-paginate', 'EmployeeController@getAllPaginate')->name('employee.list');
                    Route::get('get-all', 'EmployeeController@getAll')->name('employee.get_all');
                    Route::get('create', 'EmployeeController@createPage')->name('employee.create_page');
                    Route::post('store', 'EmployeeController@create')->name('employee.store');
                    Route::post('delete', 'EmployeeController@delete')->name('employee.delete');
                    Route::get('edit/{type_id}', 'EmployeeController@editPage')->name('employee.edit_page');
                    Route::post('update', 'EmployeeController@update')->name('employee.update');
                });

                Route::group([
                    'prefix' => 'customers',
                ], function () {
                    Route::get('get-all', 'CustomerController@getAllPaginate')->name('customer.list');
                    Route::get('show/{id}', 'CustomerController@show')->name('customer.show');
                    Route::get('create', 'CustomerController@createPage')->name('customer.create_page');
                    Route::post('store', 'CustomerController@create')->name('customer.store');
                    Route::post('delete', 'CustomerController@delete')->name('customer.delete');
                    Route::get('edit/{type_id}', 'CustomerController@editPage')->name('customer.edit_page');
                    Route::post('update', 'CustomerController@update')->name('customer.update');
                    Route::get('search/{phone}', 'CustomerController@searchByPhone')->name('customer_search');
                    Route::get('get/{id}', 'CustomerController@getById')->name('customer.get_by_id');
                });

                Route::group([
                    'prefix' => 'suppliers',
                ], function () {
                    Route::get('get-all', 'SupplierController@getAllPaginate')->name('supplier.list');
                    Route::get('create', 'SupplierController@createPage')->name('supplier.create_page');
                    Route::post('store', 'SupplierController@create')->name('supplier.store');
                    Route::post('delete', 'SupplierController@delete')->name('supplier.delete');
                    Route::get('edit/{type_id}', 'SupplierController@editPage')->name('supplier.edit_page');
                    Route::post('update', 'SupplierController@update')->name('supplier.update');
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
                Route::get('get-all', 'MaterialTypeController@getAllPaginate')->name('material.type.list');
                Route::get('create', 'MaterialTypeController@createPage')->name('material.type.create_page');
                Route::post('store', 'MaterialTypeController@create')->name('material.type.store');
                Route::post('delete', 'MaterialTypeController@delete')->name('material.type.delete');
                Route::get('edit/{type_id}', 'MaterialTypeController@editPage')->name('material.type.edit_page');
                Route::post('update', 'MaterialTypeController@update')->name('material.type.update');
            });
        });
        Route::group([
            'namespace' => 'Organization',

        ], function () {

            Route::group([
                'prefix' => 'shipping'

            ], function () {
                Route::get('get-all', 'ShippingCompanyController@getAllPaginate')->name('shippingcompany.list');
                Route::get('getOrders/{id}' , 'ShippingCompanyController@getOrders')->name('shippingcompany.getOrders');
                Route::post('test', 'ShippingCompanyController@test')->name('shippingcompany.test');
                Route::get('create', 'ShippingCompanyController@createPage')->name('shippingcompany.create_page');
                Route::post('store', 'ShippingCompanyController@create')->name('shippingcompany.store');
                Route::post('delete', 'ShippingCompanyController@destroy')->name('shippingcompany.delete_company');
                Route::get('edit/{type_id}', 'ShippingCompanyController@editPage')->name('shippingcompany.edit_page');
                Route::post('update', 'ShippingCompanyController@update')->name('shippingcompany.update');
                Route::get('get', 'ShippingCompanyController@getAll')->name('shippingcompany.get_all');
            });

            Route::group([
                'prefix' => 'factory'
            ], function () {
                Route::get('get-all', 'FactoryController@getAllPaginate')->name('factory.list');
                Route::get('get-by-id/{factory_type_id}', 'FactoryController@getByType')->name('factory.by_type');
                Route::get('get', 'FactoryController@getAll')->name('factory_get_all');
                Route::get('get-by-cutting/{id}', 'FactoryController@getFactoryByCuttingOrder')->name('factory_by_cutting');
                Route::get('get/{id}', 'FactoryController@getById')->name('factory.get_by_id');
                Route::get('create', 'FactoryController@createPage')->name('factory.create_page');
                Route::post('store', 'FactoryController@create')->name('factory.store');
                Route::post('delete', 'FactoryController@delete')->name('factory.delete');
                Route::get('edit/{type_id}', 'FactoryController@editPage')->name('factory.edit_page');
                Route::post('update', 'FactoryController@update')->name('factory.update');

                Route::group([
                    'prefix' => 'type'
                ], function () {
                    Route::get('get', 'FactoryTypeController@getAll')->name('factory.type_all');
                    Route::get('get-all', 'FactoryTypeController@getAllPaginate')->name('factory.type.list');
                    Route::get('create', 'FactoryTypeController@createPage')->name('factory.type.create_page');
                    Route::post('store', 'FactoryTypeController@create')->name('factory.type.store');
                    Route::post('delete', 'FactoryTypeController@delete')->name('factory.type.delete');
                    Route::get('edit/{type_id}', 'FactoryTypeController@editPage')->name('factory.type.edit_page');
                    Route::post('update', 'FactoryTypeController@update')->name('factory.type.update');
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

                Route::get('get-all', 'ReceivingMaterialController@getAllPaginate')->name('order.receiving.material');
                Route::get('create', 'ReceivingMaterialController@createPage')->name('order.receiving_material.create_page');
                Route::post('store', 'ReceivingMaterialController@store')->name('receiving.material.store');
                Route::get('edit/{material_id}', 'ReceivingMaterialController@editPage')->name('receiving.material.edit_page');
                Route::post('update', 'ReceivingMaterialController@update')->name('receiving.material.update');
                Route::post('delete', 'ReceivingMaterialController@delete')->name('receiving.material.delete');
                Route::get('check-weight/{material_code}', 'ReceivingMaterialController@checkWeight');
                Route::get('getMaterialData/{material_code}', 'ReceivingMaterialController@getMaterialData');
                Route::get('print/{id}', 'ReceivingMaterialController@print')->name('receiving.material.print');
                Route::get('print_vestments/{id}', 'ReceivingMaterialController@print_vestments')->name('receiving.material.print_vestments');
                Route::get('print_vestments2/{ids}', 'ReceivingMaterialController@print_vestments2')->name('receiving.material.print_vestments2');
                Route::post('get_material_from_vestment', 'ReceivingMaterialController@get_material_from_vestment')->name('receiving.material.get_material_from_vestment');
            });

            Route::group([
                'prefix' => 'spreading-material' 
            ], function () {
                Route::get('get-all-hold', 'SpreadingMaterialController@getAllPaginateForHold')->name('spreading.material.hold_list');
                Route::get('get-all-used', 'SpreadingMaterialController@getAllPaginateForUsed')->name('spreading.material.used_list');
                Route::get('get-counter', 'SpreadingMaterialController@counterList')->name('spreading.material.counter_list');
                Route::get('get', 'SpreadingMaterialController@getAll')->name('spreading.get_all');
                Route::get('create', 'SpreadingMaterialController@createPage')->name('spreading.material.create_page');
                Route::post('store', 'SpreadingMaterialController@store')->name('spreading.material.store');
                Route::get('edit/{spreading_id}', 'SpreadingMaterialController@editPage')->name('spreading.material.edit_page');
                Route::post('update', 'SpreadingMaterialController@update')->name('spreading.material.update');
                Route::post('delete', 'SpreadingMaterialController@delete')->name('spreading.material.delete');
                Route::post('checkVestment', 'SpreadingMaterialController@checkVestment')->name('spreading.material.checkVestment');
                Route::post('getVestments', 'SpreadingMaterialController@getVestments')->name('spreading.material.getVestments');
                
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
                Route::get('getProducts/{id}', 'CuttingOrderController@getProducts')->name('cutting_order.getProducts');
                Route::get('getCuttingEmployees' , 'CuttingOrderController@getCuttingEmployees')->name('getCuttingEmployees');

            
            });

            Route::group([
                'prefix' => 'produce'
            ], function () {
                Route::get('get-all', 'ProduceOrderController@getAllPaginate')->name('produce.order.list');
                Route::get('get', 'ProduceOrderController@getAll')->name('produce_order.get_all');
                Route::get('show/{id}', 'ProduceOrderController@show')->name('produce_order.show');
                Route::get('create', 'ProduceOrderController@createPage')->name('produce.order.create');
                Route::post('store', 'ProduceOrderController@store')->name('produce.order.store');
                Route::get('edit/{produce_id}', 'ProduceOrderController@editPage')->name('produce.order.edit_page');
                Route::post('update', 'ProduceOrderController@update')->name('produce.order.update');
                Route::post('delete', 'ProduceOrderController@delete')->name('produce.order.delete');
                Route::post('getAvailableProducts', 'ProduceOrderController@getAvailableProducts')->name('produce_order.getAvailableProducts');
            });

            Route::group([
                'prefix' => 'receiving-products'
            ], function () {
                Route::get('get-all', 'ReceivingProductController@getAllPaginate')->name('receiving.product.list');
                Route::get('get', 'ReceivingProductController@getAll')->name('receiving_orders.get_all');
                Route::get('list/{id}', 'ReceivingProductController@productsToReceive')->name('products_to_receive');
                Route::post('status', 'ReceivingProductController@changeStatus')->name('order_status');
                Route::get('/received/list/{id}', 'ReceivingProductController@productsReceived')->name('products_received');
                Route::get('allProducts/{id}', 'ReceivingProductController@allProducts')->name('receiving_orders.allProducts');
                Route::get('produce-products/{id}', 'ReceivingProductController@orderProduct')->name('receiving_products');
                Route::get('create', 'ReceivingProductController@createPage')->name('receiving.product.create');
                Route::post('store', 'ReceivingProductController@store')->name('receiving.product.store');
                Route::get('edit/{receiving_id}', 'ReceivingProductController@editPage')->name('receiving.product.edit_page');
                Route::post('update', 'ReceivingProductController@update')->name('receiving.product.update');
                Route::post('delete', 'ReceivingProductController@delete')->name('receiving.product.delete');
                Route::post('change-status', 'ReceivingProductController@approveOrUnapprove')->name('receiving_product.change_status');
                Route::post('print_products', 'ReceivingProductController@print_products')->name('receiving_product.print_products');
                Route::post('receive_products_after_printing', 'ReceivingProductController@receive_products_after_printing')->name('receiving_product.receive_products_after_printing');
                Route::post('check_product_before_received', 'ReceivingProductController@check_product_before_received')->name('receiving_product.check_product_before_received');
                Route::get('receive_products_after_printing_view/{id}', 'ReceivingProductController@receive_products_after_printing_view')->name('receiving_product.receive_products_after_printing_view');
            });

            Route::group([
                'prefix' => 'sort'
            ], function () {
                Route::get('get-all', 'SortOrderController@getAllPaginate')->name('sort.order.list');
                Route::get('scanningPage/{id}', 'SortOrderController@scanningPage')->name('sort.order.scanningPage');
                Route::get('create', 'SortOrderController@createPage')->name('sort.order.create_page');
                Route::post('store', 'SortOrderController@store')->name('sort.order.store');
                Route::get('edit/{sort_id}', 'SortOrderController@editPage')->name('sort.order.edit_page');
                Route::post('update', 'SortOrderController@update')->name('sort.order.update');
                Route::post('delete', 'SortOrderController@delete')->name('sort.order.delete');
                Route::get('products/{sort_id}', 'SortOrderController@showSortedProducts')->name('sort.product.list');
                Route::post('product', 'SortOrderController@SortProduct')->name('sort.product');
                Route::post('remove-product', 'SortOrderController@removeSortedProduct')->name('product.sort.delete');

                Route::post('checkProduct', 'SortOrderController@checkProduct')->name('product.sort.checkProduct');
            });

            Route::group([
                'prefix' => 'fix-product'
            ], function () {
                Route::get('create', 'FixProductOrderController@createPage')->name('fix.product.create_page');
                Route::post('store', 'FixProductOrderController@store')->name('fix.product.store');
                Route::get('get-all', 'FixProductOrderController@getAllPaginate')->name('fix.product.list');
                Route::post('delete', 'FixProductOrderController@delete')->name('fix.product.delete');
                Route::post('checkIfSortedAndDamaged' , 'FixProductOrderController@checkIfSortedAndDamaged')->name('fix.product.checkIfSortedAndDamaged');
            });

            Route::group([
                'prefix' => 'receive-damaged-product'
            ], function () {
                Route::get('create', 'ReceivingDamagedOrdersController@createPage')->name('receiving.damaged_product.create_page');
                Route::post('store', 'ReceivingDamagedOrdersController@store')->name('receiving.damaged_product.store');
                Route::post('checkIfExists', 'ReceivingDamagedOrdersController@checkIfExists')->name('receiving.damaged_product.checkIfExists');
                //
            });


            Route::group([
                'prefix' => 'send-end-product'
            ], function () {
                Route::get('get-all', 'SendEndProductController@getAllPaginate')->name('send.end_product.list');
                Route::get('get-all-saved/{save_order}', 'SendEndProductController@getSavedProdacts')->name('send.end_product.get_order');
                Route::get('create', 'SendEndProductController@create')->name('send.end_product.create_page');
                Route::post('store', 'SendEndProductController@store')->name('send.end_product.store');
                Route::post('getProducts', 'SendEndProductController@getProducts')->name('send.end_product.getProducts');
                Route::get('edit/{id}', 'SendEndProductController@edit')->name('send.end_product.edit_page');
                Route::post('update', 'SendEndProductController@update')->name('send.end_product.update');
                Route::get('get-order/{order_code}', 'SendEndProductController@getOrder')->name('send.end_product.get_order');
                Route::post('delete', 'SendEndProductController@delete')->name('send.end_product.delete');
                Route::post('check-if-sorted', 'SendEndProductController@checkIfSorted')->name('send_end_product.check_if_sorted');
            });

            Route::group([
                'prefix' => 'store-end-product'
            ], function () {
                Route::get('get-all', 'StoreProductOrderController@getAllPaginate')->name('store.end_product.list');
                Route::get('create', 'StoreProductOrderController@create')->name('store.end_product.create_page');
                Route::get('order/{id}', 'StoreProductOrderController@getShippingOrder')->name('store.end_product.shipping_list');
                Route::post('store', 'StoreProductOrderController@store')->name('store.end_product.store');
                Route::post('edit/{product_id}', 'StoreProductOrderController@edit')->name('store.end_product.edit_page');
                Route::post('update', 'StoreProductOrderController@update')->name('store.end_product.update');
                Route::get('get-order/{order_code}', 'StoreProductOrderController@getOrder')->name('store.end_product.get_order');
                Route::post('delete', 'StoreProductOrderController@delete')->name('store.end_product.delete');
            });

            Route::group([
                'prefix' => 'buy'
            ], function () {
                Route::get('create', 'BuyOrderController@createPage')->name('buy.create_page');
                Route::get('get-all-paginate', 'BuyOrderController@getAllPaginate')->name('buy.list_page');
                Route::get('get-material/{mq_r_code}', 'BuyOrderController@cuttingOrdersByMaterial')->name('buy_get_cut_ids');
                Route::post('receive-order', 'BuyOrderController@receiveOrder')->name('buy.receive_order');
                Route::post('delete-order', 'BuyOrderController@deleteOrder')->name('buy.delete_order');
                Route::get('show-order/{id}', 'BuyOrderController@showOrderPage')->name('buy.show_order');
                Route::get('show/{id}', 'BuyOrderController@showOrder')->name('buy.show');
                Route::get('order-status/{id}', 'BuyOrderController@getOrderStatus')->name('buy.order_status');
                Route::post('update', 'BuyOrderController@updateOrder')->name('buy.update_order');
                Route::post('remove-item', 'BuyOrderController@removeItem')->name('buy.remove_item');
                Route::get('by-shipping/{id}', 'BuyOrderController@buyOrdersWithShippingId')->name('buy.get_buy_shipping');

                Route::get('edit/{id}', 'BuyOrderController@editPage')->name('buy.edit_page');
                Route::post('edit-order', 'BuyOrderController@editOrder')->name('buy.edit_order');
                Route::get('show-order-in-edit-page/{id}', 'BuyOrderController@showOrderInEditPage')->name('buy.showOrderInEditPage');

                Route::post('export', 'BuyOrderController@export')->name('buy.export');
                Route::get('print', 'BuyOrderController@print')->name('buy.print');
                
            });


            Route::group([
                'prefix' => 'process'
            ], function () {
                Route::get('get-list', 'OrderProcessController@getAllPaginate')->name('process.get_list');
                Route::get('get', 'OrderProcessController@getNewOrders')->name('process.orders_list');
                Route::get('get-rejected_orders/{id}', 'OrderProcessController@receive_rejected_orders_page')->name('process.receive_rejected_orders_page');
                Route::post('receive_rejected_orders_submit', 'OrderProcessController@receive_rejected_orders_submit')->name('process.receive_rejected_orders_submit');
                Route::post('update_the_status_of_done_order', 'OrderProcessController@update_the_status_of_done_order')->name('process.update_the_status_of_done_order');
                Route::get('receive-rejected_orders-page', 'OrderProcessController@getRejectedOrders')->name('process.rejected_orders_list');
                Route::get('get-to-prepare/{id}', 'OrderProcessController@getToPrepare')->name('process.prepare_order_page');
                Route::get('get-order/{id}', 'OrderProcessController@prepareOrder')->name('process.order');
                Route::post('validate-prod', 'OrderProcessController@validateProduct')->name('process.validate_product');
                Route::post('save-order', 'OrderProcessController@saveOrder')->name('process.save_order');
                Route::get('ready-orders-page', 'OrderProcessController@readyOrderPage')->name('process.ready_orders_page');
                Route::get('ready-order-page/{id}', 'OrderProcessController@readySingleOrderPage')->name('process.ready_order_page');
                Route::get('ready-order/{id}', 'OrderProcessController@readyOrder')->name('process.ready_order');
                Route::get('done-orders', 'OrderProcessController@doneOrder')->name('process.done_orders_page');
                Route::get('done-order-page/{id}', 'OrderProcessController@doneOrderPage')->name('process.done_order_page');
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
            Route::get('print/{id}', 'ProductController@print')->name('product.print');
            Route::get('print_products/{ids}', 'ProductController@print_products')->name('product.print_products');
            Route::get('print_receiving_order_products/{ids}', 'ProductController@print_receiving_order_products')->name('product.print_receiving_order_products');
            Route::get('print_material_barcode/{id}', 'ProductController@print_material_barcode')->name('product.print_material_barcode');
            Route::post('delete_all_products' , 'ProductController@delete_all_products')->name('product.delete_all_products');
            Route::get('import_sheet_excel_view' , 'ProductController@import_sheet_excel_view' )->name('product.import_sheet_excel_view');
            Route::post('import_sheet_excel' , 'ProductController@import_sheet_excel' )->name('product.import_sheet_excel');

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


        Route::group([
            'namespace' => 'Reports',
            'prefix'    => 'reports'
        ] , function() {

            Route::get('list'                        , 'ReportController@list')->name('reports.list');
            Route::get('buy_orders'                  , 'ReportController@buy_orders')->name('reports.buy_orders');
            Route::get('sales'                       , 'ReportController@sales')->name('reports.sales');
            Route::get('receiving_materials_orders'  , 'ReportController@receiving_materials_orders')->name('reports.receiving_materials_orders');
            Route::get('spreading_orders'            , 'ReportController@spreading_orders')->name('reports.spreading_orders');
            Route::get('cutting_orders'              , 'ReportController@cutting_orders')->name('reports.cutting_orders');
            Route::get('produce_orders'              , 'ReportController@produce_orders')->name('reports.produce_orders');
            Route::get('receiving_products_orders'   , 'ReportController@receiving_products_orders')->name('reports.receiving_products_orders');
            Route::get('sorting_orders'              , 'ReportController@sorting_orders')->name('reports.sorting_orders');
            Route::get('save_orders'                 , 'ReportController@save_orders')->name('reports.save_orders');
            Route::get('store_orders'                , 'ReportController@store_orders')->name('reports.store_orders');
            Route::get('customers'                   , 'ReportController@customers')->name('reports.customers');
            


        } );

        Route::group([
            'namespace' => 'Alarms',
            'prefix'    => 'alarms'
        ] , function() {
            Route::get('about_to_run_products' , 'ProductsAlarmController@about_to_run_products')->name('alarms.about_to_run_products');
            Route::get('low_sale_products'     , 'ProductsAlarmController@low_sale_products')->name('alarms.low_sale_products');
            Route::get('best_selling_products' , 'ProductsAlarmController@best_selling_products')->name('alarms.best_selling_products');
        } );
    });
});
