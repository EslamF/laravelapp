<?php

namespace App\Http\Controllers\Dashboard\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
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
            'email' => 'required|min:3',
            'password' => 'required|confirmed',
        ]);
        User::create($request->all());
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
            'type_id' => 'required|exists:users,id'
        ]);

        User::find($request->type_id)->update($request->all());
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
        $types = User::paginate(15);
        return view('dashboard.personal.employee.list')->with('types', $types);
    }
    public function editPage($type_id)
    {
        $type = User::where('id', $type_id)->first();
        return view('dashboard.personal.employee.edit')->with('type', $type);
    }

    public function createPage()
    {
        return view('dashboard.personal.employee.create');
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
