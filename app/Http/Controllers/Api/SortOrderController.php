<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Orders\SortOrder;
use App\Models\Products\Product;

class SortOrderController extends Controller
{
    public function index(Request $request)
    {
        $orders = SortOrder::with('user' , 'users')->paginate(); 
        return responseJson(1 , 'success' , $orders);
    }

    public function store(Request $request)
    {
        $validator = validator()->make( $request->all() ,  [
            'order_id'    => 'required|exists:sort_orders,id',
            'products'    => 'required|array',
            'products.*'  => 'exists:products,prod_code' ,
            'damage_type' => 'required|in:ironing,tailoring,dyeing,fine'
        ]);

        if($validator->fails())
        {
            return responseJson(0 , $validator->errors()->first() , $validator->errors());
        }

        $dateNow = Carbon::now();

        foreach($request->products as $product_code)
        {
            $product = Product::where('prod_code' , $product_code)->where('sorted' , 0)->first();
            if(!$product)
            {
                return responseJson(0 , "لا يمكن إضافة المنتج $product_code");
            }
          
        }

        $products = Product::whereIn('prod_code' , $request->products)
                            ->update([
                                'damage_type' => $request->damage_type == 'fine' ? '' : $request->damage_type,
                                'sort_date' => $dateNow->toDateTimeString(),
                                'sort_order_id' => $request->order_id,
                                'sorted' => 1,
                                'status' => $request->damage_type == 'fine' ? 'available' : 'damaged',
                            ]);

        return responseJson(1 , 'success');
    }
}
