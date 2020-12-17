<?php

namespace App\Http\Controllers\Dashboard\Products;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Products\ProductType;
use App\Models\Products\Product;

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
            'name' => 'required|min:3|unique:product_types,name'
        ]);

        ProductType::create($request->all());
        return redirect()->route('product.type.list')->with('success' , __('words.added_successfully') );
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
            'type_id' => 'required|exists:product_types,id' ,
            'name'    => 'required|min:3|unique:product_types,name,' . $request->type_id
        ]);

        ProductType::find($request->type_id)->update($request->all());
        return redirect()->route('product.type.list')->with('success' , __('words.updated_successfully') );
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

    public function getAll()
    {
        $productType =  ProductType::select('id', 'name')->get();
        return response()->json($productType, 200);
    }
}
