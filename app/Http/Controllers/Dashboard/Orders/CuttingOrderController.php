<?php

namespace App\Http\Controllers\Dashboard\Orders;

use Illuminate\Http\Request;
use App\User;
use App\Models\Options\Size;
use App\Models\Orders\CuttingOrder;
use App\Models\Products\ProductType;
use App\Http\Controllers\Controller;
use App\Models\Orders\CuttingOrderProduct;
use Illuminate\Support\Facades\Redirect;

class CuttingOrderController extends Controller
{
    public function getAllPaginate()
    {
        $data = CuttingOrder::with('factory:id,name', 'user:id,name')->orderBy('id', 'DESC')->paginate();
        return view('dashboard.orders.cutting_order.list')->with('data', $data);
    }


    public function getAll()
    {
        return response()->json(CuttingOrder::select('id')->whereDoesntHave('produceOrders')->get(), 200);
    }

    public function createPage()
    {
        $data = [];
        $data['users'] = User::select('id', 'name')->get();
        $data['productTypes'] = ProductType::select('id', 'name')->get();
        $data['sizes'] = Size::select('id', 'name')->get();

        return view('dashboard.orders.cutting_order.create')->with('data', $data);
    }

    public function store(Request $request)
    {
        $order = CuttingOrder::create($request->all());
        if (request('items')) {
            foreach ($request->items as $item) {
                CuttingOrderProduct::create([
                    'cutting_order_id' => $order->id,
                    'product_type_id' => $item['product_type_id'],
                    'size_id' => $item['size_id'],
                    'qty'   => $item['qty']
                ]);
            }
        }
        return response()->json('success', 200);
    }

    public function editPage($cutting_order_id)
    {
        $data = [];
        $data['users'] = User::select('id', 'name')->get();
        $data['productTypes'] = ProductType::select('id', 'name')->get();
        $data['sizes'] = Size::select('id', 'name')->get();

        $data['records'] = CuttingOrder::where('id', $cutting_order_id)->first();

        return view('dashboard.orders.cutting_order.edit')->with('data', $data);
    }

    public function update(Request $request)
    {
        $request->validate([
            'cutting_order_id'                => 'required|exists:cutting_orders,id',
            'product_type_id'                 => 'exists:product_types,id',
            'user_id'                         => 'exists:users,id',
            'size_id'                         => 'exists:sizes,id',
            'layers'                          => 'min:3',
        ]);

        CuttingOrder::find($request->cutting_order_id)->update($request->all());
        return redirect()->route('cutting.material.list');
    }


    public function delete(Request $request)
    {
        $request->validate([
            'cutting_order_id' => 'required|exists:cutting_orders,id',
        ]);

        CuttingOrder::find($request->cutting_order_id)->delete();
        return redirect()->route('cutting.material.list');
    }

    public function getWithProduct($id)
    {
        $cutting_order = CuttingOrder::where('id', $id)->with('user:id,name', 'factory:id,name')->first();
        $orders = CuttingOrderProduct::where('cutting_order_id', $id)->with('productType:id,name', 'size:id,name')->paginate();
        return view('dashboard.orders.cutting_order.show', ['orders' => $orders, 'cutting_order' => $cutting_order]);
    }

    public function addExtraCreate($id)
    {
        $order = CuttingOrder::where('id', $id)->select('id')->first();
        return view('dashboard.orders.cutting_order.edit', ['order' => $order]);
    }

    public function storeExtra(Request $request)
    {
        $order = CuttingOrder::where('id', $request->cutting_order_id)->first();
        if ($request->has('layers')) {
            $order->layers = $request->layers;
        }
        if ($request->has('extra_returns_weight')) {
            $order->extra_returns_weight = $request->extra_returns_weight;
        }
        $order->save();
        if (request('items')) {
            foreach ($request->items as $item) {
                CuttingOrderProduct::create([
                    'cutting_order_id' => $order->id,
                    'product_type_id' => $item['product_type_id'],
                    'size_id' => $item['size_id'],
                    'qty'   => $item['qty']
                ]);
            }
        }
    }

    public function deleteProduct(Request $request)
    {
        CuttingOrderProduct::find($request->id)->delete();
        return Redirect::back();
    }

    public function getFactoryForOrder($id)
    {
        CuttingOrder::find($id)->with('factory:id,name')->first();
    }
}
