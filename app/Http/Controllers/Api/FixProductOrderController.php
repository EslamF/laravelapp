<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request; 
use App\Models\Products\Product;
use App\Models\Orders\DamagedProductFixOrder;

class FixProductOrderController extends Controller
{
    public function store(Request $request)
    {
        $validator = validator()->make($request->all() , [

            'products' => 'required|array',
            'products.*' => 'exists:products,prod_code' ,
            'factory_id' => 'required|exists:factories,id'
        ]);


        if($validator->fails())
        {
            return responseJson(0 , $validator->errors()->first() , $validator->errors());
        }


        foreach($request->products as $prod_code)
        {
            $product = Product::where('prod_code', $prod_code)
                                ->where('status', 'damaged')
                                ->where('sorted', 1)
                                ->first();
            if(!$product)
            {
                return responseJson(0 , "لا يمكن إضافة المنتج $prod_code");
            }

            else
            {
                $exists = DamagedProductFixOrder::where('product_id' , $product->id)->exists();
                if($exists)
                {
                    return responseJson(0 , "لا يمكن إضافة المنتج $prod_code");
                }
            }

        }

        foreach($request->products as $prod_code)
        {
            $product = Product::where('prod_code', $prod_code)
                                ->where('status', 'damaged')
                                ->where('sorted', 1)
                                ->first();
            if($product)
            {
                $record =  new DamagedProductFixOrder();
                $record->product_id = $product->id;
                $record->factory_id = $request->factory_id;
                $record->save();
            }
        }

        return responseJson(1 , 'success');


    }
}
