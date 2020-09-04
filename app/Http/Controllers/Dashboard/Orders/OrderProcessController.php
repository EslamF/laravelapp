<?php

namespace App\Http\Controllers\Dashboard\Orders;

use App\Http\Controllers\Controller;
use App\Models\Options\Size;
use App\Models\Orders\BuyOrder;
use App\Models\Orders\BuyOrderProduct;
use App\Models\Products\Product;
use App\Models\Products\ProductType;
use Illuminate\Http\Request;

class OrderProcessController extends Controller
{
    public function getAllPaginate()
    {
        return view('dashboard.orders.buy_process.list');
    }

    public function getNewOrders()
    {
        $orders = BuyOrder::select('id', 'bar_code', 'delivery_date', 'confirmation')
            ->whereHas('buyOrderProducts', function ($q) {
                $q->where('factory_qty', 0);
            })
            ->where('confirmation', '!=', 'canceled')
            ->where('preparation', 'need_prepare')
            ->where('status', 0)
            ->paginate();

        return view('dashboard.orders.buy_process.new_orders', ['orders' => $orders]);
    }

    public function getToPrepare($id)
    {
        return view('dashboard.orders.buy_process.prepare_page', ['id' => $id]);
    }

    public function prepareOrder($id)
    {
        $order = BuyOrder::where('id', $id)->first();

        $order = $order->buyOrderProducts->map(function ($item) use ($id) {

            $type = ProductType::whereHas('products', function ($q) use ($item) {
                $q->where('produce_code', $item->produce_code);
            })->first()->name;

            $size = Size::whereHas('products', function ($q) use ($item) {
                $q->where('produce_code', $item->produce_code);
            })->first()->name;

            return [
                'buy_order_id' => $id,
                'produce_code' => $item->produce_code,
                'product'      => $type,
                'size'         => $size,
                'qty'          => intval($item->company_qty)
            ];
        });

        return response()->json($order, 200);
    }

    public function validateProduct(Request $request)
    {
        $product = Product::where('prod_code', $request->prod_code)
            ->where('save_order_id', '!=', null)
            ->where('status', '!=', 'reserved')
            ->first();



        if ($product) {
            return response()->json($product, 200);
        }
        return response()->json('not found', 404);
    }

    public function saveOrder(Request $request)
    {
        $order = BuyOrder::where('id', $request->buy_order_id)->first();
        $order->preparation = 'prepared';
        $order->status = 1;
        $order->save();
        $buyOrderProduct = BuyOrderProduct::where('buy_order_id', $order->id)->first();

        foreach ($request->products_code as $ids) {
            $order->products()->attach($ids);
            Product::whereIn('id', $ids)->update(['status' => 'reserved']);
        }

        return response()->json('saved', 200);
    }

    public function readyOrderPage()
    {
        $orders = BuyOrder::where('status', 1)
            ->where('preparation', 'prepared')
            ->paginate();

        return view('dashboard.orders.buy_process.ready_orders', ['orders' => $orders]);
    }

    public function readySingleOrderPage($id)
    {
        return view('dashboard.orders.buy_process.ready_single_order', ['id' => $id]);
    }

    public function readyOrder($id)
    {
        $items = Product::whereHas('buyOrders', function ($q) use ($id) {
            $q->where('buy_orders.id', $id);
        })->with('productType:id,name', 'size:id,name', 'buyOrders')
            ->get()
            ->groupBy('produce_code');

        $items = $items->map(function ($item, $key) {
            return [
                'order_code' => $item->first()->buyOrders->first()->bar_code,
                'delivery_date' => $item->first()->buyOrders->first()->delivery_date,
                'produce_code' => $key,
                'qty' => $item->count(),
                'product' => $item->first()->productType->name,
                'size'    => $item->first()->size->name
            ];
        });

        return response()->json(array_values($items->toArray()), 200);
    }

    public function doneOrder()
    {
        $orders = BuyOrder::select('id', 'bar_code', 'delivery_date', 'confirmation')
            ->whereHas('buyOrderProducts', function ($q) {
                $q->where('factory_qty', 0);
            })
            ->where('preparation', 'shipped')
            ->where('status', 1)
            ->paginate();

        return view('dashboard.orders.buy_process.done_orders', ['orders' => $orders]);
    }

    public function doneOrderPage($id)
    {
        return view('dashboard.orders.buy_process.ready_single_order', ['id' => $id]);
    }
}
