<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Users\Peremission;



class RolePeremissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $peremissions = Peremission::select('id', 'lable')->get();
        foreach($peremissions as $peremission)
        {

            DB::table('peremission_role')->insert([
                [
                'role_id'=> 1,
                'peremission_id'=>$peremission->id,
            ]
    ]);
        }
    }
}
