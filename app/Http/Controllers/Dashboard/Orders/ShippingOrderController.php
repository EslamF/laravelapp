<?php

namespace App\Http\Controllers\Dashboard\Orders;

use App\Http\Controllers\Controller;
use App\Imports\OrderStatusImport;
use App\Models\Orders\BuyOrder;
use App\Models\Orders\OrderStatus;
use App\Models\Orders\ShippingOrder;
use App\Models\Organization\ShippingCompany;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use Validator;

class ShippingOrderController extends Controller
{
    public function index()
    {
        $orders = ShippingOrder::select('id', 'shipping_code', 'shipping_date' , 'created_at')->where(function($query){

            if(request()->filled('shipping_company'))
            {
                $query->where('shipping_company_id' , request()->shipping_company );
            }
            
        })->paginate();

        $shipping_companies = ShippingCompany::get();
        return view('dashboard.orders.shipping_order.list', ['orders' => $orders , 'shipping_companies' => $shipping_companies]);
    }

    public function create()
    {
        return view('dashboard.orders.shipping_order.create');
    }

    public function get($id)
    {
        $shipping = ShippingOrder::with('buyOrders:id,bar_code as id,bar_code')->where('id', $id)->first();
        //return $shipping;
        return view('dashboard.orders.shipping_order.edit', ['id' => $id]);
    }

    public function getShippingOrder($id)
    {
        $shipping = ShippingOrder::with('buyOrders:id,bar_code as id,bar_code')->where('id', $id)->first();
        //     $orders = BuyOrder::select('id', 'delivery_date', 'customer_id')
        //     ->with('customer:id,address') 
        //     ->whereHas('shippingOrders', function ($q) use ($id) {
        //         $q->where('shipping_orders.id', $id);
        //     })
        //     ->get();

        // $orders = $orders->map(function ($item) {
        //     return [
        //         'id'            => $item->id,
        //         'delivery_date' => $item->delivery_date,
        //         'address'       => $item->customer->address
        //     ];
        // });
        return response()->json($shipping, 200);
    }

    public function readyToShip()
    {
        $orders = BuyOrder::select('id', 'delivery_date', 'customer_id')
            ->with('customer:id,address')
            ->where('preparation', 'prepared')
            ->where('confirmation' , 'confirmed')
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
        $orders = ShippingOrder::where('status', 0)->with('shippingCompany:id,name')->paginate();
        return view('dashboard.orders.shipping_order.ready-to-ship.list', ['orders' => $orders]);
    }

    public function packagePage($shipping_order_id)
    {
        $shippingOrder = ShippingOrder::where('id', $shipping_order_id)->first();
        $orders = BuyOrder::select('id', 'bar_code')->whereHas('shippingOrders', function ($q) use ($shipping_order_id) {
            $q->where('shipping_orders.id', $shipping_order_id);
        })->get();

        return view('dashboard.orders.shipping_order.ready-to-ship.create', ['id' => $shippingOrder->id , 'orders' => $orders]);
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
        foreach ($request->orders as $order) {
            $item = BuyOrder::where('bar_code', $order)->first();
            $item->update([
                'preparation' => 'shipped'
            ]);
        }
        ShippingOrder::find($request->id)->update([
            'status' => $request->status
        ]);
        if ($request->status == 1) {
            return response()->json('success', 200);
        } else {
            return redirect()->back();
        }
    }

    public function orderToPackage($shipping_order_id)
    {
        $orders = ShippingOrder::where('id', $shipping_order_id)
            ->with('shippingCompany:id,name')
            ->where('status', 0)->first();

        $data = [
            'id'            => $orders->id,
            'company_name'  => $orders->shippingCompany->name,
            'shipping_date' => $orders->shipping_date
        ];
        return response()->json($data, 200);
    }

    public function importShippingStatus(Request $request)
    {

        Excel::import(new OrderStatusImport, $request->file);
        return redirect()->back()->with('success' , 'تم الرفع بنجاح');
    }
}
