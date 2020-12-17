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
                'name'       => 's' , 
                'created_by' => User::first()->id , 
            ] , 

            [
                'name'       => 'm' , 
                'created_by' => User::first()->id , 
            ] , 

            [
                'name'       => 'lg' , 
                'created_by' => User::first()->id , 
            ] , 

            [
                'name'       => 'xl' , 
                'created_by' => User::first()->id , 
            ] , 
        ]);
    }
}
