<?php

namespace App\Http\Controllers\Dashboard\Orders;

use App\Http\Controllers\Controller;
use App\Models\Orders\SaveOrder;
use App\Models\Orders\StoreProductOrder;
use Illuminate\Http\Request;
use App\Models\Products\Product;
use App\Models\Products\ProductType;

class StoreProductOrderController extends Controller
{
    public function getAllPaginate()
    {
        $orders = StoreProductOrder::select('id', 'code')->paginate();
        return view('dashboard.orders.store_product_to_repository.list')->with('orders', $orders);
    }


    public function getOrder($order_code)
    {
    }

    public function create()
    {
        $orders = SaveOrder::select('id', 'code')->where('stored', 0)->get();
        return view('dashboard.orders.store_product_to_repository.create')->with('orders', $orders);
    }

    public function getShippingOrder($id)
    {

        $products = ProductType::whereHas('products', function ($q) use ($id) {
            $q->where('save_order_id', $id);
        })->get();

        return response()->json($products, 200);
    }

    public function store(Request $request)
    {
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

    public function delete(Request $request)
    {
    }
}