<?php

namespace App\Http\Controllers\Dashboard\Options;

use App\Http\Controllers\Controller;
use App\Models\Options\Size;
use Illuminate\Http\Request;

use function PHPSTORM_META\type;

class SizeController extends Controller
{
    /**
     * 
     * create Size 
     * request input name required
     * 
     */
    public function create(Request $request)
    {
        $request->validate([
            'name' => 'required|min:3'
        ]);
        Size::create($request->all());
        return redirect()->route('size.list');
    }
    /**
     * 
     * update Size 
     * request input type_id required
     * 
     */
    public function update(Request $request)
    {
        $request->validate([
            'type_id' => 'required|exists:sizes,id'
        ]);

        Size::find($request->type_id)->update($request->all());
        return redirect()->route('size.list');
    }
     /**
     * 
     * delete size 
     * request input type_id required
     * 
     */
    public function delete(Request $request)
    {
        $request->validate([
            'type_id' => 'required|exists:sizes,id'
        ]);
        Size::find($request->type_id)->delete();

        return redirect()->route('size.list');
    }
    /**
     * 
     * get all for select
     * 
     */
    public function getAll()
    {
        $types = Size::all();
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
        $types = Size::paginate(15);
        return view('dashboard.options.size.list')->with('types', $types);
    }

    public function createPage()
    {
        return view('dashboard.options.size.create');
    }

    public function editPage( $type_id)
    {
        $type = Size::where('id', $type_id)->first();
        return view('dashboard.options.size.edit')->with('type', $type);
    }
    /**
     * 
     * get Size by id
     * request input size_id
     * 
     */
    public function getSizeById(Request $request)
    {
        $request->validate([
            'type_id' => 'required|exists:sizes,id'
        ]);
        $type = Size::where('id', $request->type_id)->first();
    }
}