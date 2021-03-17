<?php

namespace App\Http\Controllers\Dashboard\Orders;

use App\Models\Options\Size;
use Illuminate\Http\Request;
use App\Models\Orders\ProduceOrder;
use App\Models\Products\ProductType;
use App\Http\Controllers\Controller;
use App\Models\Orders\CuttingOrder;
use App\Models\Orders\CuttingOrderProduct;
use App\Models\Orders\ReceivingOrder;
use App\Models\Products\Product;
use Illuminate\Support\Facades\Session;


class ReceivingProductController extends Controller
{
    public function getAllPaginate()
    {
        $data = ReceivingOrder::with(
            'productType:id,name',
            'size:id,name'
        )->paginate();

        //Session::forget('success');
        return view('dashboard.orders.receiving_products.list')->with('data', $data);
    }

    public function createPage()
    {
        $data = [];
        $data['product_types'] = ProductType::select('id', 'name')->get();
        $data['sizes'] = Size::select('id', 'name')->get();
        $data['produce_orders'] = ProduceOrder::select('id')->get();

        return view('dashboard.orders.receiving_products.create')->with('data', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'produce_order_id' => 'required|exists:produce_orders,id',
            'status'           => 'required|in:0,1',
        ]);

        ReceivingOrder::create($request->all());
        return redirect()->route('receiving.product.list');
        
    }

    public function editPage($receiving_id)
    {
        $data = [];
        $data['product_types'] = ProductType::select('id', 'name')->get();
        $data['sizes'] = Size::select('id', 'name')->get();
        $data['produce_orders'] = ProduceOrder::select('id')->get();
        $data['records'] = ReceivingOrder::where('id', $receiving_id)->first();
        return view('dashboard.orders.receiving_products.edit')->with('data', $data);
    }

    public function update(Request $request)
    {
        $request->validate([
            'receiving_id'     => 'required|exists:receiving_orders,id',
            'product_type_id'  => 'exists:product_types,id',
            'size_id'          => 'exists:sizes,id',
            'produce_order_id' => 'exists:produce_orders,id',
            'status'           => 'in:0,1',
            'receiving_date'   => 'date',
        ]);

        ReceivingOrder::find($request->receiving_id)->update($request->all());
        return redirect()->route('receiving.product.list');
    }


    public function delete(Request $request)
    {
        $request->validate([
            'receiving_id' => 'required|exists:receiving_orders,id',
        ]);

        Product::where('receiving_order_id' , $request->receiving_id)->update(['received' => 0 , 'receiving_order_id' => null]);
        
        $receiving_order = ReceivingOrder::find($request->receiving_id);
        if($receiving_order->produceOrder->status == 1)
        {
            $receiving_order->produceOrder->update(['status' => 0]);
        }
        $receiving_order->delete();
        Session::flash('success',  __('words.deleted_successfully') );
        return redirect()->route('receiving.product.list');
    }

    public function orderProduct($id)
    {
        $order = CuttingOrderProduct::where('cutting_order_id', $id)->with('productType', 'size')->get();
        return response()->json($order, 200);
    }

    public function productsToReceive($id)
    {
        return response()->json($this->products($id, 0), 200);
    }

    public function productsReceived($id)
    {
        return response()->json($this->products($id, 1), 200);
    }

    public function allProducts($id)
    {
        $produce = ProduceOrder::where('id', $id)->first();
        $products = Product::select('id', 'prod_code', 'produce_code', 'product_type_id', 'size_id')
            ->with('productType:id,name', 'size:id,name')
            //->where('cutting_order_id', $produce->cutting_order_id)
            ->where('produce_order_id' , $id )
            //->where('received', $received)
            ->get()->groupBy('produce_code');

        $data = [];

        foreach ($products as $key => $product) {
            //Product::where('')
            $data[$key]['produce_code'] = $key;
            $data[$key]['count'] = $product->count();
            $data[$key]['required'] = Product::where('produce_code' , $key)->where('produce_order_id' , $id )->where('received' , 0)->count();
            $data[$key]['size'] = $product->first()->size->name;
            $data[$key]['product_type'] = $product->first()->productType->name;
            $data[$key]['number_of_received']      = Product::where('produce_code' , $key)->where('produce_order_id' , $id )->where('received' , 1)->count();
            $data[$key]['number_of_not_received'] = Product::where('produce_code' , $key)->where('produce_order_id' , $id )->where('received' , 0)->count();

        }
        return array_values($data);
    }

    public function products($id, $received) 
    {
        $produce = ProduceOrder::where('id', $id)->first();
        $products = Product::select('id', 'prod_code', 'produce_code', 'product_type_id', 'size_id')
            ->with('productType:id,name', 'size:id,name')
            //->where('cutting_order_id', $produce->cutting_order_id)
            ->where('produce_order_id' , $id )
            ->where('received', $received)
            ->get()->groupBy('produce_code');

        $data = [];

        foreach ($products as $key => $product) {
            //Product::where('')
            $data[$key]['produce_code'] = $key;
            $data[$key]['count'] = $product->count();
            $data[$key]['required'] = $product->count();
            $data[$key]['size'] = $product->first()->size->name;
            $data[$key]['product_type'] = $product->first()->productType->name;
        }

        return array_values($data);
    }

    public function approveOrUnapprove(Request $request)
    {
        Product::where('produce_code', $request->produce_code)->update(['received' => $request->received]);
        return response()->json('updated', 200);
    }

    public function changeStatus(Request $request)
    {
        $receiveOrder = ReceivingOrder::updateOrCreate(['produce_order_id' => $request->produce_order_id], $request->all());
        if ($request->products) 
        {
            foreach ($request->products as $product) {

                $required_quantity = (int)$product['required'];
                //delete the previous data
                $data = Product::where( 'produce_code' , $product['produce_code'] )
                                ->where( 'produce_order_id' , $request->produce_order_id ) 
                                //->where('receiving_order_id' , $receiveOrder->id )
                                //->where('received' , 0)
                                ->get();
                                //->take( $product['required'] )  
                foreach($data as $product)
                {
                    $product->receiving_order_id = null ;
                    $product->received = 0 ;
                    $product->save();
                }
                // put the new data
                $given_products = Product::where( 'produce_code' , $product['produce_code'] )
                       ->where( 'produce_order_id' , $request->produce_order_id ) 
                       //->whereNull('receiving_order_id' )
                        ->take($required_quantity)
                        ->get();
                foreach($given_products as $given_product)
                {
                    $given_product->receiving_order_id = $receiveOrder->id ;
                    $given_product->received = 1 ;
                    $given_product->save();
                }
            }
        }

        
        $check = Product::where('produce_order_id' , $request->produce_order_id )->where('received' , 0)->exists();
       
        if ($check) 
        {

            $receiveOrder->update([
                'status' => '0'
            ]);
        } 
        else 
        {
            $receiveOrder->update([
                'status' => '1'
            ]);
        }

        Session::flash('success',  __('words.added_successfully') );
        return response()->json('success', 200);
    }

    public function print_products(Request $request)
    {
        //$receiveOrder = ReceivingOrder::updateOrCreate(['produce_order_id' => $request->produce_order_id], $request->all());
        $receiveOrder = ReceivingOrder::create(['produce_order_id' => $request->produce_order_id , 'status' => 0], $request->all());
        $arr = [];
        if ($request->products) 
        {
            foreach ($request->products as $product) 
            {
                $required_quantity = (int)$product['required'];
                $ids = Product::where( 'produce_code' , $product['produce_code'] )
                                ->where( 'produce_order_id' , $request->produce_order_id )
                                ->where('received' , 0)
                                ->take($required_quantity)
                                ->pluck('id')
                                ->toArray();
                foreach($ids as $id)
                {
                    array_push($arr , $id);
                }
                
            }

            $products = Product::whereIn('id' , $arr)->get();
            foreach($products as $product)
            {
                $product->update(['receiving_order_id' => $receiveOrder->id]);
            }

            if(empty($arr))
            {
                $receiveOrder->delete();
            }
           return $arr;
        }
    }

    public function receive_products_after_printing_view($id)
    {
        $receiveOrder = ReceivingOrder::findOrFail($id);
        $receiving_order_id = $receiveOrder->id;
        $number_of_products = Product::where('receiving_order_id' , $receiving_order_id)
                                        ->where('received' , 0)
                                        ->count();
        return view('dashboard.orders.receiving_products.after-printing' , compact('receiving_order_id' , 'number_of_products') );
    }

    public function receive_products_after_printing(Request $request) 
    {
        //request data : receving_order_id , ids
        $receiveOrder = ReceivingOrder::find($request->receiving_order_id);
        $produce_order = ProduceOrder::where('id' , $receiveOrder->produce_order_id)->first();
        $products = Product::whereIn('id' , $request->ids)
                            ->where('receiving_order_id' , $receiveOrder->id)
                            ->where('received' , 0)
                            ->get();
        //return $products;
        //update the products to be received
        foreach($products as $product)
        {
            $product->update(['received' => 1]);
        }
        //update the recevied order to be done(status: 1)
        $receiveOrder->update(['status' => 1]);
        //update the status of produce order if all products received
        $check = Product::where('produce_order_id' , $receiveOrder->produce_order_id )->where('received' , 0)->exists();
        if ($check) 
        {
            $produce_order->update(['status' => 0]);
        } 
        else 
        {
            $produce_order->update(['status' => 1]);
        }

        Session::flash('success',  __('words.added_successfully') );
        return response()->json('success', 200);
    }

    public function check_product_before_received(Request $request)
    {
        // request has prod_code , receiving_order_id
        $product = Product::with('productType:id,name', 'size:id,name' , 'material')
                        ->where('prod_code' , $request->prod_code)
                        ->where('receiving_order_id' , $request->receiving_order_id)
                        ->where('received' , 0)
                        ->first();
        if($product)
        {
            return response()->json($product , 200);
        }
        else 
        {
            return response()->json('error' , 200); 
        }
    }

    public function getAll()
    {
        return response()->json(ReceivingOrder::selcet('id')->get(), 200);
    }
}
