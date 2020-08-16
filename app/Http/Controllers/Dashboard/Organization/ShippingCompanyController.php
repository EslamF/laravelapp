<?php

namespace App\Http\Controllers\Dashboard\Organization;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Organization\ShippingCompany;

class ShippingCompanyController extends Controller
{
    /**
     * 
     * create Shipping company 
     * request input name required
     * 
     */
    public function create(Request $request)
    {
        $request->validate([
            'name' => 'required|min:3'
        ]);
        ShippingCompany::create($request->all());
    }
    /**
     * 
     * update shipping company 
     * request input shipping_company_id required
     * 
     */
    public function update(Request $request)
    {
        $request->validate([
            'shipping_company_id' => 'required|exists:shipping_companies,id'
        ]);

        ShippingCompany::find($request->shipping_company_id)->update($request->all());
    }
    /**
     * 
     * get all for select
     * 
     */
    public function getAll()
    {
        $shipingCompanies = ShippingCompany::all();
    }
    /**
     * 
     * get all for pagination
     * 
     */
    public function getAllPaginate()
    {
        $shipingCompanies = ShippingCompany::paginate(15);
    }
    /**
     * 
     * get shipping company by id
     * request input shipping_company_id
     * 
     */
    public function getShippingCompanyById(Request $request)
    {

        $request->validate([
            'shipping_company_id' => 'required|exists:shipping_companies,id'
        ]);
        $shippingCompany = ShippingCompany::where('id', $request->shipping_company_id)->first();
    }
}