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
                'email'=>'admin@admin.com',
                'email_verified_at'=>'2020-11-01 00:00:00',
                'name'=>'admin',
                'password'=>'$2y$10$IEadymMtBNB2fXXIGx55FOAnnAqmEjPipFDhhsv4qVzZDtkjTcqBq',
            ]
        ]);

    }
}
