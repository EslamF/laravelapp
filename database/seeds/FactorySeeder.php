<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\User;
use App\Models\Organization\FactoryType;

class FactorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('factories')->insert([
            [
                'name'       => 'مصنع خارجي 1' , 
                'factory_type_id' => FactoryType::where('name' , 'خارجي')->first()->id  ,
                'created_by' => User::first()->id , 
            ] , 

            [
                'name'       => 'مصنع خارجي 2' , 
                'factory_type_id' =>  FactoryType::where('name' , 'خارجي')->first()->id  ,
                'created_by' => User::first()->id , 
            ] , 

            [
                'name'       => 'مصنع داخلي' , 
                'factory_type_id' =>  FactoryType::where('name' , 'داخلي')->first()->id  ,
                'created_by' => User::first()->id , 
            ] , 
        ]);
    }
}
