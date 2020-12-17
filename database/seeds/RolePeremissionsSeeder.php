<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Permission;



class RolePeremissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = Permission::select('id')->get();
        foreach($permissions as $permission)
        {

            DB::table('permission_role')->insert([
                [
                'role_id'=> 1,
                'permission_id'=>$permission->id,
            ]
    ]);
        }
    }
}
