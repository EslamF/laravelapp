<?php

namespace App\Http\Controllers\Dashboard\Orders;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Materials\Material;
use App\Models\Materials\Vestment;
use App\Models\Materials\MaterialType;
use App\Models\Organization\Supplier;
use DateTime;
class ReceivingMaterialController extends Controller
{
    public function store(Request $request)
    {
        //return $request;
        $validate = $request->validate([
            'mq_r_code' => 'required',
            'type' => 'required',
            'material_type_id' => 'requiredIf:type,material|exists:material_types,id',
            'buyer_id' => 'required|exists:users,id',
            'supplier_id' => 'required|exists:suppliers,id',
            'qty' => 'requiredIf:type,accessory',
            //'weight' => 'requiredIf:type,material',
            'bill_number' => 'required',
            'color' => 'requiredIf:type,material',
            'number_of_vestments' => 'requiredIf:type,material',
            'vestments' => 'requiredIf:type,material|array',
            'vestments.*'  => 'required|numeric',
            //'barcode'   => ''
        ]);

        $request_data = [];
        
        if($request->type == 'material')
        {
            $request_data = $request->except(['qty']);
        }
        else 
        {
            $request_data = $request->except(['weight' , 'material_type_id' , 'color','number_of_vestments','vestments' ]);
        }

        $material = Material::create($request_data);
        $material->barcode = generate_material_barcode() ?? generate_material_barcode();


        if($request->type == 'material')
        {
            for($i = 0; $i<$request->number_of_vestments; $i++)
            {
                $material->vestments()->create([ 
                    'name'    => 'توب ' . ($i + 1) ,
                    'weight'  => $request->vestments[$i] ,
                    'barcode' =>  generate_vestment_barcode(),
                ]);
            }
        }
       
        $material->save();

        $vestments = $material->vestments;
        return redirect()->route('receiving.material.print_vestments' , $material->id);
        //return view('dashboard.orders.receiving_materials.vestment_print' , compact('vestments') );
        //return view('dashboard.orders.receiving_materials.print' , compact('material'));
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
        $request->validate([
            'material_id' => 'required|exists:materials,id',
            'mq_r_code' => 'required',
            'material_type_id' => 'requiredIf:type,material|exists:material_types,id',
            'buyer_id'     => 'required|exists:users,id',
            'supplier_id' => 'required|exists:suppliers,id',
            'bill_number' => 'required|min:3',
            'color' => 'requiredIf:type,material',
            //'weight' => 'requiredIf:type,material',
            'qty'   => 'requiredIf:type,accessory' ,
            'type'  => 'required|in:material,accessory',
            'vestments' => 'requiredIf:type,material|array',
            'vestments.*'  => 'required|numeric',
        ]);

        $material = Material::findOrFail($request->material_id);
      
        
        if($request->type == 'material')
        {
            $material->vestments()->delete();
            for($i = 0; $i<$request->number_of_vestments; $i++)
            {
                $material->vestments()->create([ 
                    'name'    => 'توب ' . ($i + 1) ,
                    'weight'  => $request->vestments[$i] ,
                    'barcode' =>  generate_vestment_barcode(),
                ]);
            }
        }

        $material->update($request->all());

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
        $material = Material::find($material_code);
        
        //$material->vestments
        //$material = Material::select('id', 'mq_r_code', 'weight')->where('id', $material_code)->first();
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

    public function print_vestments($id)
    {
        $material = Material::findOrFail($id);
        $vestments = $material->vestments;
        return view('dashboard.orders.receiving_materials.vestment_print' , compact('vestments') );
    }

    public function print_vestments2($ids)
    { 
        //return $request;
        $ids = json_decode($ids , true);
        $vestments = Vestment::whereIn('id' , $ids )->get();
        return view('dashboard.orders.receiving_materials.vestment_print' , compact('vestments') );
    }

}
