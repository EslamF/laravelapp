<?php

use Illuminate\Database\Seeder;

class ShippingFollowingPermissions extends Seeder
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
                'name' => 'shipping-following',
                'display_name' => 'متابعة الشحنات' , 
                'routes' => 'buy.shipping_following'
            ],
        ]);
    }
}
