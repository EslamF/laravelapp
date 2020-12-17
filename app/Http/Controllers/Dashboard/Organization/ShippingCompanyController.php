<?php

namespace App\Http\Controllers\Dashboard\Organization;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Organization\ShippingCompany;

class ShippingCompanyController extends Controller
{
    /**
     * 
     * create shipping 
     * request input name required
     * 
     */
    public function create(Request $request)
    {
        // dd($request->all());N
        $request->validate([
            'name' => 'required|min:3|unique:shipping_companies,name'
        ]);
        ShippingCompany::create($request->all());
        return redirect()->route('shippingcompany.list')->with('success' , __('words.added_successfully') );
    }
    /**
     * 
     * update shipping 
     * request input type_id required
     * 
     */
    public function update(Request $request)
    {
        $request->validate([
            'type_id' => 'required|exists:shipping_companies,id' ,
            'name' => 'required|min:3|unique:shipping_companies,name,' . $request->type_id
        ]);

        ShippingCompany::find($request->type_id)->update($request->all());
        return redirect()->route('shippingcompany.list')->with('success' , __('words.updated_successfully') );
    }
    /**
     * 
     * delete shipping 
     * request input type_id required
     * 
     */
    public function destroy(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'type_id' => 'required|exists:shipping_companies,id'
        ]);

        $shapping = ShippingCompany::find($request->type_id);
        $shapping->delete();
        return redirect()->route('shippingcompany.list');
    }
    /**
     * 
     * get all for select
     * 
     */
    public function getAll()
    {
        $companies = ShippingCompany::select('id', 'name')->get();
        return response()->json($companies, 200);
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
        $types = ShippingCompany::paginate(15);
        return view('dashboard.shipping.list')->with('types', $types);
    }
    public function createPage()
    {
        return view('dashboard.shipping.create');
    }

    public function editPage($type_id)
    {
        $type = ShippingCompany::where('id', $type_id)->first();
        return view('dashboard.shipping.edit')->with('type', $type);
    }

    /**
     * 
     * get shipping by id
     * request input type_id
     * 
     */
    public function getshippingById(Request $request)
    {
        $request->validate([
            'type_id' => 'required|exists:shipping_companies,id'
        ]);
        $type = ShippingCompany::where('id', $request->type_id)->first();
    }
}
