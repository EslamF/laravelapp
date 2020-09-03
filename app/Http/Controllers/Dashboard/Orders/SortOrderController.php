<?php

namespace App\Http\Controllers\Dashboard\Orders;

use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Orders\SortOrder;
use App\Models\Products\Product;
use App\Http\Controllers\Controller;

class SortOrderController extends Controller
{
    public function getAllPaginate()
    {
        $orders = SortOrder::with('user')->paginate();
        return view('dashboard.orders.sort_order.list')->with('orders', $orders);
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id'
        ]);

        $request->merge([
            'code' => $this->generateCode()
        ]);

        SortOrder::create($request->all());
        return redirect()->route('sort.order.list');
    }

    public function update(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'code'    => 'unique:sort_orders,code,' . $request->sort_id
        ]);

        SortOrder::find($request->sort_id)->update([
            'code' => $request->code,
            'user_id' => $request->user_id
        ]);
        return redirect()->route('sort.order.list');
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
        SortOrder::find($request->sort_id)->delete();

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
        return view('dashboard.orders.sort_order.sort_product')->with('data', $data);
    }

    public function sortProduct(Request $request)
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
