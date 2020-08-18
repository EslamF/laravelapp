<?php

namespace App\Http\Controllers\Dashboard\Products;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Products\ProductType;

class ProductTypeController extends Controller
{
    /**
     * 
     * create material type 
     * request input name required
     * 
     */
    public function create(Request $request)
    {
        $request->validate([
            'name' => 'required|min:3'
        ]);
        ProductType::create($request->all());
        return redirect()->route('product.type.list');
    }
    /**
     * 
     * update material type
     * request input type_id required
     * 
     */
    public function update(Request $request)
    {
        $request->validate([
            'type_id' => 'required|exists:product_types,id'
        ]);

        ProductType::find($request->type_id)->update($request->all());
        return redirect()->route('product.type.list');
    }
    /**
     * 
     * get all for select
     * 
     */
    public function getAll()
    {
        $types = ProductType::all();
    }
    /**
     * 
     * get all for pagination
     * 
     */
    public function getAllPaginate()
    {
        $types = ProductType::paginate(15);
        return view('dashboard.products.product_type.list')->with('types', $types);
    }
    /**
     * 
     * edit page
     * request input type_id
     * 
     */
    public function editPage(Request $request)
    {
        $type = ProductType::where('id', $request->type_id)->first();
        return view('dashboard.products.product_type.edit')->with('type', $type);
    }
    /**
     * 
     * create page
     * 
     */
    public function createPage()
    {
        return view('dashboard.products.product_type.create');
    }
    /**
     * 
     * delete product type
     * 
     */
    public function delete(Request $request)
    {
        $request->validate([
            'type_id' => 'required|exists:product_types,id'
        ]);
        ProductType::find($request->type_id)->delete();

        return redirect()->route('product.type.list');
    }

}
