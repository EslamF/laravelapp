<?php

namespace App\Http\Controllers\Dashboard\Orders;

use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Orders\SortOrder;
use App\Models\Products\Product;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;


class SortOrderController extends Controller
{
    public function getAllPaginate()
    {
        $orders = SortOrder::with('user' , 'users')->paginate(); 
        return view('dashboard.orders.sort_order.list')->with('orders', $orders);
    }

    public function store(Request $request)
    {
        $request->validate([
            'users'  => 'required|array' , 
            'users.*'=> 'exists:users,id'
        ]);

        $request->merge([
            'code' => $this->generateCode(),
            /*'user_id' => User::first()->id*/
        ]);

        $order = SortOrder::create($request->all());
        $order->users()->attach($request->users);
        return redirect()->route('sort.order.list')->with('success' , __('words.added_successfully') );
    }

    public function update(Request $request)
    {
        $request->validate([
            'users'  => 'required|array' , 
            'users.*'=> 'exists:users,id',
            'code'    => 'required|unique:sort_orders,code,' . $request->sort_id ,
            'sort_id' => 'required|exists:sort_orders,id' , 
        ]);

        $order = SortOrder::find($request->sort_id);
        $order->update([
            'code' => $request->code
        ]);

        $order->users()->sync($request->users);
        return redirect()->route('sort.order.list')->with('success' , __('words.updated_successfully') );
    }

    public function editPage($sort_id)
    {
        $data = [];
        $data['users'] = User::select('id', 'name')->get();
        $data['sort'] = SortOrder::where('id', $sort_id)->first();
        return view('dashboard.orders.sort_order.edit')->with('data', $data);
    }

    public function createPage()
    {
        $users = User::select('id', 'name')->get();
        return view('dashboard.orders.sort_order.create')->with('users', $users);
    }

    public function delete(Request $request)
    {
        $request->validate([
            'sort_id' => 'required|exists:sort_orders,id'
        ]);
        $order = SortOrder::find($request->sort_id);
        $order->users()->detach();
        $order->delete();

        return redirect()->route('sort.order.list');
    }

    public function generateCode()
    {
        $code = rand(0, 6000000000000);
        $check = SortOrder::where('code', $code)->exists();
        if ($check) {
            $this->generateCode();
        } else {
            return $code;
        }
    }

    public function showSortedProducts($sort_id)
    {
        $data = [];
        $data['records'] = Product::whereHas('sortOrder', function ($q) use ($sort_id) {
            return $q->where('id', $sort_id);
        })->orderBy('sort_date', 'DESC')->paginate();
        $data['sort_id'] = $sort_id;

        $order = SortOrder::findOrFail($sort_id);
        $data['sort_order'] = $order;
        return view('dashboard.orders.sort_order.sort_product')->with('data', $data);
    }

    /*public function sortProduct(Request $request)
    {
        $request->validate([
            'prod_code' => 'required|exists:products,prod_code',
            'damage_type' => 'required|in:ironing,tailoring,dyeing,fine'
        ]);

        $dateNow = Carbon::now();
        $product = Product::where('prod_code', $request->prod_code)->first();

        if (isset($product)) {

            $product->update([
                'damage_type' => $request->damage_type == 'fine' ? '' : $request->damage_type,
                'sort_date' => $dateNow->toDateTimeString(),
                'sort_order_id' => $request->sort_id,
                'sorted' => 1,
                'status' => $request->damage_type == 'fine' ? 'available' : 'damaged',
            ]);
        }
        return redirect()->route('sort.product.list', $request->sort_id);
    }*/

    public function sortProduct(Request $request)
    {
        $validator = validator()->make( $request->all() ,  [
            'products'    => 'required|array',
            'products.*'  => 'exists:products,prod_code' ,
            'damage_type' => 'required|in:ironing,tailoring,dyeing,fine'
        ]);

        if($validator->fails())
        {
            return response()->json('error' , 200);
        }

        $dateNow = Carbon::now();

        foreach($request->products as $code)
        {
            $product = Product::where('prod_code', $code)->first();

            if (isset($product)) {
    
                /*$product->update([
                    'damage_type' => $request->damage_type == 'fine' ? '' : $request->damage_type,
                    'sort_date' => $dateNow->toDateTimeString(),
                    'sort_order_id' => $request->sort_id,
                    'sorted' => 1,
                    'status' => $request->damage_type == 'fine' ? 'available' : 'damaged',
                ]);*/
            }
        }

        Product::whereIn('prod_code' , $request->products)
                ->update([
                    'damage_type' => $request->damage_type == 'fine' ? '' : $request->damage_type,
                    'sort_date' => $dateNow->toDateTimeString(),
                    'sort_order_id' => $request->sort_id,
                    'sorted' => 1,
                    'status' => $request->damage_type == 'fine' ? 'available' : 'damaged',
                ]);
        Session::flash('success' , __('words.added_successfully'));
        return response()->json('success' , 200);
        //return redirect()->route('sort.product.list', $request->sort_id);
    }

    public function scanningPage($sort_order_id)
    {
        return view('dashboard.orders.sort_order.scanning' , compact('sort_order_id'));
    }

    public function checkProduct(Request $request)
    {
        if($request->filled('prod_code'))
        {
            $product = Product::where('prod_code' , $request->prod_code)->where('sorted' , 0)->first();
            if($product)
            {

                return response()->json('success' , 200);
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

    public function removeSortedProduct(Request $request)
    {

        $request->validate([
            'product_id' => 'required|exists:products,id'
        ]);

        Product::find($request->product_id)->update([
            'sort_date' => null,
            'sort_order_id' => null,
            'sorted'    => 0,
            'status'    => 'available',
            'damage_type' => null
        ]);

        return redirect()->route('sort.product.list', $request->sort_id);
    }
}
