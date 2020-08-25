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
            'product_type_id'  => 'required|exists:product_types,id',
            'size_id'          => 'required|exists:sizes,id',
            'produce_order_id' => 'required|exists:produce_orders,id',
            'status'           => 'required|in:0,1',
            'receiving_date'   => 'required|date',
            'qty'              => 'required',
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
        $produce = ProduceOrder::where('id', $id)->first();
        $products = CuttingOrderProduct::where('cutting_order_id', $produce->cutting_order_id)
            ->where('received', 0)
            ->with('productType:id,name', 'size:id,name')->get();
        return response()->json($products, 200);
    }

    public function productsReceived($id)
    {
        $produce = ProduceOrder::where('id', $id)->first();
        $products = CuttingOrderProduct::where('cutting_order_id', $produce->cutting_order_id)
            ->where('received', 1)
            ->with('productType:id,name', 'size:id,name')->get();
        return response()->json($products, 200);
    }

    public function approveOrUnapprove(Request $request)
    {
        $product = CuttingOrderProduct::where('id', $request->id)->first();
        $produce = ProduceOrder::where('cutting_order_id', $product->cutting_order_id)->first();

        $product->update([
            'received' => $request->status
        ]);
        $check = CuttingOrder::where('id', $product->cutting_order_id)->whereHas('CuttingOrderProducts', function ($q) {
            $q->where('received', 0);
        })->first();
        if ($check) {
            $receive = ReceivingOrder::updateOrCreate(['produce_order_id' => $produce->id], [
                'status' => 0
            ]);
        } else {
            $receive = ReceivingOrder::updateOrCreate(['produce_order_id' => $produce->id], [
                'status' => 1
            ]);
        }

        $item = Product::where('cutting_order_product_id', $request->id)->first();
        $item->update([
            'receiving_order_id' => $receive->id
        ]);
        return response()->json('update', 200);
    }

    public function changeStatus(Request $request)
    {
        $receiveOrder = ReceivingOrder::updateOrCreate(['produce_order_id' => $request->produce_order_id], $request->all());
        $cutting_id = $receiveOrder->produceOrder->cutting_order_id;
        $check = CuttingOrder::where('id', $cutting_id)->whereHas('CuttingOrderProducts', function ($q) {
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
