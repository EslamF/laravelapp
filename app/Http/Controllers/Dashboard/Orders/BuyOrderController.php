<?php

namespace App\Http\Controllers\Dashboard\Orders;

use App\Http\Controllers\Controller;
use App\Models\Materials\Material;
use App\Models\Orders\BuyOrder;
use App\Models\Orders\BuyOrderProduct;
use App\Models\Orders\CuttingOrderProduct;
use App\Models\Orders\OrderHistory;
use App\Models\Products\Product;
use App\Models\Users\Customer;
use Illuminate\Http\Request;

class BuyOrderController extends Controller
{
    public function createPage()
    {
        return view('dashboard.orders.buy_order.create');
    }

    public function getAllPaginate()
    {
        $data = BuyOrder::with('customer:id,name')->paginate();
        return view('dashboard.orders.buy_order.list', ['data' => $data]);
    }

    public function cuttingOrdersByMaterial($mq_r_code)
    {
        $companyProducts = Product::with('productType:id,name', 'size:id,name')
            ->whereHas('material', function ($q) use ($mq_r_code) {
                $q->where('mq_r_code', $mq_r_code);
            })
            ->where('received', 1)
            ->get()->groupBy('produce_code');

        $data = $this->customizeProducts($companyProducts);
        return response()->json(array_values($data), 200);
    }

    public function customizeProducts($products)
    {
        $data = [];
        foreach ($products as $key => $product) {
            $old_factory_qty = 0;
            $old_company_qty = 0;
            $oldOrders = BuyOrderProduct::where('produce_code', $key)->get();

            if ($oldOrders && $oldOrders->count() > 0) {
                foreach ($oldOrders as $order) {
                    $old_factory_qty += empty($order->factory_qty) ? 0 : $order->factory_qty;
                    $old_company_qty += empty($order->company_qty) ? 0 : $order->company_qty;
                }
            }

            $data[$key]['produce_code'] = $key;
            $data[$key]['factory_count'] = intval($product->where('status', 'available')->where('save_order_id', null)->count() / 100 * 90 - $old_factory_qty);
            $data[$key]['company_count'] = ($product->where('status', 'available')->where('save_order_id', '!=', null)->count() + $product->where('status', 'reserved')->where('save_order_id', '!=', null)->count()) - $old_company_qty;
            $data[$key]['size'] = $product->first()->size->name;
            $data[$key]['product_type'] = $product->first()->productType->name;
        }
        return $data;
    }

    public function receiveOrder(Request $request)
    {
        $customer = Customer::updateOrCreate(['phone' => $request->customer['phone']], $request->customer);

        $order = BuyOrder::create([
            'customer_id' => $customer->id,
            'description' => $request->description,
            'bar_code' => $this->generateCode(),
            'delivery_date' => $request->delivery_date,
            'source'        => $customer->source
        ]);
        foreach ($request->products as $product) {
            if (!isset($product['qty'])) {
                continue;
            }

            if ($product['company_count'] != 0) {
                if ($product['company_count'] >= $product['qty']) {
                    $product['company_qty'] = $product['qty'];
                } else {
                    $product['company_qty'] = $product['company_count'];
                    $product['factory_qty'] = $product['qty'] - $product['company_count'];
                }
            } else {
                $product['factory_qty'] = $product['qty'];
            }

            BuyOrderProduct::create([
                'buy_order_id'             => $order->id,
                'produce_code'             => $product['produce_code'],
                'factory_qty'              => $product['factory_qty'] ?? 0,
                'company_qty'              => $product['company_qty'] ?? 0,
                'price'                    => $product['price']
            ]);
        }
    }

    public function generateCode()
    {
        $code = rand(0, 6000000000000);
        $check = BuyOrder::where('bar_code', $code)->exists();
        if ($check) {
            $this->generateCode();
        } else {
            return $code;
        }
    }

    public function deleteOrder(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:buy_orders,id'
        ]);

        $products = Product::whereHas('buyOrders', function ($q) use ($request) {
            $q->where('buy_orders.id', $request->id);
        })->get()->pluck('id');

        Product::whereIn('id', $products)->update([
            'status' => 'available'
        ]);

        BuyOrder::find($request->id)->delete();
        return redirect()->back();
    }

    public function showOrderPage($id)
    {

        return view('dashboard.orders.buy_order.show', ['id' => $id]);
    }

    public function showOrder($id)
    {
        $data = [];
        $data['order'] = BuyOrder::where('id', $id)->with('buyOrderProducts')->first();
        $data['products'] = $data['order']->buyOrderProducts->map(function ($item) {
            $product = Product::where('produce_code', $item->produce_code)->first();
            return [
                'id'           => $item->id,
                'product_type' => $product->productType->name,
                'product_size' => $product->size->name,
                'factory_qty'  => intval($item->factory_qty),
                'company_qty'  => intval($item->company_qty),
                'price'        => intval($item->price)
            ];
        });

        return response()->json($data, 200);
    }

    public function updateOrder(Request $request)
    {
        BuyOrder::find($request->data['order']['id'])->update([
            'confirmation' => $request->data['order']['confirmation'],
            'pending_date' => $request->data['order']['pending_date'] ?? null
        ]);

        OrderHistory::create([
            'buy_order_id' => $request->data['order']['id'],
            'status'       => $request->data['order']['confirmation'],
            'pending_date' => $request->data['order']['pending_date'] ?? null
        ]);

        foreach ($request->data['products'] as $product) {
            Product::find($product['id'])->update($product);
        }

        return response()->json('success', 200);
    }

    public function removeItem(Request $request)
    {
        BuyOrderProduct::find($request->id)->delete();
        return response()->json('deleted', 200);
    }

    public function buyOrdersWithShippingId($id)
    {
        $orders = BuyOrder::select('id', 'bar_code')->whereHas('shippingOrders', function ($q) use ($id) {
            $q->where('shipping_orders.id', $id);
        })->get();
        return response()->json($orders->pluck('bar_code'), 200);
    }
}
