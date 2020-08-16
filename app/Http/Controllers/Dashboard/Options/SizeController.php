<?php

namespace App\Http\Controllers\Dashboard\Options;

use App\Http\Controllers\Controller;
use App\Models\Options\Size;
use Illuminate\Http\Request;

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
            'size_id' => 'required|exists:sizes,id'
        ]);

        Size::find($request->size_id)->update($request->all());
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
     * get all for pagination
     * 
     */
    public function getAllPaginate()
    {
        $type = Size::paginate(15);
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
            'size_id' => 'required|exists:sizes,id'
        ]);
        $type = Size::where('id', $request->size_id)->first();
    }
}