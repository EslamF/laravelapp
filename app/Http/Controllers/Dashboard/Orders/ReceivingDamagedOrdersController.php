<?php

namespace App\Http\Controllers\Dashboard\Orders;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Products\Product;
use App\Models\Orders\DamagedProductFixOrder;

class ReceivingDamagedOrdersController extends Controller
{
    public function createPage()
    {
        return view('dashboard.orders.receiving_damaged.create');
    }

    public function store(Request $request)
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
    }
}
