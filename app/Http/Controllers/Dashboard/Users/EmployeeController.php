<?php

namespace App\Http\Controllers\Dashboard\Users;

use App\Http\Controllers\Controller;
use App\Models\Users\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\User;

class EmployeeController extends Controller
{
    /**
     * 
     * create employee 
     * request input name required
     * request input email required
     * request input password required
     * request input confimation password required
     * 
     */
    public function create(Request $request)
    {
        $request->validate([
            'name' => 'required|min:3',
            'email' => 'required|email|min:3|unique:users,email',
            'password' => 'required|confirmed',
            'role_id' => 'required|exists:roles,id'
        ]);
        $user = User::create($request->all());
        $user->assignRole($request->role_id);
        return redirect()->route('employee.list');
    }
    /**
     * 
     * update employee 
     * request input employee_id required
     * 
     */
    public function update(Request $request)
    {
        $request->validate([
            'type_id' => 'required|exists:users,id',
            // 'role_id' => 'required|exists:role,id',
            'name' => 'required|min:3',
            'email' => 'min:3|unique:users,email,' . Auth::user()->id,
            'password' => 'confirmed'
        ]);

        $user = User::find($request->type_id);
        $user->update($request->all());
        $user->assignRole($request->role_id);

        return redirect()->route('employee.list');
    }
    public function delete(Request $request)
    {
        $request->validate([
            'type_id' => 'required|exists:users,id'
        ]);
        User::find($request->type_id)->delete();
        return redirect()->route('employee.list');
    }
    /**
     * 
     * get all for select
     * 
     */
    public function getAll()
    {
        $employee = User::select('id', 'name')->get();
        return response()->json($employee, 200);
    }
    /**
     * 
     * get all for pagination
     * 
     */
    public function getAllPaginate()
    {
        $data['user'] = User::with('roles')->paginate(15);
        return view('dashboard.personal.employee.list')->with('data', $data);
    }
    public function editPage($type_id)
    {
        $data['user'] = User::where('id', $type_id)->with('roles')->first();

        $data['roles'] = Role::select('id', 'label')->get();

        return view('dashboard.personal.employee.edit')->with('data', $data);
    }

    public function createPage()
    {
        $roles = Role::select('id', 'label')->get();
        return view('dashboard.personal.employee.create')->with('roles', $roles);;
    }
    /**
     * 
     * get employee by id
     * request input employee_id
     * 
     */
    public function getemployeeById(Request $request)
    {
        $request->validate([
            'type_id' => 'required|exists:users,id'
        ]);
        $employee = User::where('id', $request->type_id)->first();
    }
}
