<?php

namespace App\Http\Controllers\Dashboard\Orders;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Models\Materials\Material;
use App\Models\Orders\SpreadingOutMaterialOrder;

class SpreadingMaterialController extends Controller
{
    public function getAllPaginate()
    {
        $data = SpreadingOutMaterialOrder::with('user:id,name', 'material:id,mq_r_code')->paginate();
        return view('dashboard.orders.spreading_materials.list')->with('data', $data);
    }

    public function createPage()
    {
        $data = [];
        $data['users'] = User::select('id', 'name')->get();
        $data['material'] = Material::select('id', 'mq_r_code')->where('weight', '!=', null)->get();
        return view('dashboard.orders.spreading_materials.create')->with('data', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'material_id' => 'required|exists:materials,id',
            'user_id'     => 'required|exists:users,id',
            'weight'      => 'required|numeric|gt:0'
        ]);

        $order = SpreadingOutMaterialOrder::create($request->all());
        if ($order) {
            $material = Material::where('id', $request->material_id)->first();
            $material->weight = $material->weight - $request->weight;
            $material->save();
        }
        return redirect()->route('spreading.material.list');
    }

    public function editPage($spreading_id)
    {
        $data = [];
        $data['users'] = User::select('id', 'name')->get();
        $data['material'] = Material::select('id', 'mq_r_code')->where('weight', '!=', null)->get();
        $data['spreading'] = SpreadingOutMaterialOrder::where('id', $spreading_id)
            ->with('user:id,name', 'material:id,mq_r_code')
            ->first();
        return view('dashboard.orders.spreading_materials.edit')->with('data', $data);
    }

    public function update(Request $request)
    {
        $request->validate([
            'spreading_id' => 'exists:spreading_out_material_orders,id',
            'material_id' => 'exists:materials,id',
            'user_id'     => 'exists:users,id',
            'weight' => 'required|numeric|gt:0,'
        ]);

        $order = SpreadingOutMaterialOrder::where('id', $request->spreading_id)->first();
        $material = Material::where('id', $request->material_id)->first();
        if ($order->weight > $request->weight) {
            $material->update([
                'weight' => $material->weight + ($order->weight - $request->weight)
            ]);
        }

        if ($order->weight < $request->weight) {
            $material->update([
                'weight' => $material->weight - ($request->weight - $order->weight)
            ]);
        }
        $order->update($request->all());
        return redirect()->route('spreading.material.list');
    }


    public function delete(Request $request)
    {
        $request->validate([
            'spreading_id' => 'exists:spreading_out_material_orders,id',
        ]);

        $order = SpreadingOutMaterialOrder::where('id', $request->spreading_id)->first();
        $material  = Material::where('id', $order->material_id)->first();
        $material->weight = $material->weight + $order->weight;
        $material->save();
        $order->delete();
        return redirect()->route('spreading.material.list');
    }

    public function getAll()
    {
        return response()->json(SpreadingOutMaterialOrder::select('id')->whereDoesntHave('cuttingOrders')->get(), 200);
    }
}
