<?php

namespace App\Http\Controllers\Dashboard\Orders;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Materials\Material;
use App\Models\Materials\MaterialType;
use App\Models\Organization\Supplier;
use DateTime;
class ReceivingMaterialController extends Controller
{
    public function store(Request $request)
    {
        $validate = $request->validate([
            'mq_r_code' => 'required',
            'type' => 'required',
            'material_type_id' => 'requiredIf:type,material|exists:material_types,id',
            'buyer_id' => 'required|exists:users,id',
            'supplier_id' => 'required|exists:suppliers,id',
            'qty' => 'requiredIf:type,accessory',
            'weight' => 'requiredIf:type,material',
            'bill_number' => 'required',
            'color' => 'requiredIf:type,material',
            'number_of_vestments' => 'requiredIf:type,material|integer',
            //'barcode'   => ''
        ]);

        $request_data = [];
        
        if($request->type == 'material')
        {
            $request_data = $request->except(['qty']);
        }
        else 
        {
            $request_data = $request->except(['weight' , 'material_type_id' , 'color','number_of_vestments' ]);
        }

        $old_material = Material::where('mq_r_code' , $request->mq_r_code)->first();
        if($old_material && $request->type == 'material' )
        {
            $old_material->weight = $old_material->weight + $request->weight;

            if(!$old_material->barcode)
            {
                $old_material->barcode = $this->generateEANCode() ?? generateEANCode();
            }
            $old_material->save();

            $old_material->update([
                'material_type_id' => $request->material_type_id , 
                'buyer_id'         => $request->buyer_id ,
                'supplier_id'      => $request->supplier_id ,
                'bill_number'      => $request->bill_number ,
                'color'            => $request->color,
                'number_of_vestments' => $request->number_of_vestments
            ]);
        }

        else if($old_material && $request->type == 'accessory')
        {
            $old_material->qty = $old_material->qty + $request->qty;
            if(!$old_material->barcode)
            {
                $old_material->barcode = $this->generateEANCode() ?? generateEANCode();
            }
            $old_material->save();

            $old_material->update([
                'buyer_id'         => $request->buyer_id ,
                'supplier_id'      => $request->supplier_id ,
                'bill_number'      => $request->bill_number ,
            ]);
        }
        else 
        {
            $material = Material::create($request_data);
            $material->barcode = $this->generateEANCode() ?? generateEANCode();
            $material->save();
        }
        $material = $material ?? $old_material;
        return view('dashboard.orders.receiving_materials.print' , compact('material'));
        //return redirect()->route('order.receiving.material')->with('success' , __('words.added_successfully'));
    }

    public function createPage()
    {
        
        $data = [];
        $data['users'] = User::select('id', 'name')->whereHas('roles', function ($q) {
            $q->whereHas('permissions', function ($query) {
                $query->where('name', 'buy-material');
            });
        })->get();
 
        $data['suppliers'] = Supplier::select('id', 'name')->get();
        $data['material_types'] = MaterialType::select('id', 'name')->get();
        return view('dashboard.orders.receiving_materials.create')->with('data', $data);
    }

    public function getAllPaginate()
    {
        $receiving = Material::with('materialType:id,name', 'supplier:id,name', 'user:id,name', 'buyer:id,name')->paginate();
        return view('dashboard.orders.receiving_materials.list')->with('receiving', $receiving);
    }

    public function editPage($material_id)
    {
        $data = [];
        //$data['users'] = User::select('id', 'name')->get();
        $data['users'] = User::select('id', 'name')->whereHas('roles', function ($q) {
            $q->whereHas('permissions', function ($query) {
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
        //return $request;
        
            /*'mq_r_code' => 'required|unique:materials,mq_r_code',
            'type' => 'required',
            'material_type_id' => 'requiredIf:type,material|exists:material_types,id',
            'buyer_id' => 'required|exists:users,id',
            'supplier_id' => 'required|exists:suppliers,id',
            'qty' => 'requiredIf:type,accessory',
            'weight' => 'requiredIf:type,material',
            'bill_number' => 'required',
            'color' => 'requiredIf:type,material',*/
        

        $request->validate([
            'material_id' => 'required|exists:materials,id',
            'mq_r_code' => 'required|unique:materials,mq_r_code,' . $request->material_id,
            'material_type_id' => 'requiredIf:type,material|exists:material_types,id',
            'buyer_id'     => 'required|exists:users,id',
            'supplier_id' => 'required|exists:suppliers,id',
            'bill_number' => 'required|min:3',
            'color' => 'requiredIf:type,material',
            'weight' => 'requiredIf:type,material',
            'qty'   => 'requiredIf:type,accessory' ,
            'type'  => 'required|in:material,accessory',
            'number_of_vestments' => 'requiredIf:type,material|integer'
        ]);

        Material::find($request->material_id)->update($request->all());
        return redirect()->route('order.receiving.material')->with('success' , __('words.updated_successfully'));
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

    public function getMaterialData($mq_r_code) 
    {
        $material = Material::where('mq_r_code' , $mq_r_code)
                              ->orWhere('barcode' , $mq_r_code)->first();
        if($material)
        {
            return response()->json($material , 200);
        }

        else 
        {
            return response()->json('error' , 200);
        }
    }

    public function print($id)
    {
        $material = Material::findOrFail($id);
        return view('dashboard.orders.receiving_materials.print' , compact('material'));
    }

    public function generateBarcode()
    {
        $code = rand(0, 6000000000000);
        $check = Material::where('barcode', $code)->exists();
        if ($check) {
            $this->generateBarcode();
        } else {
            return $code;
        }
    }

    public function generateEANCode()
    {
        $date = new DateTime();
        $time = $date->getTimestamp();
        $code = '20' . str_pad($time, 10, '0');
        $weightflag = true;
        $sum = 0;
        for ($i = strlen($code) - 1; $i >= 0; $i--) {
            $sum += (int)$code[$i] * ($weightflag ? 3 : 1);
            $weightflag = !$weightflag;
        }
        $code .= (10 - ($sum % 10)) % 10;

        $check = Material::where('barcode', $code)->exists();
        if ($check || !$code) {
            $this->generateEANCode();
        } else {
            return $code;
        }
    }
}
