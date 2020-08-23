<?php

namespace App\Http\Controllers\Dashboard\Options;

use App\Http\Controllers\Controller;
use App\Models\Options\Color;
use Illuminate\Http\Request;

class ColorController extends Controller
{
      /**
     * 
     * create color 
     * request input name required
     * 
     */
    public function create(Request $request)
    {
        // dd($request->all());N
        $request->validate([
            'name' => 'required|min:3'
        ]);
        Color::create($request->all());
        return redirect()->route('color.list');
    }
    /**
     * 
     * update color 
     * request input type_id required
     * 
     */
    public function update(Request $request)
    {
        $request->validate([
            'type_id' => 'required|exists:colors,id'
        ]);

        Color::find($request->type_id)->update($request->all());
        return redirect()->route('color.list');
    }
    /**
     * 
     * delete color 
     * request input type_id required
     * 
     */
    public function delete(Request $request)
    {
        $request->validate([
            'type_id' => 'required|exists:colors,id'
        ]);
        Color::find($request->type_id)->delete();


        return redirect()->route('color.list');
    }
    /**
     * 
     * get all for select
     * 
     */
    public function getAll()
    {
        $types = Color::all();
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
        $types = Color::paginate(15);
        return view('dashboard.options.color.list')->with('types', $types);


    }
    public function createPage()
    {
        return view('dashboard.options.color.create');
    }

    public function editPage( $type_id)
    {
        $type = Color::where('id', $type_id)->first();
        return view('dashboard.options.color.edit')->with('type', $type);
    }

    /**
     * 
     * get color by id
     * request input type_id
     * 
     */
    public function getcolorById(Request $request)
    {
        $request->validate([
            'type_id' => 'required|exists:colors,id'
        ]);
        $type = Color::where('id', $request->type_id)->first();
    }
    
}
