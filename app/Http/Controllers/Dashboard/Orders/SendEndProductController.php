<?php

namespace App\Http\Controllers\Dashboard\Orders;

use App\User;
use Illuminate\Http\Request;
use App\Models\Orders\SaveOrder;
use App\Models\Products\Product;
use App\Models\Options\Repository;
use App\Http\Controllers\Controller;


class SendEndProductController extends Controller
{
    public function getAllPaginate()
    {
        $orders = SaveOrder::whereHas('products', function ($q) {
            $q->where('save_order_id', '!=', null);
        })->paginate();

        return view('dashboard.orders.send_end_product.list')->with('orders', $orders);
    }


    public function getOrder($order_code)
    {
        $data = Product::where('save_order_id', $order_code)
            ->select('id', 'save_order_id', 'user_id', 'prod_code')
            ->with('user:id,name')
            ->paginate();
        return view('dashboard.orders.send_end_product.product_order.list')->with('data', $data);
    }
    public function create()
    {
        $employees = User::select('id', 'name')->get();
        return view('dashboard.orders.send_end_product.create')->with('employees', $employees);
    }

    public function store(Request $request)
    {
        $request->validate([
            'products' => 'required',
            'user_id' => 'required|exists:users,id'
        ]);

        $order = SaveOrder::create([
            'code' => $this->generateCode()
        ]);

        foreach ($request->products as $value) {
            $product = Product::where('prod_code', $value)->first();
            if ($product) {
                $product->update([
                    'save_order_id' => $order->id,
                    'user_id'       => $request->user_id,
                ]);
            } else {
                continue;
            }
        }
        return redirect()->route('send.end_product.list');
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

    public function delete(Request $request)
    {
        $request->validate([
            'save_order_id' => 'required|exists:save_orders,id'
        ]);
        $product = Product::where('save_order_id', $request->save_order_id)->first();
        $product->update([
            'save_order_id' => null,
            'user_id' => null
        ]);

        SaveOrder::find($request->save_order_id)->delete();
        return redirect()->route('send.end_product.list');
    }

    public function checkIfSorted(Request $request)
    {

        return response()->json(Product::where('prod_code', $request->product_code)
            ->where('sorted', 1)
            ->where('save_order_id', null)
            ->where('damage_type', '!=', 'ironing')
            ->where('damage_type', '!=', 'dyeing')
            ->where('damage_type', '!=', 'tailoring')
            ->exists(), 200);
    }
}
