<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Products\Product;
use App\Models\Orders\DamagedProductFixOrder;

class ReceivingDamagedOrdersController extends Controller
{
    public function store(Request $request)
    {
        $rules = [
            'products' => 'required|exists:products,prod_code',
            'damage_type' => 'required|in:ironing,tailoring,dyeing,fine'
        ];
     
        $validator = validator()->make($request->all() , $rules);
        if($validator->fails())
        {
            return responseJson(0 , $validator->errors()->first() , $validator->errors());
        }


        if(!$request->damage_type || $request->damage_type == 'fine') {
            $request->merge([
                'status' => 'available' 
            ]);
        }

        foreach($request->products as $code)
        {
            $product = Product::where('prod_code', $code)->first();
            if(!$product)
            {
                return responseJson(0 , "لا يمكن إضافة المنتج $code");
            }

            $order = DamagedProductFixOrder::where('product_id', $product->id)->first();
            if(!$order)
            {
                return responseJson(0 , "لا يمكن إضافة المنتج $code");
            }
        }

        foreach($request->products as $code)
        {
            $product = Product::where('prod_code', $code)->first();
            DamagedProductFixOrder::where('product_id', $product->id)->delete();
        
            $product->update($request->all());
        }
        
        return responseJson(1 , 'success');
    }
}
