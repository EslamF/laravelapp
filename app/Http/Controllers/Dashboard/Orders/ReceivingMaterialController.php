<?php

namespace App\Http\Controllers\Dashboard\Orders;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Materials\Material;
use App\Models\Materials\MaterialType;
use App\Models\Organization\Supplier;

class ReceivingMaterialController extends Controller
{
    public function store(Request $request)
    {
        $validate = $request->validate([
            'mq_r_code' => 'required',
            'material_type_id' => 'required|exists:material_types,id',
            'user_id' => 'required|exists:users,id',
            'supplier_id' => 'required|exists:suppliers,id',
            'bill_number' => 'required',
            'description' => 'required',
            'color' => 'required'
        ]);

        Material::create($request->all());
        return redirect()->route('order.receiving.material');
    }

    public function createPage()
    {
        $data = [];
        $data['users'] = User::select('id', 'name')->get();
        $data['suppliers'] = Supplier::select('id', 'name')->get();
        $data['material_types'] = MaterialType::select('id', 'name')->get();
        return view('dashboard.orders.receiving_materials.create')->with('data', $data);
    }

    public function getAllPaginate()
    {
        $receiving = Material::with('materialType:id,name', 'supplier:id,name', 'user:id,name')->paginate();
        return view('dashboard.orders.receiving_materials.list')->with('receiving', $receiving);
    }

    public function editPage($material_id)
    {
        $data = [];
        $data['users'] = User::select('id', 'name')->get();
        $data['suppliers'] = Supplier::select('id', 'name')->get();
        $data['material_types'] = MaterialType::select('id', 'name')->get();
        $data['material'] = Material::where('id', $material_id)
            ->first();

        return view('dashboard.orders.receiving_materials.edit')->with('data', $data);
    }

    public function update(Request $request)
    {

        $request->validate([
            'material_id' => 'required|exists:materials,id',
            'code' => 'min:3',
            'mq_r_code' => 'min:3',
            'material_type_id' => 'exists:material_types,id',
            'user_id'     => 'exists:users,id',
            'supplier_id' => 'exists:suppliers,id',
            'bill_number' => 'min:3',
            'description' => 'min:3',
        ]);

        Material::find($request->material_id)->update($request->all());
        return redirect()->route('order.receiving.material');
    }

    public function delete(Request $request)
    {
        $request->validate([
            'material_id' => 'required|exists:materials,id'
        ]);

        Material::find($request->material_id)->delete();
        return redirect()->route('order.receiving.material');
    }
}
