<?php

use Illuminate\Database\Seeder;

class SalesPermissions extends Seeder
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
                'name' => 'materials-inventory',
                'display_name' => 'جرد الخامات' , 
                'routes' => 'receiving.material.pending_vestments'
            ],
        ]);

        DB::table('permissions')->insert([
            [
                'name' => 'sales',
                'display_name' => 'المبيعات' , 
                'routes' => 'buy.sales'
            ],
        ]);
    }
}
