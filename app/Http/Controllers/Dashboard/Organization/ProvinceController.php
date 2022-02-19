<?php

namespace App\Http\Controllers\Dashboard\Organization;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Organization\Province;

class ProvinceController extends Controller
{
    /**
     * 
     * create Factory province
     * request input name required
     * 
     */
    public function create(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:provinces,name|min:3'
        ]);

        Province::create($request->all());

        return redirect()->route('province.list')->with('success' , __('words.added_successfully'));
    }
    
    public function update(Request $request)
    {
        $request->validate([
            'province_id' => 'required|exists:provinces,id',
            'name'        => 'required|min:3|unique:provinces,name,' . $request->province_id ,
        ]);

        Province::find($request->province_id)->update($request->all());
        return redirect()->route('province.list')->with('success' , __('words.updated_successfully'));
    }
    /**
     * 
     * get all for select
     * 
     */
    public function getAll()
    {
        $provinces = Province::select('id', 'name')->get();
        return response()->json($provinces, 200);
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
        $provinces = Province::paginate(15);
        return view('dashboard.provinces.list')->with('provinces', $provinces);
    }
    public function createPage()
    {
        return view('dashboard.provinces.create');
    }

    public function editPage($province_id)
    {
        $province = Province::where('id', $province_id)->first();
        return view('dashboard.provinces.edit')->with('province', $province);
    }
    /**
     * 
     * get Province by id
     * request input factory_province_id
     * 
     */
    public function getProvinceById(Request $request)
    {
        $request->validate([
            'province_id' => 'required|exists:provinces,id'
        ]);
        $province = Province::where('id', $request->province_id)->first();
    }

    public function delete(Request $request)
    {
        $request->validate([
            'province_id' => 'required|exists:provinces,id'
        ]);
        Province::find($request->province_id)->delete();

        return redirect()->route('province.list');
    }
}
