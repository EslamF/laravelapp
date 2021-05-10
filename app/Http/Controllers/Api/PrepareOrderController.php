<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Orders\BuyOrder;
use App\Models\Users\Customer;
use App\Models\Products\ProductType;
use App\Models\Materials\Material;
use App\Models\Options\Size;
use App\Models\Products\Product;

class PrepareOrderController extends Controller
{
    public function index()
    { 
        $orders = BuyOrder::select('id', 'bar_code', 'delivery_date', 'confirmation' , 'shipping_company_id' , 'customer_id' , 'order_number')
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
            ->with(['shippingCompany' , 'customer'])
            ->paginate();

            return responseJson(1 , 'success' , $orders );
    }

    public function show(Request $request)
    {
        $rules = [
            'order_id' => 'required|exists:buy_orders,id'
        ];

        $validator = validator()->make($request->all() , $rules);

        if($validator->fails())
        {
            return responseJson(0 , $validator->errors()->first() , $validator->errors());
        }

        $order = BuyOrder::where('confirmation', '!=', 'canceled')
                        ->where('preparation', 'need_prepare')
                        ->with(['shippingCompany' , 'customer'])
                        ->find($request->order_id);


        $order->products = $order->buyOrderProducts->map(function ($item) use ($order) {

            $type = ProductType::whereHas('products', function ($q) use ($item) {
                $q->where('produce_code', $item->produce_code);
            })->first()->name;

            $size = Size::whereHas('products', function ($q) use ($item) {
                $q->where('produce_code', $item->produce_code);
            })->first()->name;

            $material_id = Product::where('produce_code' , $item->produce_code)->first()->material_id;
            $material = Material::where('id' , $material_id)->first();

            return [
                'buy_order_id'  => $order->id,
                'produce_code'  => $item->produce_code,
                'product'       => $type,
                'size'          => $size,
                'qty'           => intval($item->company_qty),
                'material_code' => $material->mq_r_code
            ];
        });
        return responseJson(1 , 'success' , $order);
    }

    public function store(Request $request)
    {
        $rules = [
            'order_id'   => 'required|exists:buy_orders,id',
            'products'   => 'required|array',
            'products.*' => 'exists:products,prod_code', 
        ];

        $validator = validator()->make($request->all() , $rules);
        if($validator->fails())
        {
            return responseJson(0 , $validator->errors()->first() , $validator->errors());
        }

        $order = BuyOrder::where('confirmation', '!=', 'canceled')
                        ->where('preparation', 'need_prepare')
                        ->with(['shippingCompany' , 'customer'])
                        ->find($request->order_id);
        if(!$order)
        {
            return responseJson(0 , "الطلب غير متاح" );
        }

        $arr = [];
        $order_products_produce_codes = $order->buyOrderProducts->pluck('produce_code')->toArray();



        

        $total_quantity_of_order = 0;
        foreach($order->buyOrderProducts as $order_product)
        {
            $total_quantity_of_order += $order_product->company_qty;
        }

       if(count($request->products) != $total_quantity_of_order )
       {
           return responseJson(0 , "يجب إدخال $total_quantity_of_order من المنتجات");
       }
        


       $products_quantities = [];
        foreach($request->products as $product_code)
        {
            $product = Product::where('prod_code', $product_code)
                                ->where('save_order_id', '!=', null)
                                ->where('status', '!=', 'reserved')
                                ->first();

            $item = $order->buyOrderProducts()->where('produce_code' , $product->produce_code)->first();
            if(!$product)
            {
                return responseJson(0 , "المنتج $product_code غير متاح");
            }

            else if(in_array($product_code , $arr))
            {
                return responseJson(0 , "المنتج $product_code مكرر");
            }

            else  if(!in_array($product->produce_code , $order_products_produce_codes) )
            {
                return responseJson(0 , "المنتج $product_code غير صحيح");
            }

            else if( array_key_exists($product->produce_code , $products_quantities) && $products_quantities[$product->produce_code] >= $item->company_qty  )
            {
                return responseJson(0 , "لا يمكن إضافة عنصر آخر من المنتج  $product_code ");
            }
            else 
            {
                array_push($arr , $product_code);
                if (array_key_exists($product->produce_code , $products_quantities)  )
                {
                    $products_quantities[$product->produce_code]++;
                }
                else 
                {
                    $products_quantities[$product->produce_code] = 1;
                }
            }
            
        }


        $order = BuyOrder::find($request->order_id);
        $order->preparation = 'prepared';
        $order->save();


        $ids = Product::whereIn('prod_code' , $request->products)->pluck('id')->toArray();
        $order->products()->attach($ids);

        Product::whereIn('prod_code' , $request->products)
                ->update(['status' => 'reserved']);

        return responseJson(1 , 'success');
    }
}
