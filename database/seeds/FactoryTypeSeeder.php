<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\User;



class FactoryTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('factory_types')->insert([
            [
                'name'       => 'خارجي' , 
                'created_by' => User::first()->id , 
            ] , 

            [
                'name'       => 'داخلي' , 
                'created_by' => User::first()->id , 
            ] , 

            [
                'name'       => 'تصنيع' , 
                'created_by' => User::first()->id , 
            ] , 

            [
                'name'       => 'كي' , 
                'created_by' => User::first()->id , 
            ] , 
        ]);
    }
}
