<?php

namespace App\Http\Controllers\Dashboard\Orders;

use App\User;
use Illuminate\Http\Request;
use App\Models\Orders\SaveOrder;
use App\Models\Products\Product;
use App\Models\Options\Repository;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;


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
        
        $order = SaveOrder::findOrFail($order_code);

        $products = Product::where('save_order_id', $order_code)
            ->select('id', 'save_order_id', 'prod_code')
            ->with('user:id,name')
            ->paginate();
        return view('dashboard.orders.send_end_product.product_order.list')->with([  'products' => $products  , 'order' => $order ]);
    }
    public function create()
    {
        $employees = User::select('id', 'name')->get();
        return view('dashboard.orders.send_end_product.create')->with('employees', $employees);
    }

    public function store(Request $request)
    {
        //return $request;
        $request->validate([
            'products' => 'required',
            'user_id' => 'required|exists:users,id'
        ]);

        $order = SaveOrder::create([
            'code' => $this->generateCode() , 
            'user_id' => $request->user_id  
        ]);

        foreach ($request->products as $value) {
            $product = Product::where('prod_code', $value)->first();
            if ($product) {
                $product->update([
                    'save_order_id' => $order->id,
                    //'user_id'       => $request->user_id,
                ]);
            } else {
                continue;
            }
        }
        //return redirect()->route('send.end_product.list');
        Session::flash('success',  __('words.added_successfully') );
        return response()->json('success' , 200);
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

        if($request->filled('save_order_id')) // in edit page
        {
            return response()->json(Product::where('prod_code', $request->product_code)
                            ->where('sorted', 1)
                            //->where('save_order_id', null)
                            ->where('status' , 'available')
                            //->orWhere('save_order_id' , $request->save_order_id)
                            //->whereIn('save_order_id' , [$request->save_order_id , null])
                            ->where(function($query) use($request){
                                $query->where('save_order_id'   , null)
                                      ->orWhere('save_order_id' , $request->save_order_id );
                            })
                            ->exists(), 200);
        }

        else 
        {
            return response()->json(Product::where('prod_code', $request->product_code)
                            ->where('sorted', 1)
                            ->where('save_order_id', null)
                            ->where('status' , 'available')
                            ->exists(), 200);
        }
        
    }


    public function edit($id)
    {
        $order = SaveOrder::where('id' , $id)->where('stored' , 0)->firstOrFail();
        $codes = Product::where('save_order_id' , $id)->pluck('prod_code')->toArray();
    
        return view('dashboard.orders.send_end_product.edit' , compact('order' , 'codes'));
    }

    public function getProducts(Request $request)
    {
        if($request->filled('save_order_id'))
        {
            $codes = Product::where('save_order_id' , $request->save_order_id)->pluck('prod_code')->toArray();
            return response()->json($codes , 200);
        }
    }

    public function update(Request $request)
    {
        //return $request;
        $validator = validator()->make($request->all() , [

            'save_order_id' => 'required|exists:save_orders,id' ,
            'products' => 'required',
            'code'     => 'required|unique:save_orders,code,' . $request->save_order_id ,
            'user_id' => 'required|exists:users,id' , 

        ]);

        if($validator->fails())
        {
            return response()->json([
                'error' => $validator->errors()->first()
            ] , 200 );
        }
     

        // id => save_order_id
        $order = SaveOrder::findOrFail($request->save_order_id);

        //if the order not stored in the company  .. the stored value is 0 
        if($order->stored == 0)
        {
            $order->update(['code' => $request->code , 'user_id' => $request->user_id]);
            // get the products with the save_order_id = $id and change the save_order_id to null
            $old_products = Product::where('save_order_id' , $order->id)->get();
            foreach($old_products as $old_product)
            {
                $old_product->update([
                    'save_order_id' => null,
                ]);
            }
            // get the products attached with the request and adjust the save_order_id to the given id 
            foreach ($request->products as $code) 
            {
                $product = Product::where('prod_code', $code)->first();
                if ($product) {
                    $product->update([
                        'save_order_id' => $order->id,
                    ]);
                }
            }
            Session::flash('success',  __('words.updated_successfully') );
            return response()->json('success' , 200);
            //return redirect()->route('send.end_product.list');
        }

        else 
        {
            return response()->json([
                'error' => 'لا يمكن التعديل على الطلب'
            ] , 200 );
        }
    
    }
}
