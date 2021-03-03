<?php

use Illuminate\Database\Seeder;
use App\Permission;

class AddDeleteAllProductsPermission extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Permission::firstOrCreate(
            ['name' =>  'delete-all-products'],
            ['display_name' => 'حذف جميع المنتجات'] ,
            ['routes' => 'product.delete_all_products' ]
        );

        Permission::firstOrCreate(
            ['name' =>  'import-product-excel-sheet'],
            ['display_name' => 'رفع شيت المنتجات'] ,
            ['routes' => 'product.import_sheet_excel' ]
        );
    }
}
