<?php

namespace App\Http\Controllers\Dashboard\Users;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\UsersRequest;
use Illuminate\Http\Request;
use App\Role;
use App\Permission;


class RoleController extends Controller
{
          /**
     * 
     * create Role 
     * request input name required
     * 
     */
    public function create(Request $request)
    {
        $request->validate([
            'name'         => 'required|min:3|max:191|unique:roles,name',
            'display_name' => 'required|min:3|max:191',
            'description'  => 'nullable|min:3|max:191',
            'permissions'  => 'nullable|array'
        ]);
        $role=Role::create($request->all());
        //$role->allowTo($request->permissions);
        $role->attachPermissions($request->permissions); // parameter can be a Permission object, array or id

        return redirect()->route('role.list')->with('success' , __('words.added_successfully') );
    }
    /**
     * 
     * update Role 
     * request input type_id required
     * 
     */
    public function update(Request $request)
    {
        //return $request->type_id;
        // dd($request->all());
        // dd($request->all());
        $request->validate([ 
                 'type_id' => 'required|exists:roles,id',
                 'name' => 'required|min:3|unique:roles,name,'.$request->type_id ,
                 'display_name' => 'required|min:3|max:191',
                'description'  => 'nullable|min:3|max:191',
                'permissions'  => 'nullable|array'
        ]); 
        $role = Role::findOrFail($request->type_id);
        $role->update($request->all());
        //$role->permissions()->detach();
        //$role->allowTo($request->permissions);
        $role->syncPermissions($request->permissions);

        return redirect()->route('role.list')->with('success' , __('words.updated_successfully') );
    }
    /**
     * 
     * delete Role 
     * request input type_id required
     * 
     */
    public function delete(Request $request)
    {

    
        $request->validate([
            'type_id' => 'required|exists:roles,id'
        ]);
        Role::find($request->type_id)->delete();
        return redirect()->route('role.list');
    }
    /**
     * 
     * get all for select
     * 
     */
    public function getAll()
    {
        $types = Role::all();
    }
    /**
     * 
     * get all for
     *    pagination
     *  & createPage
     *  & editPage  
     * 
     */
    public function getAllPaginate()
    {
        $types = Role::paginate(15);
        return view('auth.role.list')->with('types', $types);

    }
    public function createPage()
    {
        $permissions = Permission::get();
        return view('auth.role.create')->with('permissions', $permissions);
    }

    public function editPage(Request $request)
    {
        $data=[];
        $data['role'] = Role::where('id', $request->type_id)->with('permissions')->first();
        $data['permissions'] = Permission::get();
        $data['permission_id'] = $data['role']->permissions->pluck('id')->toArray();
        // dd($data['peremission_id']);
        return view('auth.role.edit')->with('data', $data);

    }

    /**
     * 
     * get Role by id
     * request input type_id
     * 
     */
    public function getroleById(Request $request)
    {
        $request->validate([
            'type_id' => 'required|exists:roles,id'
        ]);
        $type = Role::where('id', $request->type_id)->first();
    }
}
