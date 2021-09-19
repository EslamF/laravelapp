<?php

namespace App\Http\Controllers\Dashboard\Orders;

use App\Http\Controllers\Controller;
use App\Models\Materials\Material;
use App\Models\Orders\BuyOrder;
use App\Models\Orders\BuyOrderProduct;
use App\Models\Orders\CuttingOrderProduct;
use App\Models\Orders\OrderHistory;
use App\Models\Orders\OrderStatus;
use App\Models\Products\Product;
use App\Models\Users\Customer;
use Illuminate\Http\Request;
use App\Exports\BuyOrdersExport;
use Maatwebsite\Excel\Facades\Excel;
use App\User;
use App\Models\Organization\ShippingCompany;
use App\Models\Organization\Factory;

class BuyOrderController extends Controller
{
    public function createPage()
    {
        return view('dashboard.orders.buy_order.create');
    }

    public function getAllPaginate()
    {
        $orders = BuyOrder::where(function($query){

            if(request()->filled('employee_id'))
            {
                $query->where('created_by' , request()->employee_id);
            }

            if(request()->filled('shipping_company_id'))
            {
                $query->where('shipping_company_id' , request()->shipping_company_id);
            }

            if(request()->filled('confirmation'))
            {
                $query->where('confirmation' , request()->confirmation);
            }

            if(request()->filled('status'))
            {
                $query->where('status' , request()->status);
            }

            if(request()->filled('preparation'))
            {
                $query->where('preparation' , request()->preparation);
            }

            if(request()->filled('from'))
            {
                $query->whereDate('created_at' , '>=' , request()->from); 
            }

            if(request()->filled('to'))
            {
                $query->whereDate('created_at' , '<=' , request()->to);  
            }

            if(request()->filled('mq_r_code'))
            {
                $query->whereHas('buyOrderProducts' , function($query2){
                    $searching_value = 'no_there';

                    $material = Material::where('mq_r_code' , request()->mq_r_code)->first();
                    if($material)
                    {
                        $product = Product::where('material_id' , $material->id )->first();

                        if($product)
                        {
                            $searching_value = $product->product_material_code;
                        }

                    }

                        $query2->where('product_material_code' , $searching_value);
                    
                });
            }
        

        })->with('customer:id,name,phone');

        $data = $orders->paginate();

        //return $orders->pluck('id')->toArray();
        
        $employees = User::get();
        $shipping_companies = ShippingCompany::get();

        //$number_of_total_products = Product
        //$number_of_total_products = Product::with('buyOrders')->whereHas('buyOrders')->count();

        $number_of_total_products = BuyOrderProduct::whereIn('buy_order_id' , $orders->pluck('id')->toArray())->sum('factory_qty') + BuyOrderProduct::whereIn('buy_order_id' , $orders->pluck('id')->toArray())->sum('company_qty') ;
        $number_of_total_orders   = $data->total();
        $total_price              = $orders->sum('price');

        return view('dashboard.orders.buy_order.list', ['data' => $data , 'employees' => $employees , 'shipping_companies' => $shipping_companies , 'number_of_total_products' => $number_of_total_products , 'number_of_total_orders' => $number_of_total_orders , 'total_price' => $total_price]);
    }

    public function cuttingOrdersByMaterial($mq_r_code)
    {
        /*$companyProducts = Product::with('productType:id,name', 'size:id,name')
            ->whereHas('material', function ($q) use ($mq_r_code) {
                $q->where('mq_r_code', $mq_r_code);
            })
            ->where('received', 1)
            //->get()->groupBy('produce_code');
            ->get()->groupBy('product_material_code');*/

        $material_ids = Material::where('mq_r_code' , $mq_r_code)->pluck('id')->toArray();

        $companyProducts = Product::with('productType:id,name', 'size:id,name')
            ->whereIn('material_id' , $material_ids)
            ->where('received', 1)
            //->get()->groupBy('produce_code');
            ->get()->groupBy('product_material_code');

        //return response()->json($companyProducts, 200);

        $data = $this->customizeProducts($companyProducts);
        return response()->json(array_values($data), 200);
    }

    public function customizeProducts($products)
    {
        $data = [];
        foreach ($products as $key => $product) {
            $old_factory_qty = 0;
            $old_company_qty = 0;
            //$oldOrders = BuyOrderProduct::where('produce_code', $key)->get();
            $oldOrders = BuyOrderProduct::where('product_material_code', $key)->get();

            if ($oldOrders && $oldOrders->count() > 0) {
                foreach ($oldOrders as $order) {
                    //except the returned orders
                    $buy_order = BuyOrder::where('id' , $order->buy_order_id)->first();
                    if($buy_order->status != 'returned')
                    {
                        $old_factory_qty += empty($order->factory_qty) ? 0 : $order->factory_qty;
                        $old_company_qty += empty($order->company_qty) ? 0 : $order->company_qty;
                    }
                    
                }
            }

            //$data[$key]['produce_code']  = $key;
            $data[$key]['product_material_code']  = $key;

            //$data[$key]['mq_r_code']     = Product::where('produce_code' , $key)->first()->material->mq_r_code ;
            $data[$key]['mq_r_code']     = Product::where('product_material_code' , $key)->first()->material->mq_r_code ;
            $data[$key]['factory_count'] = intval($product->where('status', 'available')->where('save_order_id', null)->count() / 100 * 90 - $old_factory_qty);
            $data[$key]['company_count'] = ($product->where('status', 'available')->where('save_order_id', '!=', null)->count() + $product->where('status', 'reserved')->where('save_order_id', '!=', null)->count()) - $old_company_qty;
            $data[$key]['size']          = $product->first()->size->name;
            $data[$key]['product_type']  = $product->first()->productType->name;
        }
        return $data;
    }

    public function receiveOrder(Request $request)
    {
        $customer = Customer::updateOrCreate(['phone' => $request->customer['phone']], $request->customer);
        $order = BuyOrder::create([
            'customer_id'   => $customer->id,
            'description'   => $request->description,
            'bar_code'      => generate_buy_order_barcode(),
            'delivery_date' => $request->delivery_date,
            'source'        => $customer->source,
            'price'         => $request->price,
            'order_number'  => $request->order_number ?? null,
        ]);
        foreach ($request->products as $product) {
            if (!isset($product['qty'])   ) {
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
            if(/*array_key_exists("price",$product) &&  $product['price'] > 0 &&*/ $product['qty'] > 0   )
            {
                BuyOrderProduct::create([
                    'buy_order_id'             => $order->id,
                    //'product_material_code'    => Product::where('produce_code' , $product['produce_code'])->first()->product_material_code ,
                    //'produce_code'             => $product['produce_code'],
                    'product_material_code'    => $product['product_material_code'],
                    'produce_code'             => Product::where('product_material_code' , $product['product_material_code'])->first()->produce_code ,
                    'factory_qty'              => $product['factory_qty'] ?? 0,
                    'company_qty'              => $product['company_qty'] ?? 0,
                    'price'                    => 0 //$product['price']
                ]);
            }
        }
    }

    public function editOrder(Request $request)
    {
        $validator = validator()->make($request->all() , [
            'buy_order_id' => 'required|exists:buy_orders,id' ,
            'products' => 'required'
        ]);
        if($validator->fails())
        {
            return response()->json('error' , 200);
        }

        $order = BuyOrder::find($request->buy_order_id);
        if($order->preparation == 'need_prepare')
        {
            $order->buyOrderProducts()->delete();
            $order->update($request->all());
    
            foreach ($request->products as $product) {
                if (!isset($product['qty'])   ) {
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
                if(/*array_key_exists("price",$product) &&  $product['price'] > 0 &&*/ $product['qty'] > 0   )
                {
                    BuyOrderProduct::create([
                        'buy_order_id'             => $order->id,
                        'produce_code'             => $product['produce_code'],
                        'product_material_code'    => Product::where('produce_code' , $product['produce_code'])->first()->product_material_code ,
                        'factory_qty'              => $product['factory_qty'] ?? 0,
                        'company_qty'              => $product['company_qty'] ?? 0,
                        'price'                    => 0 //$product['price']
                    ]);
                }
            }
        }

        else if($order->preparation == 'prepared')
        {
            
        }

        return response()->json('success' , 200);

    } 

    public function editPage($id)
    {
        $order = BuyOrder::findOrFail($id);
        //return $order->buyOrderProducts()->pluck('produce_code')->toArray();
        //return $order->buyOrderProducts->first();
        return view('dashboard.orders.buy_order.edit' , compact('order'));
    }

    public function showOrderInEditPage($id)
    {
        //$data = [];
        $buy_order = BuyOrder::where('id', $id)->with('buyOrderProducts')->first();
        $order_produce_codes = $buy_order->buyOrderProducts()->pluck('produce_code')->toArray();
       
        $products = Product::with('productType:id,name', 'size:id,name')
                            ->whereIn('produce_code' , $order_produce_codes)
                            ->where('received', 1)
                            ->get()
                            ->groupBy('produce_code');

        $data = [];
        foreach ($products as $key => $product) {
            $buy_order_record = BuyOrderProduct::where([  ['buy_order_id' , $buy_order->id] , ['produce_code' , $key] ])->first();

            $old_factory_qty = 0;
            $old_company_qty = 0;
            $oldOrders = BuyOrderProduct::where('produce_code', $key)->get();

            if ($oldOrders && $oldOrders->count() > 0) {
                foreach ($oldOrders as $order) {
                    $buy_order = BuyOrder::where('id' , $order->buy_order_id)->first();
                    if($buy_order->status != 'returned')
                    {
                        $old_factory_qty += empty($order->factory_qty) ? 0 : $order->factory_qty;
                        $old_company_qty += empty($order->company_qty) ? 0 : $order->company_qty;
                    }
                }
            }

            $data[$key]['produce_code']  = $key;
            $data[$key]['mq_r_code']     = Product::where('produce_code' , $key)->first()->material->mq_r_code ;
            $data[$key]['factory_count'] = intval($product->where('status', 'available')->where('save_order_id', null)->count() / 100 * 90 - $old_factory_qty) + $buy_order_record->factory_qty;
            $data[$key]['company_count'] = ($product->where('status', 'available')->where('save_order_id', '!=', null)->count() + $product->where('status', 'reserved')->where('save_order_id', '!=', null)->count()) - $old_company_qty + $buy_order_record->company_qty;
            $data[$key]['size']          = $product->first()->size->name;
            $data[$key]['product_type']  = $product->first()->productType->name;
            $data[$key]['price']         = $buy_order_record->price;
            $data[$key]['qty']           = $buy_order_record->factory_qty + $buy_order_record->company_qty ;
        }
     

        return response()->json(array_values($data), 200);
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
        $order = BuyOrder::findOrFail($id);

        return view('dashboard.orders.buy_order.show', ['id' => $id , 'order' => $order]);
    }

    public function showOrder($id)
    {
        $data = [];
        $data['order'] = BuyOrder::where('id', $id)->with('buyOrderProducts' , 'customer' , 'shippingCompany')->first();
        $order_status = OrderStatus::latest('id')->where('buy_order_id' , $id)->first();
        if($order_status && $order_status->status == $data['order']->confirmation)
        {
            $data['status_message'] = $order_status->status_message;
        }
        else 
        {
            $data['status_message'] = '';
        }
        $data['products'] = $data['order']->buyOrderProducts->map(function ($item) {
            $product = Product::where('produce_code', $item->produce_code)->first();
            return [
                'id'           => $item->id,
                'product_type' => $product && $product->productType ? $product->productType->name : '',
                'product_size' =>  $product && $product->size ? $product->size->name : '',
                'factory_qty'  => intval($item->factory_qty),
                'company_qty'  => intval($item->company_qty),
                'price'        => intval($item->price),
                'mq_r_code'    => $product && $product->material ? $product->material->mq_r_code : ''
            ];
        });

        return response()->json($data, 200);
    }

    
    public function getOrderStatus($id)
    {
        $status = OrderStatus::where('buy_order_id', $id)->first();
        return response()->json($status, 200);
    }
    public function updateOrder(Request $request)
    {
        $order = BuyOrder::find($request->data['order']['id']);

        if($order)
        {
            $order->update([
                'confirmation' => $request->data['order']['confirmation'],
                'pending_date' => $request->data['order']['pending_date'] ?? null,
                'shipping_company_id' => $request->shipping_company_id ?? null 
            ]);
    
            OrderHistory::create([
                'buy_order_id' => $order->id,
                'status'       => $request->data['order']['confirmation'],
                'pending_date' => $request->data['order']['pending_date'] ?? null
            ]);

            $order->orderStatus()->create([
                'buy_order_id'   => $order->id,
                'status'         => $request->data['order']['confirmation'],
                'status_message' => $request->status_message
            ]);
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

    public function export()
    {
        $export = new BuyOrdersExport();
        return Excel::download($export, 'orders.xlsx');
    }

    public function print()
    {
        $orders = BuyOrder::where(function($query){

            if(request()->filled('employee_id'))
            {
                $query->where('created_by' , request()->employee_id);
            }

            if(request()->filled('shipping_company_id'))
            {
                $query->where('shipping_company_id' , request()->shipping_company_id);
            }

            if(request()->filled('confirmation'))
            {
                $query->where('confirmation' , request()->confirmation);
            }

            if(request()->filled('from'))
            {
                $query->where('delivery_date' , '>=' , request()->from); 
            }

            if(request()->filled('to'))
            {
                $query->where('delivery_date' , '<=' , request()->to);  
            }

        })->with('customer' , 'shippingCompany' )->get();

        foreach($orders as $order)
        {
            $order->buyProducts = $order->buyOrderProducts->map(function($item){

                $product = Product::where('produce_code', $item->produce_code)->first();
                return [
                    'id'           => $item->id,
                    'product_type' => $product && $product->productType ? $product->productType->name : '',
                    'product_size' => $product && $product->size ? $product->size->name : '',
                    'factory_qty'  => intval($item->factory_qty),
                    'company_qty'  => intval($item->company_qty),
                    'price'        => intval($item->price),
                    'mq_r_code'    => $product && $product->material ? $product->material->mq_r_code : ''
                ];
            });

            
        }

        ///return $orders;

       
        return view('dashboard.orders.buy_order.print' , compact('orders'));
   

    }

    public function sales()
    {
        $factories = Factory::get();

        /*$buy_orders = BuyOrder::with('products')->where(function($query){

            if(request()->filled('from'))
            {
                $query->where('created_at' , '>=' , request()->from); 
            }

            if(request()->filled('to'))
            {
                $query->where('created_at' , '<=' , request()->to);  
            }

            if(request()->filled('order_number'))
            {
                $query->where('order_number' , 'like' , '%' . request()->order_number . '%');
            }

            if(request()->filled('mq_r_code'))
            {
                $query->whereHas('products' , function($query2){

                    $material_ids = Material::where('mq_r_code' , request()->mq_r_code)->pluck('id')->toArray();

                    $query2->whereIn('material_id' , $material_ids);

                });
            }

            if(request()->filled('factory_id'))
            {
                $query->whereHas('products' , function($query2){

                    $query2->where('factory_id' , request()->factory_id);

                });
                
            }
        })->where('status' , 'done')->paginate(); 
        */
        


        /*$products = BuyOrder::with('products')->where('status' , 'done')->get();

        return $products;
        */

        $products = Product::with('buyOrders')->whereHas('buyOrders' , function($query){

            $query->whereIn('status' , ['done' , 'paid']);

        })->where(function($query){

            if(request()->filled('from'))
            {
                $query->whereHas('buyOrders' , function($query2){
                    $query2->whereDate('buy_orders.created_at' , '>=' , request()->from); 
                });
            }

            else 
            {
                $query->whereHas('buyOrders' , function($query2){
                    $query2->whereDate('buy_orders.created_at' , '>=' , date('Y-m-d')); 
                });
            }

            if(request()->filled('to'))
            {
                $query->whereHas('buyOrders' , function($query2){
                    $query2->whereDate('buy_orders.created_at' , '<=' , request()->to);  
                });
            }

            else 
            {
                $query->whereHas('buyOrders' , function($query2){
                    $query2->whereDate('buy_orders.created_at' , '<=' , date('Y-m-d'));  
                });
            }

            

            if(request()->filled('order_number'))
            {
                $query->whereHas('buyOrders' , function($query2){
                    $query2->where('order_number' , 'like' , '%' . request()->order_number . '%');
                });
            }

            if(request()->filled('mq_r_code'))
            {
                $material_ids = Material::where('mq_r_code' , request()->mq_r_code)->pluck('id')->toArray();
                $query->whereIn('material_id' , $material_ids);
            }

            if(request()->filled('factory_id'))
            {
                $query->where('factory_id' , request()->factory_id);
            }

        })->paginate(25);

        //return $products;

        $number_of_buy_orders = BuyOrder::where('status' , 'done')->count();
        $employees = User::get();
        $shipping_companies = ShippingCompany::get();

        $factories = Factory::get();
        return view('dashboard.orders.buy_order.sales', ['products' => $products , 'employees' => $employees , 'shipping_companies' => $shipping_companies , 'factories' => $factories , 'number_of_buy_orders' => $number_of_buy_orders]);
        //return $buy_orders;
    }

    public function shipping_following()
    {
        $orders = BuyOrder::where(function($query){

            if(request()->filled('shipping_company_id'))
            {
                $query->where('shipping_company_id' , request()->shipping_company_id);
            }

            if(request()->filled('status'))
            {
                $query->where('status' , request()->status);
            }

            if(request()->filled('from'))
            {
                $query->whereDate('created_at' , '>=' , request()->from); 
            }

            if(request()->filled('to'))
            {
                $query->whereDate('created_at' , '<=' , request()->to);  
            }
            
        })->whereHas('shippingOrders')->paginate(25);

        $shipping_companies = ShippingCompany::get();
        return view('dashboard.orders.buy_order.shipping_following' , compact('orders' , 'shipping_companies'));
    }

    public function edit_shipping_fees(Request $request)
    {
        $rules = [
            'buy_order_id'  => 'required|exists:buy_orders,id',
            'shipping_fees' => 'required',
        ];

        $validator = validator()->make($request->all() , $rules);

        if($validator->fails())
        {
            return back()->with('error' , $validator->errors()->first());
        }

        $order = BuyOrder::find($request->buy_order_id);

        $order->shipping_fees = $request->shipping_fees;
        $order->save();

        return back()->with('success' , 'تم التعديل بنجاح');


    }
}
