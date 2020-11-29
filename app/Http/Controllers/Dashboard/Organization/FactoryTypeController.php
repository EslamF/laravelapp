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
            'type' => 'required|unique:factory_types,name,except,id|min:3'
        ]);
        $data['name']= $request->type;
        FactoryType::create($data);

        return redirect()->route('factory.type.list');
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
            'type_id' => 'required|exists:factory_types,id',

        ]);
        

        $data['name']= $request->type;

        
        FactoryType::find($request->type_id)->update($data);
        return redirect()->route('factory.type.list');
    }
    /**
     * 
     * get all for select
     * 
     */
    public function getAll()
    {
        $types = FactoryType::select('id', 'name')->get();
        return response()->json($types, 200);
    }
    /**
     * 
     * get all for 
     * pagination
     * & createpage
     * $ editpage
     */
    public function getAllPaginate()
    {
        $types = FactoryType::paginate(15);
        return view('dashboard.factories.type.list')->with('types', $types);
    }
    public function createPage()
    {
        return view('dashboard.factories.type.create');
    }

    public function editPage($type_id)
    {
        $type = FactoryType::where('id', $type_id)->first();
        return view('dashboard.factories.type.edit')->with('type', $type);
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

    public function delete(Request $request)
    {
        $request->validate([
            'type_id' => 'required|exists:factory_types,id'
        ]);
        FactoryType::find($request->type_id)->delete();

        return redirect()->route('factory.type.list');
    }
}
