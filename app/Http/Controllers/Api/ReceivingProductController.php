<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Orders\ReceivingOrder;
use App\Models\Products\Product;
use App\Models\Orders\ProduceOrder;

class ReceivingProductController extends Controller
{
    public function index()
    {
        $orders = ReceivingOrder::where('status' , 0)->paginate();
        return responseJson(1 , 'success' , $orders);
    }

    public function show(Request $request)
    {
        $rules = [
            'order_id' => 'required|exists:receiving_orders,id',
        ];

        $validator = validator()->make($request->all() , $rules);
        if($validator->fails())
        {
            return responseJson(0 , $validator->errors()->first() , $validator->errors());
        }

        $order = ReceivingOrder::find($request->order_id);

        $order->number_of_products = Product::where('receiving_order_id' , $order->id)
                                        ->where('received' , 0)
                                        ->count();
            

        return responseJson(1 , 'success' , $order);
    }

    public function store(Request $request)
    {
        $rules = [
            'order_id' => 'required|exists:receiving_orders,id',
            'products' => 'required|array',
            'products.*' => 'required|exists:products,prod_code'
        ];

        $validator = validator()->make($request->all() , $rules);
        if($validator->fails())
        {
            return responseJson(0 , $validator->errors()->first() , $validator->errors());
        }

        $receiveOrder = ReceivingOrder::find($request->order_id);

        if($receiveOrder->status  != 0)
        {
            return responseJson(0 , 'تم إستلام الطلب من قبل');
        }

        $produce_order = ProduceOrder::where('id' , $receiveOrder->produce_order_id)->first();
   

        $count = Product::where('receiving_order_id' , $receiveOrder->id)
                        ->where('received' , 0)
                        ->count();

        if(count($request->products) != $count )
        {
            return responseJson(0 , "يجب إدخال $count من المنتجات" );
        }

        foreach($request->products as $product_code)
        {
             $p = Product::where('prod_code' , $product_code)
                        ->where('receiving_order_id' , $request->receiving_order_id)
                        ->where('received' , 0)
                        ->first();
            if(!$p)
            {
                return responseJson(0 , "لا يمكن إضافة المنتج $product_code");
            }
        }


        $products = Product::whereIn('prod_code' , $request->products)
                            ->where('receiving_order_id' , $receiveOrder->id)
                            ->where('received' , 0)
                            ->update(['received' => 1]);
       
    
        $receiveOrder->update(['status' => 1]);

        $check = Product::where('produce_order_id' , $receiveOrder->produce_order_id )->where('received' , 0)->exists();
        if ($check) 
        {
            $produce_order->update(['status' => 0]);
        } 
        else 
        {
            $produce_order->update(['status' => 1]);
        }

        return reponseJson(1 , 'success');

    }
}
