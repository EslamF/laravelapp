<?php

namespace App\Http\Controllers\Dashboard\Orders;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Models\Materials\Material;
use App\Models\Orders\SpreadingOutMaterialOrder;
use App\Models\Organization\Factory;
// use App\Models\Orders\CuttingOrder;
use App\Models\Materials\Vestment;

class SpreadingMaterialController extends Controller
{
    public function getAllPaginateForUsed()
    {
        $data = SpreadingOutMaterialOrder::with('user:id,name', 'material:id,mq_r_code')->has('cuttingOrders')->paginate();
        return view('dashboard.orders.spreading_materials.used_list')->with('data', $data);
    }
    public function getAllPaginateForHold()
    {
        $data = SpreadingOutMaterialOrder::with('user:id,name', 'material:id,mq_r_code')->doesntHave('cuttingOrders')->paginate();
        // dd($data->all());
        return view('dashboard.orders.spreading_materials.hold_list')->with('data', $data);
    }

    public function counterList()
    {
        $usedOrders = SpreadingOutMaterialOrder::has('cuttingOrders')->count();
        $holdOrders = SpreadingOutMaterialOrder::doesntHave('cuttingOrders')->count();

        return view('dashboard.orders.spreading_materials.counter_list', ['hold' => $holdOrders, 'used' => $usedOrders]);
    }

    public function createPage()
    {
        $data = [];
        //$data['users'] = User::select('id', 'name')->get();
        $data['users'] = User::select('id', 'name')->whereHas('roles', function ($q) {
            $q->whereHas('permissions', function ($query) {
                $query->where('name', 'spreading-material');
            });
        })->get();

        $data['material'] = Material::select('id', 'mq_r_code')->where('weight', '!=', null)->get();
        $data['factories'] = Factory::select('id' , 'name')->get();
        return view('dashboard.orders.spreading_materials.create')->with('data', $data);
    }

    public function store(Request $request)
    {
        //return $request;
        $request->validate([
            'type'        => 'required|in:employee,factory',
            'material_id' => 'required|exists:materials,id',
            'user_id'     => 'required_if:type,employee|exists:users,id',
            'factory_id'  => 'required_if:type,factory|exists:factories,id',
            'vestments'   => 'required|array',
            'vestments.*' => 'exists:vestments,id',
            //'weight'      => 'required|numeric|gt:0'
        ]);


        $request->merge(['weight' => 0]);

        if($request->type == 'employee')
        {
            $order = SpreadingOutMaterialOrder::create($request->except(['factory_id']));
        }

        else 
        {
            $order = SpreadingOutMaterialOrder::create($request->except(['user_id']));
        }
        
        $sum_weights = 0;
        foreach($request->vestments as $vestment_id)
        {
            
            $vestment = Vestment::find($vestment_id);
            $sum_weights += $vestment->weight;

            $vestment->status = 'done';
            $vestment->spreading_out_material_order_id = $order->id;
            $vestment->save();
        }

        $request->merge(['weight' => $sum_weights]);

        
        if ($order) {
            $material = Material::where('id', $request->material_id)->first();
            // $material->weight = $material->weight - $request->weight;
            // $material->save();
        }
        return redirect()->route('spreading.material.hold_list')->with('success' , __('words.added_successfully'));
    }

    public function editPage($spreading_id)
    {
        $data = [];
        //$data['users'] = User::select('id', 'name')->get();
        $data['users'] = User::select('id', 'name')->whereHas('roles', function ($q) {
            $q->whereHas('permissions', function ($query) {
                $query->where('name', 'spreading-material');
            });
        })->get();
        
        $data['material'] = Material::select('id', 'mq_r_code')->where('weight', '!=', null)->get();
        $data['spreading'] = SpreadingOutMaterialOrder::where('id', $spreading_id)
            ->with('user:id,name', 'material:id,mq_r_code')
            ->first();

        $data['factories'] = Factory::select('id' , 'name')->get();
        return view('dashboard.orders.spreading_materials.edit')->with('data', $data);
    }

    public function update(Request $request)
    {

        $request->validate([
            'spreading_id' => 'exists:spreading_out_material_orders,id',
            'material_id' => 'exists:materials,id',
            'user_id'     => 'exists:users,id',
            'vestments'   => 'required|array',
            'vestments.*' => 'exists:vestments,id',
            //'weight' => 'required|numeric|gt:0,'
        ]);

        $order = SpreadingOutMaterialOrder::where('id', $request->spreading_id)->first();

        $order->vestments()->update(['status' => 'pending' , 'spreading_out_material_order_id' => null]);
        $sum_weights = 0;
        foreach($request->vestments as $vestment_id)
        {
            $vestment = Vestment::find($vestment_id);
            $sum_weights += $vestment->weight;

            $vestment->status = 'done';
            $vestment->spreading_out_material_order_id = $order->id;
            $vestment->save();
        }

        $request->merge(['weight' => $sum_weights]);
        $order->update($request->all());
        return redirect()->route('spreading.material.hold_list')->with('success' , __('words.added_successfully'));
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
        return back();
    }

    public function getAll()
    {
        return response()->json(SpreadingOutMaterialOrder::with('spreadinguser')->select('id' , 'user_id' , 'created_at')->whereDoesntHave('cuttingOrders')->get(), 200);
    }

    public function checkVestment(Request $request)
    {
        if($request->filled('vestment_barcode'))
        {
            if($request->filled('spreading_out_order_id'))
            {
                $vestment = Vestment::where('barcode' , $request->vestment_barcode)
                                    ->where('material_id' , $request->material_id)
                                    ->where(function($query) use($request){
                                        $query->where('spreading_out_material_order_id' , $request->spreading_out_order_id)
                                                ->orWhere('status' , 'pending');
                                    })
                                    ->first();
            }
            else 
            {
                $vestment = Vestment::where('barcode' , $request->vestment_barcode)
                                    ->where('status' , 'pending')
                                    ->where('material_id' , $request->material_id)
                                    ->first();
            }
          
            if($vestment)
            {

                return response()->json($vestment , 200);
            }

            else 
            {
                return response()->json('error' , 200);
            }
        }

        else 
        {
            return response()->json('error' , 200);
        }
    }

    public function getVestments(Request $request)
    {
        if($request->filled('spreading_out_order_id'))
        {
            $order = SpreadingOutMaterialOrder::find($request->spreading_out_order_id);
            if($order)
            {
                return response()->json($order->vestments , 200);
            }
            else 
            {
                return response()->json('error' , 200);
            }
        }

        else 
        {
            return response()->json('error' , 200);
        }
    }
}
