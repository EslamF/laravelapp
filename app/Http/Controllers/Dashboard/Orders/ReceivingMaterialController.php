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
            'mq_r_code' => 'required|unique:materials,mq_r_code',
            'type' => 'required',
            'material_type_id' => 'requiredIf:type,material|exists:material_types,id',
            'buyer_id' => 'required|exists:users,id',
            'supplier_id' => 'required|exists:suppliers,id',
            'qty' => 'requiredIf:type,accessory',
            'weight' => 'requiredIf:type,material',
            'bill_number' => 'required',
            'color' => 'requiredIf:type,material',
        ]);

        $request_data = [];
        
        if($request->type == 'material')
        {
            $request_data = $request->except(['qty']);
        }
        else 
        {
            $request_data = $request->except(['weight' , 'material_type_id' , 'color' ]);
        }
        Material::create($request_data);
        return redirect()->route('order.receiving.material');
    }

    public function createPage()
    {
        $data = [];
        $data['users'] = User::select('id', 'name')->whereHas('roles', function ($q) {
            $q->whereHas('peremissions', function ($query) {
                $query->where('name', 'buy-material');
            });
        })->get();
        $data['suppliers'] = Supplier::select('id', 'name')->get();
        $data['material_types'] = MaterialType::select('id', 'name')->get();
        return view('dashboard.orders.receiving_materials.create')->with('data', $data);
    }

    public function getAllPaginate()
    {
        $receiving = Material::with('materialType:id,name', 'supplier:id,name', 'createdBy:id,name', 'buyer:id,name')->paginate();
        return view('dashboard.orders.receiving_materials.list')->with('receiving', $receiving);
    }

    public function editPage($material_id)
    {
        $data = [];
        //$data['users'] = User::select('id', 'name')->get();
        $data['users'] = User::select('id', 'name')->whereHas('roles', function ($q) {
            $q->whereHas('peremissions', function ($query) {
                $query->where('name', 'buy-material');
            });
        })->get();
        $data['suppliers'] = Supplier::select('id', 'name')->get();
        $data['material_types'] = MaterialType::select('id', 'name')->get();
        $data['material'] = Material::where('id', $material_id)->first();

        return view('dashboard.orders.receiving_materials.edit')->with('data', $data);
    }

    public function update(Request $request)
    {

        $request->validate([
            'material_id' => 'required|exists:materials,id',
            'mq_r_code' => 'unique:materials,mq_r_code,' . $request->material_id,
            'material_type_id' => 'requiredIf:type,material|exists:material_types,id',
            'user_id'     => 'exists:users,id',
            'supplier_id' => 'exists:suppliers,id',
            'bill_number' => 'min:3',
            'color' => 'requiredIf:type,material',
            'weight' => 'requiredIf:type,material',
            'qty'   => 'requiredIf:type,accessory'

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
        return response()->json('deleted', 200);
    }

    public function checkWeight($material_code)
    {
        $material = Material::select('id', 'mq_r_code', 'weight')->where('id', $material_code)->first();
        return response()->json($material, 200);
    }
}
