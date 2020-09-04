<?php

namespace App\Http\Controllers\Dashboard\Materials;

use Illuminate\Http\Request;
use App\Models\Materials\MaterialType;
use App\Http\Controllers\Controller;

class MaterialTypeController extends Controller
{
    /**
     * 
     * create material type 
     * request input name required
     * 
     */
    public function create(Request $request)
    {
        $request->validate([
            'name' => 'required|min:3|unique:material_types,name'
        ]);
        MaterialType::create($request->all());
        return redirect()->route('material.type.list');
    }
    /**
     * 
     * update material type
     * request input type_id required
     * 
     */
    public function update(Request $request)
    {
        $request->validate([
            'type_id' => 'required|exists:material_types,id',
            'name'  => 'required|unique:material_types,name,' . $request->type_id
        ]);

        MaterialType::find($request->type_id)->update($request->all());
        return redirect()->route('material.type.list');
    }
    /**
     * 
     * get all for select
     * 
     */
    public function getAll()
    {
        $types = MaterialType::all();
    }
    /**
     * 
     * get all for pagination
     * 
     */
    public function getAllPaginate()
    {
        $types = MaterialType::paginate(15);
        return view('dashboard.materials.type.list')->with('types', $types);
    }
    /**
     * 
     * edit page
     * request input type_id
     * 
     */
    public function editPage(Request $request)
    {
        $type = MaterialType::where('id', $request->type_id)->first();
        return view('dashboard.materials.type.edit')->with('type', $type);
    }
    /**
     * 
     * create page
     * 
     */
    public function createPage()
    {
        return view('dashboard.materials.type.create');
    }
    /**
     * 
     * delete material type
     * 
     */
    public function delete(Request $request)
    {
        $request->validate([
            'type_id' => 'required|exists:material_types,id'
        ]);
        MaterialType::find($request->type_id)->delete();
        return response()->json('deleted', 200);
    }
}
