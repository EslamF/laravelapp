<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Orders\ShippingOrder;
use App\Models\Orders\BuyOrder;

class ShippingOrderController extends Controller
{
    public function index()
    {
        $orders = ShippingOrder::with('shippingCompany:id,name')->where('status' , 0)->paginate();
        return responseJson(1 , 'success' , $orders);
    }

    public function store(Request $request)
    {
        $rules = [
            'shipping_order_id' => 'required|exists:shipping_orders,id',
            'orders'            => 'required|array',
            'orders.*'          => 'exists:buy_orders,bar_code'
        ];

        $validator = validator()->make($request->all() , $rules);
        if($validator->fails())
        {
            return responseJson(0 , $validator->errors()->first() , $validator->errors());
        }

        $shipping_order = ShippingOrder::find($request->shipping_order_id);
        if($shipping_order->status != 0)
        {
            return responseJson(0 , 'تم شحن الطلب');
        }

        $shpping_order_orders = BuyOrder::select('id', 'bar_code')->whereHas('shippingOrders', function ($q) use ($request) {
                                    $q->where('shipping_orders.id', $request->shipping_order_id);
                                })->get();

        $barcodes = $shpping_order_orders->pluck('bar_code')->toArray();
        $orders = $request->orders;

        sort($barcodes);
        sort($orders);

        if($barcodes != $orders)
        {
            return responseJson(0 , 'الطلبات غير متطابقة مع طلبات إذن الشحن');
        }   

        BuyOrder::whereIn('bar_code', $request->orders)
                    ->update([
                        'preparation' => 'shipped'
                    ]);


        $shipping_order->update(['status' => 1]);
                        
        return responseJson(1 , 'success');
    }
}
