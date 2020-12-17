<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\User;

class MaterialTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('material_types')->insert([
            [
                'name'       => 'كتان' , 
                'created_by' => User::first()->id , 
            ] , 

            [
                'name'       => 'قطن' , 
                'created_by' => User::first()->id , 
            ] , 
        ]);
    }
}
