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

class ReceivingProductController extends Controller
{
    public function getAllPaginate()
    {
        $data = ReceivingOrder::with(
            'productType:id,name',
            'size:id,name'
        )->paginate();

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

        ReceivingOrder::find($request->receiving_id)->delete();
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

    public function products($id, $received)
    {
        $produce = ProduceOrder::where('id', $id)->first();
        $products = Product::select('id', 'prod_code', 'produce_code', 'product_type_id', 'size_id')
            ->with('productType:id,name', 'size:id,name')
            ->where('cutting_order_id', $produce->cutting_order_id)
            ->where('received', $received)
            ->get()->groupBy('produce_code');

        $data = [];

        foreach ($products as $key => $product) {
            $data[$key]['produce_code'] = $key;
            $data[$key]['count'] = $product->count();
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
        if ($request->products) {
            foreach ($request->products as $product) {
                Product::where('produce_code', $product['produce_code'])->update([
                    'receiving_order_id' => $receiveOrder->id,
                    'received' => 0
                ]);
            }
        }
        if ($request->received_products) {
            foreach ($request->received_products as $product) {
                Product::where('produce_code', $product['produce_code'])->update([
                    'receiving_order_id' => $receiveOrder->id,
                    'received' => 1
                ]);
            }
        }
        $check = ReceivingOrder::whereHas('products', function ($q) {
            $q->where('received', 0);
        })->first();

        if ($check) {

            $receiveOrder->update([
                'status' => '0'
            ]);
        } else {
            $receiveOrder->update([
                'status' => '1'
            ]);
        }
        return response()->json('success', 200);
    }

    public function getAll()
    {
        return response()->json(ReceivingOrder::selcet('id')->get(), 200);
    }
}
