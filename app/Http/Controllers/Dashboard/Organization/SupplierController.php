<?php

namespace App\Http\Controllers\Dashboard\Organization;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Organization\Supplier;

class SupplierController extends Controller
{
    /**
     * 
     * create Supplier 
     * request input name required
     * 
     */
    public function create(Request $request)
    {
        $request->validate([
            'name' => 'required|min:3'
        ]);
        Supplier::create($request->all());
    }
    /**
     * 
     * update supplier 
     * request input supplier_id required
     * 
     */
    public function update(Request $request)
    {
        $request->validate([
            'supplier_id' => 'required|exists:suppliers,id'
        ]);

        Supplier::find($request->supplier_id)->update($request->all());
    }
    /**
     * 
     * get all for select
     * 
     */
    public function getAll()
    {
        $suppliers = Supplier::all();
    }
    /**
     * 
     * get all for pagination
     * 
     */
    public function getAllPaginate()
    {
        $suppliers = Supplier::paginate(15);
    }
    /**
     * 
     * get Supplier by id
     * request input supplier_id
     * 
     */
    public function getSupplierById(Request $request)
    {

        $request->validate([
            'supplier_id' => 'required|exists:suppliers,id'
        ]);
        $supplier = Supplier::where('id', $request->supplier_id)->first();
    }
}