<?php

namespace App\Http\Controllers\Dashboard\Orders;

use App\Http\Controllers\Controller;
use App\Models\Orders\BuyOrderProduct;
use App\Models\Orders\SaveOrder;
use App\Models\Orders\StoreProductOrder;
use Illuminate\Http\Request;
use App\Models\Products\Product;
use App\Models\Products\ProductType;
use Illuminate\Support\Facades\Session;


class StoreProductOrderController extends Controller
{
    public function getAllPaginate()
    {
        $orders = StoreProductOrder::paginate();
        return view('dashboard.orders.store_product_to_repository.list')->with('orders', $orders);
    }


    public function getOrder($order_code)
    {
    }


    public function getSavedProdacts($save_order)
    {
        $saved_prodact = Product::select('id', ',prodact_code', 'save_order_id')->whereHas('saveOrder', function ($q) use ($save_order) {
            $q->where('id', $save_order);
        });
        return view('dashboard.orders.store_product_to_repository.edit')->with('saved_prodact', $saved_prodact);
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
        })->with(array('products' => function ($query) use ($id) {
            $query->where('save_order_id', $id);
        }))->get();

        return response()->json($products, 200);
    }

    public function store(Request $request)
    {
        
        StoreProductOrder::create([
            'code' => $this->generateCode(),
            'save_order_id' => $request['save_order_id']
        ]);

        $order = SaveOrder::find($request['save_order_id'])->update([
            'stored' => 1

        ]);

        $this->addQtyToOrders($request['save_order_id']);
        Session::flash('success',  __('words.added_successfully') );
        return response()->json('success' , 200);
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

    public function delete($id)
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
}
