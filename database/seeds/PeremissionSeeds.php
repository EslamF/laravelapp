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
                'lable' => 'إضافة خامات'
            ],
            [
                'name' => 'edit-materials',
                'lable' => 'تعديل خامات'
            ],
            [
                'name' => 'show-materials',
                'lable' => 'رؤية خامات'
            ],
            [
                'name' => 'delete-materials',
                'lable' => 'حذف خامات'
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
            ]
        ]);
    }
}
