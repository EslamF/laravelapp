<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\User;


class ShippingCompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('shipping_companies')->insert([
            [
                'name'       => 'شركة شحن1' , 
                'created_by' => User::first()->id , 
            ] , 

            [
                'name'       => 'شركة شحن2' , 
                'created_by' => User::first()->id , 
            ] , 

            [
                'name'       => 'شركة شحن3' , 
                'created_by' => User::first()->id , 
            ] , 

        ]);
    }
}
