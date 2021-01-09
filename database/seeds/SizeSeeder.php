<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\User;


class SizeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('sizes')->insert([
            [
                'name'       => 'S' , 
                'created_by' => User::first()->id , 
            ] , 

            [
                'name'       => 'M' , 
                'created_by' => User::first()->id , 
            ] , 

            [
                'name'       => 'L' , 
                'created_by' => User::first()->id , 
            ] , 
        ]);
    }
}
