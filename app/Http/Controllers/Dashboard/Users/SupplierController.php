<?php

namespace App\Http\Controllers\Dashboard\Users;

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
        return redirect()->route('supplier.list');
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
        return redirect()->route('supplier.list');

    }
    public function delete(Request $request)
    {
        $request->validate([
            'type_id' => 'required|exists:suppliers,id'
        ]);
        Supplier::find($request->type_id)->delete();


        return redirect()->route('supplier.list');
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
        return view('dashboard.personal.supplier.list')->with('suppliers', $suppliers);
    }
    public function editPage( $supp_id)
    {
        $supplier = Supplier::where('id', $supp_id)->first();
        return view('dashboard.personal.supplier.edit')->with('supplier', $supplier);
    }

    public function createPage()
        {
            return view('dashboard.personal.supplier.create');
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