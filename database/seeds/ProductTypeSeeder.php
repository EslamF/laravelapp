<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\User;

class ProductTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('product_types')->insert([
            [
                'name'       => 'قميص' , 
                'created_by' => User::first()->id , 
            ] , 

            [
                'name'       => 'بنطلون' , 
                'created_by' => User::first()->id , 
            ] , 

            [
                'name'       => 'فستان' , 
                'created_by' => User::first()->id , 
            ] , 
        ]);
    }
}
