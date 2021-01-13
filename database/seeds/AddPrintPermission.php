<?php

use Illuminate\Database\Seeder;

class AddPrintPermission extends Seeder
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
                'name' => 'print-product',
                'display_name' => 'طباعة منتج' , 
                'routes' => 'product.print'
            ],
        ]);
    }
}
