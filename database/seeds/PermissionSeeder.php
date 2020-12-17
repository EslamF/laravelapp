<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionSeeder extends Seeder 
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    { 

        DB::table('permissions')->insert([
            [
                'name' => 'buy-material',
                'display_name' => 'شراء خامات' , 
                'routes' => null
            ],
            [
                'name' => 'spreading-material',
                'display_name' => 'موظف لإذن الفرش' , 
                'routes' => null
            ],
            [
                'name' => 'cutting-material',
                'display_name' => 'موظف لإذن القص' , 
                'routes' => null
            ],
            //employees
            [
                'name' => 'add-employee',
                'display_name' => 'إضافة موظف' ,
                'routes' => 'employee.create_page,employee.store' ,
            ],
            [
                'name' => 'edit-employee',
                'display_name' => 'تعديل موظف' , 
                'routes' => 'employee.edit_page,employee.update' ,
            ],
            [
                'name' => 'show-employee',
                'display_name' => 'عرض الموظفين' ,
                'routes' => 'employee.list,employee.get_all' ,
            ],
            [
                'name' => 'delete-employee',
                'display_name' => 'حذف موظف' ,
                'routes' => 'employee.delete' ,
            ],
            // factories
            [
                'name' => 'add-factory',
                'display_name' => 'إضافة مصنع' ,
                'routes' => 'factory.create_page,factory.store' ,
            ],
            [
                'name' => 'edit-factory',
                'display_name' => 'تعديل مصنع' ,
                'routes' => 'factory.edit_page,factory.update' ,
            ],
            [
                'name' => 'show-factory',
                'display_name' => 'عرض المصانع' ,
                'routes' => 'factory.list,factory_get_all,factory.get_by_id' ,
            ],
            [
                'name' => 'delete-factory',
                'display_name' => 'حذف مصنع' ,
                'routes' => 'factory.delete' ,
            ],

            //sizes
            [
                'name' => 'delete-size',
                'display_name' => 'حذف مقاس' ,
                'routes' => 'size.delete' ,
            ],
            [
                'name' => 'add-size',
                'display_name' => 'إضافة مقاسات' ,   
                'routes' => 'size.create_page,size.store' ,
            ],
            [
                'name' => 'edit-size',
                'display_name' => 'تعديل مقاس' ,
                'routes' => 'size.edit_page,size.update' ,
            ],
            [
                'name' => 'show-size',
                'display_name' => 'عرض المقاسات' ,
                'routes' => 'size.list' ,
            ],
            //factory types
            [
                'name' => 'add-factory-type', 
                'display_name' => 'إضافة نوع مصنع' ,
                'routes' => 'factory.type.create_page,factory.type.store' ,
            ],
            [
                'name' => 'edit-factory-type',
                'display_name' => 'تعديل نوع مصنع' ,
                'routes' => 'factory.type.edit_page,factory.type.update' ,
            ],
            [
                'name' => 'show-factory-type',
                'display_name' => 'عرض أنواع المصانع' ,
                'routes' => 'factory.type_all,factory.type.list' ,
            ],
            [
                'name' => 'delete-factory-type',
                'display_name' => 'حذف نوع مصنع' ,
                'routes' => 'factory.type.delete' ,
            ],
            // material types
            [
                'name' => 'add-material',
                'display_name' => 'إضافة نوع خامة' ,
                'routes' => 'material.type.create_page,material.type.store' ,
            ],
            [
                'name' => 'edit-material',
                'display_name' => 'تعديل نوع خامة' ,
                'routes' => 'material.type.edit_page,material.type.update' ,
            ],
            [
                'name' => 'show-material',
                'display_name' => 'عرض أنواع الخامات' ,
                'routes' => 'material.type.list,' ,
            ],
            [
                'name' => 'delete-material',
                'display_name' => 'حذف نوع خامة' ,
                'routes' => 'material.type.delete' ,
            ],
            // suppliers
            [
                'name' => 'add-supplier',
                'display_name' => 'إضافة مورد' ,
                'routes' => 'supplier.create_page,supplier.store' ,
            ],
            [
                'name' => 'edit-supplier',
                'display_name' => 'تعديل مورد' ,
                'routes' => 'supplier.edit_page,supplier.update' ,
            ],
            [
                'name' => 'show-supplier',
                'display_name' => 'عرض الموردين' ,
                'routes' => 'supplier.list' ,
            ],
            [
                'name' => 'delete-supplier',
                'display_name' => 'حذف مورد' ,
                'routes' => 'supplier.delete' ,
            ],
            //customers
            [
                'name' => 'add-customer',
                'display_name' => 'إضافة عميل' ,
                'routes' => 'customer.create_page,customer.store' ,
            ],
            [
                'name' => 'edit-customer',
                'display_name' => 'تعديل عميل' ,
                'routes' => 'customer.edit_page,customer.update' ,
            ],
            [
                'name' => 'show-customer',
                'display_name' => 'عرض العملاء' ,
                'routes' => 'customer.list' ,
            ],
            [
                'name' => 'delete-customer',
                'display_name' => 'حذف عميل' ,
                'routes' => 'customer.delete' ,
            ],
            //products
            [
                'name' => 'add-product',
                'display_name' => 'إضافة منتج' ,
                'routes' => 'product.create_page,product.store' , 
            ],
            [
                'name' => 'edit-product',
                'display_name' => 'تعديل منتج' ,
                'routes' => 'product.edit_page,product.update' ,
            ],
            [
                'name' => 'show-product',
                'display_name' => 'عرض المنتجات' ,
                'routes' => 'product.list' ,
            ],
            [
                'name' => 'delete-product',
                'display_name' => 'حذف منتج' ,
                'routes' => 'product.delete' ,
            ],
            //product type
            [
                'name' => 'add-product-type',
                'display_name' => 'إضافة نوع منتج' ,
                'routes' => 'product.type.create_page,product.type.store' ,
            ],
            [
                'name' => 'edit-product-type',
                'display_name' => 'تعديل نوع منتج' ,
                'routes' => 'product.type.edit_page,product.type.update' ,
            ],
            [
                'name' => 'show-product-type',
                'display_name' => 'عرض أنواع المنتجات' ,
                'routes' => 'product.type.list' ,
            ],
            [
                'name' => 'delete-product-type',
                'display_name' => 'حذف منتج' ,
                'routes' => 'product.type.delete' ,
            ],
            //shipping companies
            [
                'name' => 'add-shipping-company',
                'display_name' => 'إضافة شركات شحن' ,
                'routes' => 'shippingcompany.create_page,shippingcompany.store' ,
            ],
            [
                'name' => 'edit-shipping-company',
                'display_name' => 'تعديل شركة شحن' ,
                'routes' => 'shippingcompany.edit_page,shippingcompany.update' ,
            ],
            [
                'name' => 'show-shipping-company',
                'display_name' => 'عرض شركات الشحن' ,
                'routes' => 'shippingcompany.list,shippingcompany.get_all' ,
            ],
            [
                'name' => 'delete-shipping-company',
                'display_name' => 'حذف شركة شحن' ,
                'routes' => 'shippingcompany.delete_company' ,
            ],

            // roles
            [
                'name' => 'add-role',
                'display_name' => 'إضافة وظيفة' ,
                'routes' => 'role.create_page,role.store' ,
            ],
            [
                'name' => 'edit-role',
                'display_name' => 'تعديل وظيفة' ,
                'routes' => 'role.edit_page,role.update' ,
            ],
            [
                'name' => 'show-role',
                'display_name' => 'عرض الوظائف' ,
                'routes' => 'role.list' ,
            ],
            [
                'name' => 'delete-role',
                'display_name' => 'حذف وظيفة' ,
                'routes' => 'role.delete' ,
            ],
             // receiving material
            [
                'name' => 'add-receiving-material',
                'display_name' => 'إضافة إذن إستلام خامات' ,
                'routes' => 'order.receiving_material.create_page,receiving.material.store' , 
            ],
            [
                'name' => 'edit-receiving-material',
                'display_name' => 'تعديل إذن إستلام خامات' ,
                'routes' => 'receiving.material.edit_page,receiving.material.update' ,
            ],
            [
                'name' => 'show-receiving-material',
                'display_name' => 'عرض أذونات إستلام الخامات' ,
                'routes' => 'order.receiving.material' ,
            ],
            [
                'name' => 'delete-receiving-material',
                'display_name' => 'حذف إذن إستلام خامات' ,
                'routes' => 'receiving.material.delete' ,
            ],
            // spreading 
            [
                'name' => 'add-spreading-order',
                'display_name' => 'إضافة إذن فرش' ,
                'routes' => 'spreading.material.create_page,spreading.material.store' ,
            ],
            [
                'name' => 'edit-spreading-order',
                'display_name' => 'تعديل إذن فرش' ,
                'routes' => 'spreading.material.edit_page,spreading.material.update' ,
            ],
            [
                'name' => 'show-spreading-order',
                'display_name' => 'عرض أذونات الفرش' ,
                'routes' => 'spreading.material.hold_list,spreading.material.used_list,spreading.get_all' ,
            ],
            [
                'name' => 'delete-spreading-order',
                'display_name' => 'حذف إذن فرش' ,
                'routes' => 'spreading.material.delete' ,
            ],

             // cutting order
            [
                'name' => 'add-cutting-order',
                'display_name' => 'إضافة إذن قص' ,
                'routes' => 'cutting.material.create_page,cutting.material.store' ,
            ],
            [
                'name' => 'edit-cutting-order',
                'display_name' => 'تعديل إذن قص' ,
                'routes' => 'cutting.material.edit_page,cutting.material.update' ,
            ],
            [
                'name' => 'show-cutting-order',
                'display_name' => 'عرض أذونات القص' ,
                'routes' => 'cutting.outer_list,cutting.material.counter_inner_list,cutting.material.hold_list,cutting.material.used_list,cutting.factory_list' ,
            ],
            [
                'name' => 'delete-cutting-order',
                'display_name' => 'حذف إذن قص ' ,
                'routes' => 'cutting.material.delete' ,
            ],
            //produce order
            [
                'name' => 'add-produce-order',
                'display_name' => 'إضافة إذن تصنيع' ,
                'routes' => 'produce.order.create,produce.order.store' ,
            ],
            [
                'name' => 'edit-produce-order',
                'display_name' => 'تعديل إذن تصنيع' ,
                'routes' => 'produce.order.edit_page,produce.order.update' ,
            ],
            [
                'name' => 'show-produce-order',
                'display_name' => 'عرض أذونات التصنيع' ,
                'routes' => 'produce.order.list,produce_order.get_all,produce_order.show' ,
            ],
            [
                'name' => 'delete-produce-order',
                'display_name' => 'حذف إذن تصنيع' ,
                'routes' => 'produce.order.delete' ,
            ],
            //receiving products
            [
                'name' => 'add-receiving-product',
                'display_name' => 'إضافة إذن استلام منتجات' ,
                'routes' => 'receiving.product.create,receiving.product.store' ,
            ],
            [
                'name' => 'edit-receiving-product',
                'display_name' => 'تعديل إذن استلام منتجات' ,
                'routes' => 'receiving.product.edit_page,receiving.product.update' ,
            ],
            [
                'name' => 'show-receiving-product',
                'display_name' => 'عرض أذونات استلام المنتجات' ,
                'routes' => 'receiving.product.list,receiving_orders.get_all' ,
            ],
            [
                'name' => 'delete-receiving-product',
                'display_name' => 'حذف إذن استلام منتجات' ,
                'routes' => 'receiving.product.delete' ,
            ],

            //sort orders
            [
                'name' => 'add-sort-order',
                'display_name' => 'إضافة إذن فرز' ,
                'routes' => 'sort.order.create_page,sort.order.store' ,
            ],
            [
                'name' => 'edit-sort-order',
                'display_name' => 'تعديل إذن فرز' ,
                'routes' => 'sort.order.edit_page,sort.order.update' ,
            ],
            [
                'name' => 'show-sort-order',
                'display_name' => 'عرض أذونات الفرز' ,
                'routes' => 'sort.product.list,sort.order.list,' ,
            ],
            [
                'name' => 'delete-sort-order',
                'display_name' => 'حذف إذن فرز' ,
                'routes' => 'sort.order.delete' ,
            ],
            [
                'name' => 'delete-sort-order-products',
                'display_name' => 'حذف منتجات من إذن الفرز' ,
                'routes' => 'product.sort.delete' ,
            ],

             //fix produts
            [
                'name' => 'add-fix-product-out',
                'display_name' => 'إضافة إذن خروج منتجات تالفة' ,
                'routes' => 'fix.product.create_page,fix.product.store' ,
            ],
            /*[
                'name' => 'edit-fix-product-out',
                'display_name' => 'تعديل إذن خروج منتجات تالفة' ,
                'routes' => '' ,
            ],*/
            [
                'name' => 'show-fix-product-out',
                'display_name' => 'عرض أذوانات خروج المنتجات التالفة' ,
                'routes' => 'fix.product.list' ,
            ],
            [
                'name' => 'delete-fix-product-out',
                'display_name' => 'حذف إذن خروج منتجات تالفة' ,
                'routes' => 'fix.product.delete' ,
            ], 
            //receive damaged products
            [
                'name' => 'add-receiving-order-fix',
                'display_name' => 'إضافة إذن إستلام منتجات معدلة' ,
                'routes' => 'receiving.damaged_product.create_page,receiving.damaged_product.store' ,
            ],
            [
                'name' => 'edit-receiving-order-fix',
                'display_name' => 'تعديل إذن إستلام منتجات معدلة' ,
                'routes' => '' ,
            ],
            [
                'name' => 'show-receiving-order-fix',
                'display_name' => 'عرض إذن إستلام منتجات معدلة' ,
                'routes' => '' ,
            ],
            [
                'name' => 'delete-receiving-order-fix',
                'display_name' => 'حذف إذن إستلام منتجات معدلة' ,
                'routes' => '' ,
            ], 
            // send order
            [
                'name' => 'add-send-order',
                'display_name' => 'إضافة إذن خروج منتجات (مصنع)' ,
                'routes' => 'send.end_product.create_page,send.end_product.store' ,
            ],
            [
                'name' => 'edit-send-order',
                'display_name' => 'تعديل إذن خروج منتجات (مصنع)' ,
                'routes' => 'send.end_product.edit_page,send.end_product.update' ,
            ],
            [
                'name' => 'show-send-order',
                'display_name' => 'عرض أذونات خروج منتجات (مصنع)' ,
                'routes' => 'send.end_product.list,send.end_product.get_order' ,
            ],
            [
                'name' => 'delete-send-order',
                'display_name' => 'حذف إذن خروج منتجات (مصنع)' ,
                'routes' => 'send.end_product.delete' ,
            ], 
            // store orders
            [
                'name' => 'add-store-order',
                'display_name' => 'إضافة إذن إستلام منتجات (الشركة)' ,
                'routes' => 'store.end_product.create_page,store.end_product.store' ,
            ],
            /*[
                'name' => 'edit-store-order',
                'display_name' => 'تعديل إذن إستلام منتجات (الشركة)' ,
                'routes' => 'store.end_product.edit_page,store.end_product.update' ,
            ],*/
            [
                'name' => 'show-store-order',
                'display_name' => 'عرض أذوانات إستلام المنتجات (الشركة)' ,
                'routes' => 'store.end_product.list,store.end_product.get_order' ,
            ],
            [
                'name' => 'delete-store-order',
                'display_name' => 'حذف إذن إستلام منتجات (الشركة)' ,
                'routes' => 'store.end_product.delete' ,
            ],
           
            //buy orders
            [
                'name' => 'add-buy-order', 
                'display_name' => 'إضافة إذن بيع' ,
                'routes' => 'buy.create_page,buy.receive_order' ,
            ],
            [
                'name' => 'edit-buy-order',
                'display_name' => 'تعديل إذن بيع' ,
                'routes' => 'buy.update_order,buy.edit_order,buy.showOrderInEditPage' ,
            ],
            [
                'name' => 'show-buy-order',
                'display_name' => 'عرض أذونات البيع' ,
                'routes' => 'buy.list_page,buy.show_order' ,
            ],
            [
                'name' => 'delete-buy-order',
                'display_name' => 'حذف إذن بيع' ,
                'routes' => 'buy.delete_order,buy.remove_item' ,
            ],
            // process
            [
                'name' => 'show-process',
                'display_name' => 'عرض المخزن' ,
                'routes' => 'process.get_list,process.orders_list,process.ready_orders_page,shipping.list_packaged_orders,process.done_orders_page,process.ready_orders_page,process.ready_order_page,shipping.list_packaged_orders,shipping.create_package_page,process.done_orders_page,process.done_order_page' ,
            ],
            [
                'name' => 'prepare-orders',
                'display_name' => 'تحضير الطلبات الجديدة' ,
                'routes' => 'process.prepare_order_page,process.order' , 
            ],
            //shipping orders
            [
                'name' => 'add-shipping-order',
                'display_name' => 'إضافة إذن الشحن' ,
                'routes' => 'shipping.create_page,shipping.store_order' ,
            ],
            [
                'name' => 'edit-shipping-order',
                'display_name' => 'تعديل إذن الشحن' ,
                'routes' => '' ,
            ],
            [
                'name' => 'show-shipping-order',
                'display_name' => 'عرض إذن الشحن' ,
                'routes' => 'shipping.get_list,shipping.get,shipping.get_order' ,
            ],
            [
                'name' => 'delete-shipping-order',
                'display_name' => 'حذف إذن الشحن' ,
                'routes' => 'delete_shipping_order' ,
            ], 
            [
                'name' => 'upload-file-shipping-order' ,
                'display_name' => 'إضافة شيت' , 
                'routes' => 'shipping.import_excel',
            ] ,
            //Reports
            [
                'name' => 'reports' ,
                'display_name' => 'عرض التقارير' , 
                'routes' => 'reports.list,reports.buy_orders,reports.sales,reports.spreading_orders,reports.cutting_orders,reports.produce_orders,reports.receiving_products_orders,reports.sorting_orders,reports.save_orders,reports.store_orders,reports.customers',
            ] ,

            //Receive returned orders
            [
                'name' => 'returned_orders' ,
                'display_name' => 'إستلام الطلبات المرفوضة' , 
                'routes' => 'process.receive_rejected_orders_page,process.receive_rejected_orders_submit',
            ] ,

        ]);
    }
}