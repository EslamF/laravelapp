<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Orders\StoreProductOrder;
use App\Models\Orders\BuyOrderProduct;
use App\Models\Orders\SaveOrder;
use App\Models\Products\Product;

class StoreEndProductController extends Controller
{
    public function store(Request $request)
    {
        $rules = [
            'save_order_id' => 'required|exists:save_orders,id',
            'products'      => 'required|array',
            'products.*'    => 'exists:products,prod_code',
        ];

        $validator = validator()->make($request->all() , $rules);
        if($validator->fails())
        {
            return responseJson(0 , $validator->errors()->first() , $validator->errors());
        }

        $save_order = SaveOrder::find($request->save_order_id);
        $order_products = Product::where('save_order_id' , $request->save_order_id)->pluck('prod_code')->toArray();

        if($save_order->stored == 1)
        {
            return responseJson(0 , 'تم إستلام الطلب من قبل');
        }

        if(count($order_products) != count($request->products))
        {
            return responseJson(0 , "يجب إضافة " . count($order_products) . " من المنتجات" );
        }
        $added_products = [];
        foreach($request->products as $product_code)
        {
            if(in_array($product_code , $order_products) && !in_array($product_code , $added_products)  )
            {
                array_push($added_products , $product_code);
            }
            else 
            {
                return responseJson(0 , "لا يمكن إضافة المنتج $product_code ");
            }
        }
        
        StoreProductOrder::create([
            'code' => $this->generateCode(),
            'save_order_id' => $request->save_order_id
        ]);

        $order = SaveOrder::find($request->save_order_id)->update([
            'stored' => 1
        ]);

        $this->addQtyToOrders($request->save_order_id);
        return responseJson(1 , 'success');
    }

    public function addQtyToOrders($save_order_id)
    {
        $products = Product::where('save_order_id', $save_order_id)->get()->groupBy('produce_code');
        $products = $products->map->count();
        foreach ($products as $key => $count) {

            $orders = BuyOrderProduct::where('produce_code', $key)
                ->where('factory_qty', '>', 0)
                ->get();

            if ($count > 0) {
                foreach ($orders as $order) {
                    if ($order->factory_qty <= $count) {
                        $order->company_qty += $order->factory_qty;
                        $order->factory_qty = 0;
                        $order->save();
                    } else {
                        $order->factory_qty -= $count;
                        $order->company_qty += $count;
                        $order->save();
                    }
                }
            }
        }
        return true;
    }

    public function generateCode()
    {
        $code = rand(0, 6000000000000);
        $check = StoreProductOrder::where('code', $code)->exists();
        if ($check) {
            $this->generateCode();
        } else {
            return $code;
        }
    }
}
