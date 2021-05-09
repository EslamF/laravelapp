<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Orders\SaveOrder;
use App\Models\Products\Product;


class SendEndProductController extends Controller
{
    public function index()
    {
        $orders = SaveOrder::where('stored' , 0)->get();
        return responseJson(1 , 'success' , $orders );
    }

    public function show(Request $request)
    {
        $rules = [
            'save_order_id' => 'required|exists:sort_orders,id'
        ];

        $validator = validator()->make($request->all() , $rules);
        if($validator->fails())
        {
            return responseJson(0 , $validator->errors()->first() , $validator->errors());
        }
        $order = SaveOrder::with('user:id,name')->find($request->save_order_id);
        return responseJson(1 , 'success' , $order );
    }
    public function store(Request $request)
    {
        $rules = [
            'products' => 'required',
            'user_id'  => 'required|exists:users,id'
        ];
        
        $validator = validator()->make($request->all() , $rules);
        if($validator->fails())
        {
            return responseJson(0 , $validator->errors()->first() , $validator->errors());
        }


        foreach ($request->products as $code) 
        {
            $product = Product::where('prod_code', $code)
                                ->where('sorted', 1)
                                ->where('save_order_id', null)
                                ->where('status' , 'available')
                                ->first();

            if(!$product)
            {
                return responseJson(0 , "لا يمكن إضافة المنتج $code");
            } 
        }


        $order = SaveOrder::create([
            'code' => $this->generateCode() , 
            'user_id' => $request->user_id  
        ]);

        Product::whereIn('prod_code' , $request->products)
                ->update([
                    'save_order_id' => $order->id,
                ]);

      return responseJson(1 , 'success');
    }

    public function update(Request $request)
    {
        $validator = validator()->make($request->all() , [

            'save_order_id' => 'required|exists:save_orders,id' ,
            'products'      => 'required|array',
            'products.*'    => 'exists:products,prod_code',
            'user_id'       => 'required|exists:users,id' , 

        ]);

        if($validator->fails())
        {
            return responseJson(0 , $validator->errors()->first() , $validator->errors());
        }
     

        $order = SaveOrder::findOrFail($request->save_order_id);

        foreach ($request->products as $code) 
        {
            $product = Product::where('prod_code', $code)
                                ->where('sorted', 1)
                                ->where('status' , 'available')
                                ->where(function($query) use($request){
                                    $query->where('save_order_id'   , null)
                                        ->orWhere('save_order_id' , $request->save_order_id );
                                })
                                ->first();

            if(!$product)
            {
                return responseJson(0 , "لا يمكن إضافة المنتج $code");
            } 
        }



        //if the order not stored in the company  .. the stored value is 0 
        if($order->stored == 0)
        {
            $order->update(['user_id' => $request->user_id]);
            // get the products with the save_order_id = $id and change the save_order_id to null
            Product::where('save_order_id' , $order->id)
                    ->update(['save_order_id' => null]);


            // get the products attached with the request and adjust the save_order_id to the given id 

            Product::whereIn('prod_code' , $request->products)
                    ->update(['save_order_id' => $order->id ]);

           return responseJson(1 , 'success');
        }

        else 
        {
            return responseJson(0 , 'لا يمكن التعديل على الطلب');
        }
    
    }

    public function generateCode()
    {
        $code = rand(0, 6000000000000);
        $check = SaveOrder::where('code', $code)->exists();
        if ($check) {
            $this->generateCode();
        } else {
            return $code;
        }
    }
}
