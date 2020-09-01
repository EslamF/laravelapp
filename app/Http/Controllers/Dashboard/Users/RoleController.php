<?php

namespace App\Http\Controllers\Dashboard\Users;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\UsersRequest;
use Illuminate\Http\Request;
use App\Models\Users\Role;
use App\Models\Users\Peremission;


class RoleController extends Controller
{
          /**
     * 
     * create Role 
     * request input name required
     * 
     */
    public function create(UsersRequest $request)
    {


        $role=Role::create($request->all());
        $role->peremissions()->attach($request->peremissions);
        return redirect()->route('role.list');
    }
    /**
     * 
     * update Role 
     * request input type_id required
     * 
     */
    public function update(UsersRequest $request)
    {
        // dd($request->all());
        // dd($request->all());
        $request->validate([
                 'type_id' => 'required|exists:roles,id',
                 ' label' => 'required|min:3',
                //  'description' => 'required',
                //  'peremissions.*' => 'exists|peremission,id'
        ]); 
        $role= Role::where('id', $request->type_id)->first();
        $role->update($request->all());
        // $role->peremissions()->detach();
        $role->allowTo($request->peremissions);

        return redirect()->route('role.list');
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
        $peremissions = Peremission::select('id', 'lable')->get();
        return view('auth.role.create')->with('peremissions', $peremissions);
    }

    public function editPage(Request $request)
    {
        $data=[];
        $data['role']=Role::where('id', $request->type_id)->with('peremissions')->first();
        $data['peremissions']=Peremission::select('id', 'lable')->get();
        $data['peremission_id']=$data['role']->peremissions->pluck('id')->toArray();
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
