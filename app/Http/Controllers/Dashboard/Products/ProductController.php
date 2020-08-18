<?php

namespace App\Http\Controllers\Dashboard\Products;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Products\Product;
use App\Models\Orders\ReceivingOrder;

class ProductController extends Controller
{
    public function getAllPaginate()
    {
        $products = Product::paginate();
        return view('dashboard.products.product.list')->with('products', $products);
    }

    public function createPage()
    {
        $receiving_orders = ReceivingOrder::select('id')->get();
        return view('dashboard.products.product.create')->with('receiving_orders', $receiving_orders);
    }

    public function store(Request $request)
    {
        $request->validate([
            'receiving_order_id' => 'required|exists:receiving_orders,id',
            'prod_code'          => 'required|min:3',
            'damaged'            => 'required|in:0,1',
            'sorted'             => 'required|in:0,1',
            'description'        => 'min:3'
        ]);

        Product::create($request->all());
        return redirect()->route('product.list');
    }

    public function editPage($product_id)
    {   
        $data = [];
        $data['receiving_orders'] = ReceivingOrder::select('id')->get();
        $data['product'] = Product::where('id', $product_id)->first();
        return view('dashboard.products.product.edit')->with('data', $data);
    }


    public function update(Request $request)
    {
        $request->validate([
            'product_id'         => 'required|exists:products,id',
            'receiving_order_id' => 'exists:receiving_orders,id',
            'prod_code'          => 'min:3',
            'damaged'            => 'in:0,1',
            'sorted'             => 'in:0,1',
            'description'        => 'min:3'
        ]);

        Product::find($request->product_id)->update($request->all());
        return redirect()->route('product.list');
    }

    public function delete(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);
        
        Product::find($request->product_id)->delete();
        return redirect()->route('product.list');

    }
}
