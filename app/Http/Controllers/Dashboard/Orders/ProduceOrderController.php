<?php

namespace App\Http\Controllers\Dashboard\Orders;

use Illuminate\Http\Request;
use App\Models\Materials\Material;
use App\Models\Orders\CuttingOrder;
use App\Models\Orders\ProduceOrder;
use App\Http\Controllers\Controller;
use App\Models\Organization\Factory;

class ProduceOrderController extends Controller
{
    public function getAllPaginate()
    {
        $data = ProduceOrder::with(
            'cuttingOrder:id',
            'factory:id,name',
        )->paginate();
        return view('dashboard.orders.produce_order.list')->with('data', $data);
    }

    public function getAll()
    {
        return response()->json(ProduceOrder::select('id', 'cutting_order_id')->get(), 200);
    }

    public function createPage()
    {
        $data = [];
        $data['materials'] = Material::select('id', 'mq_r_code')->get();
        $data['cutting_orders'] = CuttingOrder::select('id')->doesntHave('produceOrders')->get();

        return view('dashboard.orders.produce_order.create')->with('data', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'cutting_order_id' => 'required|exists:cutting_orders,id',
            'factory_id' => 'required|exists:factories,id',
            'receiving_date'   => 'required|date',
        ]);

        return response()->json(ProduceOrder::create($request->all()), 200);
    }

    public function editPage($produce_id)
    {
        $data = [];
        $data['factories'] = Factory::select('id', 'name')->get();
        $data['materials'] = Material::select('id', 'mq_r_code')->get();
        $data['cutting_orders'] = CuttingOrder::select('id')->get();
        $data['records'] = ProduceOrder::where('id', $produce_id)->first();
        return view('dashboard.orders.produce_order.edit')->with('data', $data);
    }

    public function update(Request $request)
    {
        $request->validate([
            'produce_id'       => 'exists:produce_orders,id',
            'factory_id'       => 'exists:factories,id',
            'cutting_order_id' => 'exists:cutting_orders,id',
            'receiving_date'   => 'date',
        ]);

        ProduceOrder::find($request->produce_id)->update($request->all());
        return redirect()->route('produce.order.list');
    }


    public function delete(Request $request)
    {
        $request->validate([
            'produce_id' => 'required|exists:produce_orders,id',
        ]);

        ProduceOrder::find($request->produce_id)->delete();
        return redirect()->route('produce.order.list');
    }
}
