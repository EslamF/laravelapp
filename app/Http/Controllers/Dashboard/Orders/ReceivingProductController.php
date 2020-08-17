<?php

namespace App\Http\Controllers\Dashboard\Orders;

use App\Models\Options\Size;
use Illuminate\Http\Request;
use App\Models\Orders\ProduceOrder;
use App\Models\Products\ProductType;
use App\Http\Controllers\Controller;
use App\Models\Orders\ReceivingOrder;

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
}