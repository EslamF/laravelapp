<?php

namespace App\Http\Controllers\Dashboard\Organization;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Organization\FactoryType;

class FactoryTypeController extends Controller
{
    /**
     * 
     * create Factory type
     * request input name required
     * 
     */
    public function create(Request $request)
    {
        $request->validate([
            'name' => 'required|min:3'
        ]);
        FactoryType::create($request->all());
    }
    /**
     * 
     * update Factory type
     * request input factory_type_id required
     * 
     */
    public function update(Request $request)
    {
        $request->validate([
            'factory_type_id' => 'required|exists:factory_types,id'
        ]);

        FactoryType::find($request->factory_type_id)->update($request->all());
    }
    /**
     * 
     * get all for select
     * 
     */
    public function getAll()
    {
        $types = FactoryType::all();
    }
    /**
     * 
     * get all for pagination
     * 
     */
    public function getAllPaginate()
    {
        $type = FactoryType::paginate(15);
    }
    /**
     * 
     * get FactoryType by id
     * request input factory_type_id
     * 
     */
    public function getFactoryTypeById(Request $request)
    {

        $request->validate([
            'factory_type_id' => 'required|exists:factory_types,id'
        ]);
        $type = FactoryType::where('id', $request->factory_type_id)->first();
    }
}