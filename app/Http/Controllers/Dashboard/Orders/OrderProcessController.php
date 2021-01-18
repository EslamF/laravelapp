<?php

namespace App\Http\Controllers\Dashboard\Orders;

use App\Http\Controllers\Controller;
use App\Models\Options\Size;
use App\Models\Orders\BuyOrder;
use App\Models\Orders\BuyOrderProduct;
use App\Models\Orders\ShippingOrder;
use App\Models\Products\Product;
use App\Models\Products\ProductType;
use App\Models\Materials\Material;
use App\Models\Users\Customer;
use Illuminate\Http\Request;

class OrderProcessController extends Controller
{
    public function getAllPaginate()
    {
        //return Product::where('material_id' , 10)->where('size_id' , 3)->first();
        /*$value[8] = "Code 934";
        $products_array = str_replace("Code","/", $value[8]); 
        
        $products_array = str_replace("code","/", $products_array); 

        $products_array = str_replace(" ","", $products_array); 
        
        $products_array = explode("/" , $products_array);
        
        $products_array = array_filter($products_array);
        
        $products_array = array_values($products_array);
        return $products_array;*/

        $new = BuyOrder::select('id', 'bar_code', 'delivery_date', 'confirmation')
            ->whereHas('buyOrderProducts', function ($q) {
                $q->where('factory_qty', 0);
            })
            ->where('confirmation', '!=', 'canceled')
            ->where('preparation', 'need_prepare')
            //->where('status', 0)
            ->count();

        $prepared = BuyOrder::where('status', 1)
            ->where('preparation', 'prepared')
            ->count();

        $done = BuyOrder::select('id', 'bar_code', 'delivery_date', 'confirmation')
            ->whereHas('buyOrderProducts', function ($q) {
                $q->where('factory_qty', 0);
            })
            ->where('preparation', 'shipped')
            //->where('status', 1)
            ->count();

        $readyToShip = ShippingOrder::where('status', 0)->count();

        $rejected = BuyOrder::where('status' , 'rejected')->count();

        return view('dashboard.orders.buy_process.list', ['new' => $new, 'prepared' => $prepared, 'done' => $done, 'ready' => $readyToShip , 'rejected' => $rejected]);
    }

    public function getNewOrders()
    {
        //return BuyOrder::with('buyOrderProducts')->where('bar_code' , "X624")->first();
        //$orders =  BuyOrder::doesntHave('buyOrderProducts')->paginate();
        //return view('dashboard.orders.buy_process.new_orders', ['orders' => $orders]);
        $orders = BuyOrder::select('id', 'bar_code', 'delivery_date', 'confirmation' , 'shipping_company_id' , 'customer_id')
            ->whereHas('buyOrderProducts', function ($q) {
                $q->where('factory_qty', 0);
            })
            ->where(function($query){
                if(request()->filled('search'))
                {
                    $customers = Customer::where('name' , 'like' , '%' . request()->search . '%')
                                            ->orWhere('phone' , 'like' , '%' . request()->search . '%')
                                            ->get()
                                            ->pluck('id')
                                            ->toArray();

                    $query->whereIn('customer_id' , $customers)
                           ->orWhere('bar_code' , request()->search );
                }
            })
            ->where('confirmation', '!=', 'canceled')
            ->where('preparation', 'need_prepare')
            //->where('status', 0)
            ->with(['shippingCompany' , 'customer'])
            ->paginate();

            //return $orders()->where('bar_code' , )

            //return $orders;
        return view('dashboard.orders.buy_process.new_orders', ['orders' => $orders]);
    }

    public function getRejectedOrders()
    {
        $orders = BuyOrder::with('shippingOrders' , 'shippingOrders.shippingCompany')
                            ->select('id', 'bar_code', 'delivery_date', 'confirmation')
                            ->where('status', 'rejected')
                            ->paginate();

        //return $orders;
        return view('dashboard.orders.buy_process.rejected_orders', ['orders' => $orders]);
    }

    public function receive_rejected_orders_page($id)
    {
        $order = BuyOrder::with('buyOrderProducts')->findOrFail($id);
        $order->buyOrderProducts->map(function($item , $key) use($order){

            $product = Product::with('productType' , 'size' , 'material' , 'material.materialType')->where('produce_code' , $item->produce_code)->first();
            //$order->buyOrderProducts[$key]->put('type' , $product->productType->name);
            //$order->buyOrderProducts['type'] = $product->productType->name ;
            $item->type      = $product->productType->name ;
            $item->size      = $product->size->name ;
            $item->mq_r_code = $product->material->mq_r_code ;
            $item->material  = $product->material->materialType->name ;
            return $item;

        });
        //return $order;
        return view('dashboard.orders.buy_process.receive_rejected_orders_page' , compact('order'));
    }

    public function receive_rejected_orders_submit(Request $request)
    {
        $order = BuyOrder::with('buyOrderProducts')->findOrFail($request->id);
        if($order)
        {
            $products = Product::whereHas('buyOrders', function ($q) use ($request) {
                $q->where('buy_orders.id', $request->id);
            })->get()->pluck('id');
    
            Product::whereIn('id', $products)->update([
                'status' => 'available'
            ]);

            $order->products()->detach();

            $order->update(['status' => 'returned']);

            return response()->json('success' , 200);
        }

        return response()->json('error' , 200);
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

            $material_id = Product::where('produce_code' , $item->produce_code)->first()->material_id;
            $material = Material::where('id' , $material_id)->first();

            return [
                'buy_order_id'  => $id,
                'produce_code'  => $item->produce_code,
                'product'       => $type,
                'size'          => $size,
                'qty'           => intval($item->company_qty),
                'material_code' => $material->mq_r_code
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
        //$order->status = 1;
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
        $orders = BuyOrder::where('preparation', 'prepared')
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
        $orders = BuyOrder::with('shippingOrders' , 'shippingOrders.shippingCompany')
                            ->whereHas('buyOrderProducts', function ($q) {
                                $q->where('factory_qty', 0);
                            })
                            ->where('preparation', 'shipped')
                            //->where('status', 1)
                            ->paginate();

        return view('dashboard.orders.buy_process.done_orders', ['orders' => $orders]);
    }

    public function doneOrderPage($id)
    {
        return view('dashboard.orders.buy_process.done_single_order', ['id' => $id]);
    }

    public function update_the_status_of_done_order(Request $request)
    {
        $validator = validator()->make($request->all() , [
            'order_id'     => 'required|exists:buy_orders,id' ,
            'order_status' => 'required|in:pending,rejected,done'
        ]);

        if($validator->fails())
        {
            return response()->json('error' , 200);
        }

        $order = BuyOrder::find($request->order_id);
        if($order->status != 'returned')
        {
            $order->status = $request->order_status;
            $order->save();
            return response()->json('success' , 200);
        }

        else 
        {
            return response()->json('error' , 200);
        }
    }
}
