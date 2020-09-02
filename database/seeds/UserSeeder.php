<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('users')->insert([
            [
                'email'=>'atya@gmail.com',
                'name'=>'atya',
                'password'=>'$2y$10$IEadymMtBNB2fXXIGx55FOAnnAqmEjPipFDhhsv4qVzZDtkjTcqBq',
            ]
        ]);

    }
}
