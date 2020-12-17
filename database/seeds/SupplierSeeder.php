<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\User;


class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('suppliers')->insert([
            [
                'name'       => 'مورد1' , 
                'created_by' => User::first()->id , 
            ] , 

            [
                'name'       => 'مورد2' , 
                'created_by' => User::first()->id , 
            ] , 

            [
                'name'       => 'مورد3' , 
                'created_by' => User::first()->id , 
            ] , 

        ]);
    }
}
