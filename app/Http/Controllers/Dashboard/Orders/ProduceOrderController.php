<?php

namespace App\Http\Controllers\Dashboard\Orders;

use Illuminate\Http\Request;
use App\Models\Materials\Material;
use App\Models\Orders\CuttingOrder;
use App\Models\Orders\ProduceOrder;
use App\Http\Controllers\Controller;
use App\Models\Organization\Factory;
use App\Models\Products\Product;
use Illuminate\Support\Facades\Session;
use App\Models\Orders\ReceivingOrder;


class ProduceOrderController extends Controller
{
    public function getAllPaginate()
    {
        $data = ProduceOrder::with(
            'cuttingOrder:id',
            'factory:id,name',
        )->paginate();
        return view('dashboard.orders.produce_order.list')->with('data', $data);
    }

    public function getAll()
    {
        //$done_receiving_orders = ReceivingOrder::where('status' , 1)->pluck('produce_order_id');
        //$orders = ProduceOrder::with('factory' , 'user')->whereNotIn('id' , $done_receiving_orders)->get();
        $orders = ProduceOrder::with('factory' , 'user')->where('status' , 0)->get();
        return response()->json($orders, 200);
    }

    public function createPage()
    {
        $data = [];
        $data['materials'] = Material::select('id', 'mq_r_code')->get();
        $data['cutting_orders'] = CuttingOrder::select('id')->doesntHave('produceOrders')->get();

        return view('dashboard.orders.produce_order.create')->with('data', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'cutting_order_id' => 'required|exists:cutting_orders,id',
            'factory_id' => 'required|exists:factories,id',
            'receiving_date'   => 'required|date',
            'out_date'   => 'required|date',
            'products'      => 'required'
        ]);

        $produce_order = ProduceOrder::create($request->all());
        foreach($request->products as $product)
        {
            if($product['required_quantity'] > 0 && $product['required_quantity'] <= $product['quantity'])
            {
                $updated_products = Product::where([ [ 'produce_code' , $product['produce_code'] ], [ 'cutting_order_id' , $request->cutting_order_id  ] ])->whereNull('produce_order_id')->take($product['required_quantity'])->get() ;
                foreach($updated_products as $updated_product)
                {
                    $updated_product->produce_order_id = $produce_order->id ;
                    $updated_product->save();
                    //$updated_product->update(['produce_order_id' , $produce_order->id]); 
                }

                //return $updated_products;
                        
            }
        }

        Session::put('success',  __('words.added_successfully') );
        return response()->json('success', 200);
    }

    public function editPage($produce_id)
    {
        $data = [];
        $data['factories'] = Factory::select('id', 'name')->get();
        $data['materials'] = Material::select('id', 'mq_r_code')->get();
        $data['cutting_orders'] = CuttingOrder::select('id')->get();
        $data['records'] = ProduceOrder::with('factory' , 'factory.factoryType')->where('id', $produce_id)->first();

        if(!$data['records']->can_edit)
        {
            abort(404);
        }
        //return $data;
        return view('dashboard.orders.produce_order.edit')->with('data', $data);
    }

    public function update(Request $request)
    {

        $validator = validator()->make($request->all() , [

            'produce_order_id' => 'required|exists:produce_orders,id',
            'factory_id'       => 'required|exists:factories,id',
            'receiving_date'   => 'required|date',
            'products'         => 'required',
            'out_date'         => 'required|date',

        ]);

        if($validator->fails())
        {
            return response()->json('error' , 200);
        }
            
        $produce_order = ProduceOrder::find($request->produce_order_id);

        if(!$produce_order->can_edit)
        {
            return response()->json('error' , 200);
        }
        //remove the previous data
        Product::where('produce_order_id' ,  $produce_order->id )->update(['produce_order_id' => null]);


        $produce_order->update($request->all());
        foreach($request->products as $product)
        {
            if($product['required_quantity'] > 0 && $product['required_quantity'] <= $product['quantity'])
            {
                $updated_products = Product::where([ [ 'produce_code' , $product['produce_code'] ], [ 'cutting_order_id' , $produce_order->cutting_order_id  ] ])->whereNull('produce_order_id')->take($product['required_quantity'])->get() ;
                foreach($updated_products as $updated_product)
                {
                    $updated_product->produce_order_id = $produce_order->id ;
                    $updated_product->save();
                    //$updated_product->update(['produce_order_id' , $produce_order->id]); 
                }

                //return $updated_products;
                        
            }
        }

        return redirect()->route('produce.order.list');
    }

    public function show($id)
    {
        $order = ProduceOrder::with('cuttingOrder' , 'cuttingOrder.factory' , 'cuttingOrder.user' , 'cuttingOrder.spreadingOutMaterialOrder' , 'cuttingOrder.spreadingOutMaterialOrder.user' , 'cuttingOrder.spreadingOutMaterialOrder.material' )->findOrFail($id);
        $products = $order->products()->with('productType:id,name', 'size:id,name')->get()->groupBy('produce_code');
        
        return view('dashboard.orders.produce_order.show' , compact('order' , 'products'));
    }


    public function delete(Request $request)
    {
        $request->validate([
            'produce_id' => 'required|exists:produce_orders,id',
        ]);

        Product::where('produce_order_id' , $request->produce_id)->update(['produce_order_id' => null]);
        ProduceOrder::find($request->produce_id)->delete();
        return redirect()->route('produce.order.list');
    }

    public function getAvailableProducts(Request $request)
    {
        //return $request->produce_order_id;
        if($request->filled('cutting_order_id'))
        {
            $products = Product::with('productType:id,name', 'size:id,name')
                                ->where('cutting_order_id' , $request->cutting_order_id)
                                ->where('produce_order_id' , null)
                                ->get()
                                ->groupBy('produce_code');

            return response()->json($products , 200);
        }

        //use when we edit on the produce order
        else if($request->has('produce_order_id'))
        {
            $order = ProduceOrder::find($request->produce_order_id);
            //return responseJson('hello' , 200);
            if($order)
            {
                $products = Product::with('productType:id,name', 'size:id,name')
                //->where('cutting_order_id' , $request->cutting_order_id)
                //->where('produce_order_id' , null)
                ->where('produce_order_id' , $request->produce_order_id)
                ->orWhere(function($query) use($order) {
                    $query->where('produce_order_id' , null)
                            ->where('cutting_order_id' , $order->cutting_order_id );
                })
                ->get()
                ->groupBy('produce_code');

                return response()->json($products , 200);
            }

            else 
            {
                return response()->json('error' , 200);
            } 
        }

        else 
        {
            return response()->json('error' , 200);
        }
        
    }
}
