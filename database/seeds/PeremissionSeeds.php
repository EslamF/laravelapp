<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PeremissionSeeds extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('peremissions')->insert([
            [
                'name' => 'buy-material',
                'lable' => 'شراء خامات'
            ],
            [
                'name' => 'add-employee',
                'lable' => 'إضافة موظف'
            ],
            [
                'name' => 'edit-employee',
                'lable' => 'تعديل موظف'
            ],
            [
                'name' => 'show-employee',
                'lable' => 'رؤية موظف'
            ],
            [
                'name' => 'delete-employee',
                'lable' => 'حذف موظف'
            ],
            [
                'name' => 'add-factory',
                'lable' => 'إضافة مصنع'
            ],
            [
                'name' => 'edit-factory',
                'lable' => 'تعديل مصنع'
            ],
            [
                'name' => 'show-factory',
                'lable' => 'رؤية مصنع'
            ],
            [
                'name' => 'delete-factory',
                'lable' => 'حذف مصنع'
            ], [
                'name' => 'add-buyorders',
                'lable' => 'إضافة إذن البيع'
            ],
            [
                'name' => 'edit-buyorders',
                'lable' => 'تعديل إذن البيع'
            ],
            [
                'name' => 'show-buyorders',
                'lable' => 'رؤية إذن البيع'
            ],
            [
                'name' => 'delete-buyorders',
                'lable' => 'حذف إذن البيع'
            ],
            [
                'name' => 'add-storeorders',
                'lable' => 'إضافة إذن إستلام منتجات (الشركة)'
            ],
            [
                'name' => 'edit-storeorders',
                'lable' => 'تعديل إذن إستلام منتجات (الشركة)'
            ],
            [
                'name' => 'show-storeorders',
                'lable' => 'رؤية إذن إستلام منتجات (الشركة)'
            ],
            [
                'name' => 'delete-storeorders',
                'lable' => 'حذف إذن إستلام منتجات (الشركة)'
            ],

            [
                'name' => 'add-typefactory',
                'lable' => 'إضافة نوع مصنع'
            ],
            [
                'name' => 'edit-typefactory',
                'lable' => 'تعديل نوع مصنع'
            ],
            [
                'name' => 'show-typefactory',
                'lable' => 'رؤية نوع مصنع'
            ],
            [
                'name' => 'delete-typefactory',
                'lable' => 'حذف نوع مصنع'
            ],
            [
                'name' => 'add-materials',
                'lable' => 'إضافة أنواع خامات'
            ],
            [
                'name' => 'edit-materials',
                'lable' => 'تعديل أنواع خامات'
            ],
            [
                'name' => 'show-materials',
                'lable' => 'رؤية أنواع خامات'
            ],
            [
                'name' => 'delete-materials',
                'lable' => 'حذف أنواع خامات'
            ],
            [
                'name' => 'add-supplier',
                'lable' => 'إضافة موردين'
            ],
            [
                'name' => 'edit-supplier',
                'lable' => 'تعديل موردين'
            ],
            [
                'name' => 'show-supplier',
                'lable' => 'رؤية موردين'
            ],
            [
                'name' => 'delete-supplier',
                'lable' => 'حذف موردين'
            ],
            [
                'name' => 'add-customer',
                'lable' => 'إضافة عملاء'
            ],
            [
                'name' => 'edit-customer',
                'lable' => 'تعديل عملاء'
            ],
            [
                'name' => 'show-customer',
                'lable' => 'رؤية عملاء'
            ],
            [
                'name' => 'delete-customer',
                'lable' => 'حذف عملاء'
            ],[
                'name' => 'search-customer',
                'lable' => 'البحث في بيانات العملاء'
            ],
            [
                'name' => 'add-prodact',
                'lable' => 'إضافة منتجات'
            ],
            [
                'name' => 'edit-prodact',
                'lable' => 'تعديل منتجات'
            ],
            [
                'name' => 'show-prodact',
                'lable' => 'رؤية منتجات'
            ],
            [
                'name' => 'delete-prodact',
                'lable' => 'حذف منتجات'
            ],
            [
                'name' => 'add-prodacttype',
                'lable' => 'إضافة وصف المنتجات'
            ],
            [
                'name' => 'edit-prodacttype',
                'lable' => 'تعديل وصف المنتجات'
            ],
            [
                'name' => 'show-prodacttype',
                'lable' => 'رؤية وصف المنتجات'
            ],
            [
                'name' => 'delete-prodacttype',
                'lable' => 'حذف وصف المنتجات'
            ],
            [
                'name' => 'add-shapping',
                'lable' => 'إضافة شركات الشحن'
            ],
            [
                'name' => 'edit-shapping',
                'lable' => 'تعديل شركات الشحن'
            ],
            [
                'name' => 'show-shapping',
                'lable' => 'رؤية شركات الشحن'
            ],
            [
                'name' => 'delete-shapping',
                'lable' => 'حذف شركات الشحن'
            ],

            [
                'name' => 'add-shappingorders',
                'lable' => 'إضافة إذن الشحن'
            ],
            [
                'name' => 'edit-shappingorders',
                'lable' => 'تعديل إذن الشحن'
            ],
            [
                'name' => 'show-shappingorders',
                'lable' => 'رؤية إذن الشحن'
            ],
            [
                'name' => 'delete-shappingorders',
                'lable' => 'حذف إذن الشحن'
            ], 
            [
                'name' => 'add-sendorders',
                'lable' => 'إضافة إذن خروج منتجات (مصنع)'
            ],
            [
                'name' => 'edit-sendorders',
                'lable' => 'تعديل إذن خروج منتجات (مصنع)'
            ],
            [
                'name' => 'show-sendorders',
                'lable' => 'رؤية إذن خروج منتجات (مصنع)'
            ],
            [
                'name' => 'delete-sendorders',
                'lable' => 'حذف إذن خروج منتجات (مصنع)'
            ], 
            [
                'name' => 'add-receivingordersfix',
                'lable' => 'إضافة إذن إستلام منتجات معدلة'
            ],
            [
                'name' => 'edit-receivingordersfix',
                'lable' => 'تعديل إذن إستلام منتجات معدلة'
            ],
            [
                'name' => 'show-receivingordersfix',
                'lable' => 'رؤية إذن إستلام منتجات معدلة'
            ],
            [
                'name' => 'delete-receivingordersfix',
                'lable' => 'حذف إذن إستلام منتجات معدلة'
            ], 
            [
                'name' => 'add-fixproductout',
                'lable' => 'إضافة إذن خروج منتجات تالفة'
            ],
            [
                'name' => 'edit-fixproductout',
                'lable' => 'تعديل إذن خروج منتجات تالفة'
            ],
            [
                'name' => 'show-fixproductout',
                'lable' => 'رؤية إذن خروج منتجات تالفة'
            ],
            [
                'name' => 'delete-fixproductout',
                'lable' => 'حذف إذن خروج منتجات تالفة'
            ], 

            [
                'name' => 'add-sortorders',
                'lable' => 'إضافة إذن فرز'
            ],
            [
                'name' => 'edit-sortorders',
                'lable' => 'تعديل إذن فرز'
            ],
            [
                'name' => 'show-sortorders',
                'lable' => 'رؤية إذن فرز'
            ],
            [
                'name' => 'delete-sortorders',
                'lable' => 'حذف إذن فرز'
            ],
            [
                'name' => 'add-matrialreceiving',
                'lable' => 'إضافة إذن إستلام خامات'
            ],
            [
                'name' => 'edit-matrialreceiving',
                'lable' => 'تعديل إذن إستلام خامات'
            ],
            [
                'name' => 'show-matrialreceiving',
                'lable' => 'رؤية إذن إستلام خامات'
            ],
            [
                'name' => 'delete-matrialreceiving',
                'lable' => 'حذف إذن إستلام خامات'
            ],
            [
                'name' => 'add-receivingproduct',
                'lable' => 'إضافة شركات الشحن'
            ],
            [
                'name' => 'edit-receivingproduct',
                'lable' => 'تعديل شركات الشحن'
            ],
            [
                'name' => 'show-receivingproduct',
                'lable' => 'رؤية شركات الشحن'
            ],
            [
                'name' => 'delete-receivingproduct',
                'lable' => 'حذف شركات الشحن'
            ],

            [
                'name' => 'add-produceorder',
                'lable' => 'إضافة إذن تصنيع'
            ],
            [
                'name' => 'edit-produceorder',
                'lable' => 'تعديل إذن تصنيع'
            ],
            [
                'name' => 'show-produceorder',
                'lable' => 'رؤية إذن تصنيع'
            ],
            [
                'name' => 'delete-produceorder',
                'lable' => 'حذف إذن تصنيع'
            ],

            [
                'name' => 'add-process',
                'lable' => 'إضافة المخزن'
            ],
            [
                'name' => 'edit-process',
                'lable' => 'تعديل المخزن'
            ],
            [
                'name' => 'show-process',
                'lable' => 'رؤية المخزن'
            ],
            [
                'name' => 'delete-process',
                'lable' => 'حذف المخزن'
            ],

            [
                'name' => 'add-cutting',
                'lable' => 'إضافة إذن القص'
            ],
            [
                'name' => 'edit-cutting',
                'lable' => 'تعديل إذن القص'
            ],
            [
                'name' => 'show-cutting',
                'lable' => 'رؤية إذن القص'
            ],
            [
                'name' => 'delete-cutting',
                'lable' => 'حذف إذن القص'
            ],
            [
                'name' => 'add-spreading',
                'lable' => 'إضافة أذونات الفرش'
            ],
            [
                'name' => 'edit-spreading',
                'lable' => 'تعديل أذونات الفرش'
            ],
            [
                'name' => 'show-spreading',
                'lable' => 'رؤية أذونات الفرش'
            ],
            [
                'name' => 'delete-spreading',
                'lable' => 'حذف أذونات الفرش'
            ],
            [
                'name' => 'add-customer',
                'lable' => 'إضافة عميل'
            ],
            [
                'name' => 'edit-customer',
                'lable' => 'تعديل عميل'
            ],
            [
                'name' => 'show-customer',
                'lable' => 'رؤية عميل'
            ],
            [
                'name' => 'delete-customer',
                'lable' => 'حذف عميل'
            ],
            [
                'name' => 'add-supplier',
                'lable' => 'إضافة مورد'
            ],
            [
                'name' => 'edit-supplier',
                'lable' => 'تعديل مورد'
            ],
            [
                'name' => 'show-supplier',
                'lable' => 'رؤية مورد'
            ],
            [
                'name' => 'delete-supplier',
                'lable' => 'حذف مورد'
            ],
            [
                'name' => 'add-product_type',
                'lable' => 'إضافة نوع منتج'
            ],
            [
                'name' => 'edit-product_type',
                'lable' => 'تعديل نوع منتج'
            ],
            [
                'name' => 'show-product_type',
                'lable' => 'رؤية نوع منتج'
            ],
            [
                'name' => 'delete-product_type',
                'lable' => 'حذف نوع منتج'
            ],[
                'name' => 'add-role',
                'lable' => 'إضافة وظيفة'
            ],
            [
                'name' => 'edit-role',
                'lable' => 'تعديل وظيفة'
            ],
            [
                'name' => 'show-role',
                'lable' => 'رؤية وظيفة'
            ],
            [
                'name' => 'delete-role',
                'lable' => 'حذف وظيفة'
            ],

        ]);
    }
}