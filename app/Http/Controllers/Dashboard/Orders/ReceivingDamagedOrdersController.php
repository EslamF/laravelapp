<?php

namespace App\Http\Controllers\Dashboard\Orders;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Products\Product;
use App\Models\Orders\DamagedProductFixOrder;
use Illuminate\Support\Facades\Session;

class ReceivingDamagedOrdersController extends Controller
{
    public function createPage()
    {
        return view('dashboard.orders.receiving_damaged.create');
    }

    /*public function store(Request $request)
    {
        $this->validate($request,[
            'prod_code' => 'required|exists:products,prod_code'
        ],['prod_code'=>'المنتج غير موجود']);
        
        if(!$request->damage_type) {
            $request->merge([
                'status' => 'available' 
            ]);
        }

        $product = Product::where('prod_code', $request->prod_code)->first();
        DamagedProductFixOrder::where('product_id', $product->id)->delete();
    
        $product->update($request->all());
        return redirect()->route('product.list');
    }*/

    public function store(Request $request)
    {
        $this->validate($request,[
            'products' => 'required|exists:products,prod_code'
        ],['prod_code'=>'المنتج غير موجود']);
        
        if(!$request->damage_type) {
            $request->merge([
                'status' => 'available' 
            ]);
        }

        foreach($request->products as $code)
        {
            $product = Product::where('prod_code', $code)->first();
            DamagedProductFixOrder::where('product_id', $product->id)->delete();
        
            $product->update($request->all());
        }
        
        Session::flash('success',  __('words.delivered_successfully') );
        return response()->json('success' , 200);
        //return redirect()->route('product.list');
    }

    public function checkIfExists(Request $request)
    {
        if($request->filled('prod_code'))
        {
            $product = Product::where('prod_code', $request->prod_code)->first();

            $exists = DamagedProductFixOrder::where('product_id', $product->id)->exists();

            return response()->json($exists, 200);
        }

        
    }

    /*public function store(Request $request)
    {
        $this->validate($request , [
            'prod_codes[]' => 'required|array' , 
            'prod_codes.*' => 'exists:products,prod_code'
        ]);

        if(!$request->damage_type) {
            $request->merge([
                'status' => 'available' 
            ]);
        }

        foreach($request->prod_codes as $pro_code)
        {
            $product = Product::where('prod_code', $prod_code)->first();
            $product->update($request->all());
        }
    }*/
}
