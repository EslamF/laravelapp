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
        $data['material'] = Material::select('id', 'mq_r_code')->get();
        return view('dashboard.orders.spreading_materials.create')->with('data', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'material_id' => 'required|exists:materials,id',
            'user_id'     => 'required|exists:users,id',
            'weight'      => 'required'
        ]);

        SpreadingOutMaterialOrder::create($request->all());
        return redirect()->route('spreading.material.list');
    }

    public function editPage($spreading_id)
    {
        $data = [];
        $data['users'] = User::select('id', 'name')->get();
        $data['material'] = Material::select('id', 'mq_r_code')->get();
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
            'weight'=>'required'
        ]);

        SpreadingOutMaterialOrder::find($request->spreading_id)->update($request->all());
        return redirect()->route('spreading.material.list');
    }


    public function delete(Request $request)
    {
        $request->validate([
            'spreading_id' => 'exists:spreading_out_material_orders,id',
        ]);

        SpreadingOutMaterialOrder::find($request->spreading_id)->delete();
        return redirect()->route('spreading.material.list');
    }

    public function getAll()
    {
        return response()->json(SpreadingOutMaterialOrder::select('id')->get(), 200);
    }
}
