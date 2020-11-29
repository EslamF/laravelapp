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
                'name'=>'admin',
                'password'=>'$2y$10$IEadymMtBNB2fXXIGx55FOAnnAqmEjPipFDhhsv4qVzZDtkjTcqBq',
                'email_verified_at' => now(),
            ] , 
            /*[
                'email' => 'i@gmail.com' ,
                'name' => 'Admin' ,
                'password' => '$2y$10$eSA/JZilXgKTj1wAYd8TFOXdr2zyCF/RhglPNXSDimlXOUgGxd4PC',
                'email_verified_at' => now(),
            ]*/
        ]);

    }
}
