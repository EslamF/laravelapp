<?php

namespace App\Http\Controllers\Dashboard\Orders;

use App\Http\Controllers\Controller;
use App\Models\Orders\BuyOrder;
use App\Models\Orders\ShippingOrder;
use App\Models\Orders\ShippingProcess;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ShippingOrderController extends Controller
{
    public function index()
    {
        $orders = ShippingOrder::select('id', 'shipping_code', 'shipping_date')->paginate();
        return view('dashboard.orders.shipping_order.list', ['orders' => $orders]);
    }

    public function create()
    {
        return view('dashboard.orders.shipping_order.create');
    }

    public function get($id)
    {
        return view('dashboard.orders.shipping_order.edit', ['id' => $id]);
    }

    public function getShippingOrder($id)
    {
        $shipping = ShippingOrder::with('buyOrders:buy_order_id as id,bar_code')->where('id', $id)->first();
        return response()->json($shipping, 200);
    }

    public function readyToShip()
    {
        $orders = BuyOrder::select('id', 'delivery_date', 'customer_id')
            ->with('customer:id,address')
            ->where('preparation', 'prepared')
            ->doesntHave('shippingOrders')
            ->get();

        $orders = $orders->map(function ($item) {
            return [
                'id'            => $item->id,
                'delivery_date' => $item->delivery_date,
                'address'       => $item->customer->address
            ];
        });

        return response()->json($orders, 200);
    }

    public function saveToOrder(Request $request)
    {

        $shipping = ShippingOrder::create([
            'shipping_code' => $this->generateCode(),
            'shipping_date' => $request->shipping_date,
            'shipping_company_id' => $request->shipping_company_id
        ]);

        $ids = collect($request->orders);
        $shipping->buyOrders()->attach($ids->pluck('id'));

        return response()->json('success', 200);
    }

    public function update(Request $request)
    {
        $shipping = ShippingOrder::where('id', $request->shipping_id)->first();
        $shipping->update([
            'shipping_date' => $request->shipping_date,
            'shipping_company_id' => $request->shipping_company_id,
        ]);
        $ids = collect($request->orders);
        $shipping->buyOrders()->sync($ids->pluck('id'));

        return response()->json('success', 200);
    }

    public function generateCode()
    {
        $code = rand(0, 6000000000000);
        $check = ShippingOrder::where('shipping_code', $code)->exists();
        if ($check) {
            $this->generateCode();
        } else {
            return $code;
        }
    }

    public function deleteOrder(Request $request)
    {
        ShippingOrder::find($request->id)->delete();
        return redirect()->back();
    }

    public function packagedList()
    {
        $orders = ShippingOrder::where('status', 1)->with('shippingCompany:id,name')->paginate();
        return view('dashboard.orders.shipping_order.ready-to-ship.list', ['orders' => $orders]);
    }

    public function packagePage()
    {
        return view('dashboard.orders.shipping_order.ready-to-ship.create');
    }

    public function canPackage()
    {
        $orders = ShippingOrder::with('shippingCompany:id,name')->where('status', 0)->get();
        $orders = $orders->map(function ($item) {
            return [
                'id'            => $item->id,
                'company_name'  => $item->shippingCompany->name,
                'shipping_date' => $item->shipping_date
            ];
        });

        return response()->json($orders, 200);
    }

    public function packageOrders(Request $request)
    {
        ShippingOrder::find($request->id)->update([
            'status' => $request->status
        ]);
        if ($request->status == 1) {
            return response()->json('success', 200);
        } else {
            return redirect()->back();
        }
    }
}
