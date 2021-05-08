<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Models\Materials\Material;
use App\Models\Orders\SpreadingOutMaterialOrder;
use App\Models\Organization\Factory;
use App\Models\Materials\Vestment;

class SpreadingMaterialController extends Controller
{

    public function index(Request $request)
    {
        $orders = SpreadingOutMaterialOrder::with('user:id,name', 'material:id,mq_r_code')->doesntHave('cuttingOrders')->paginate();
    
        return responseJson(1 , 'success' , $orders);
    }

    public function show(Request $request)
    {
        $rules = [
            'order_id'    => 'required|exists:spreading_out_material_orders,id',
        ]; 

        $validator = validator()->make($request->all() , $rules );
        if($validator->fails())
        {
            return responseJson(0 , $validator->errors()->first() , $validator->errors());
        }

        $order = SpreadingOutMaterialOrder::with('vestments')->where('id', $request->order_id)->first();
    
        return responseJson(1 , 'success' , $order);
    }

    public function store(Request $request)
    {
        $rules = [
            'type'        => 'required|in:employee,factory',
            //'material_id' => 'required|exists:materials,id',
            'user_id'     => 'required_if:type,employee|exists:users,id',
            'factory_id'  => 'required_if:type,factory|exists:factories,id',
            'vestments'   => 'required|array',
            'vestments.*' => 'exists:vestments,barcode',
        ]; 

        $validator = validator()->make($request->all() , $rules );
        if($validator->fails())
        {
            return responseJson(0 , $validator->errors()->first() , $validator->errors());
        }
        //check if all vestments status is pending and belong to the same material
        $counter = 0;
        $material = null;
        foreach($request->vestments as $vestment_barcode)
        {
            $vestment = Vestment::where('barcode' , $vestment_barcode)->first();
          
            if($vestment->status != 'pending')
            {
                return responseJson(0 , "لا يمكن إضافة التوب : $vestment_barcode");
            }

            

            if($counter == 0)
            {
                $material = Material::where('id' , $vestment->material_id)->first();
            }
            else if(!$material || $material->id != $vestment->material_id)
            {
                return responseJson(0 , "التوب $vestment_barcode غير تابع لإذن الإستلام");
            }

            $counter++;
        }
      
        $request->merge(['weight' => 0 , 'material_id' => $material->id]);

        if($request->type == 'employee')
        {
            $order = SpreadingOutMaterialOrder::create($request->except(['factory_id']));
        }

        else 
        {
            $order = SpreadingOutMaterialOrder::create($request->except(['user_id']));
        }
        
        $sum_weights = 0;
        foreach($request->vestments as $vestment_barcode)
        {
            $vestment = Vestment::where('barcode' , $vestment_barcode)->first();
            $sum_weights += $vestment->weight;

            $vestment->status = 'done';
            $vestment->spreading_out_material_order_id = $order->id;
            $vestment->save();
        }

        $order->weight = $sum_weights;
        $order->save();

        return responseJson(1 , 'success' , $order);
       
    }



    public function update(Request $request)
    {
        $rules = [
            'order_id'    => 'required|exists:spreading_out_material_orders,id',
            'type'        => 'required|in:employee,factory',
            'user_id'     => 'required_if:type,employee|exists:users,id',
            'factory_id'  => 'required_if:type,factory|exists:factories,id',
            'vestments'   => 'required|array',
            'vestments.*' => 'exists:vestments,barcode',
        ]; 

        $validator = validator()->make($request->all() , $rules );
        if($validator->fails())
        {
            return responseJson(0 , $validator->errors()->first() , $validator->errors());
        }

        $order = SpreadingOutMaterialOrder::where('id', $request->order_id)->first();

        $old_vestments = $order->vesments;
        $order->vestments()->update(['status' => 'pending' , 'spreading_out_material_order_id' => null]);


        //check if all vestments status is pending and belong to the same material
        $counter = 0;
        $material = null;
        foreach($request->vestments as $vestment_barcode)
        {
            $vestment = Vestment::where('barcode' , $vestment_barcode)->first();
          
            if($vestment->status != 'pending')
            {
                $order->vestments()->update(['status' => 'done' , 'spreading_out_material_order_id' => $order->id]);
                return responseJson(0 , "لا يمكن إضافة التوب : $vestment_barcode");
            }

            

            if($counter == 0)
            {
                $material = Material::where('id' , $vestment->material_id)->first();
            }
            else if(!$material || $material->id != $vestment->material_id)
            {
                $order->vestments()->update(['status' => 'done' , 'spreading_out_material_order_id' => $order->id]);
                return responseJson(0 , "التوب $vestment_barcode غير تابع لإذن الإستلام");
            }

            $counter++;
        }
      
        $request->merge(['weight' => 0 , 'material_id' => $material->id]);

        if($request->type == 'employee')
        {
            $order->update($request->except(['factory_id']));
        }

        else 
        {
            $order->update($request->except(['user_id']));
        }
         
        $sum_weights = 0;
        foreach($request->vestments as $vestment_barcode)
        {
            $vestment = Vestment::where('barcode' , $vestment_barcode)->first();
            $sum_weights += $vestment->weight;

            $vestment->status = 'done';
            $vestment->spreading_out_material_order_id = $order->id;
            $vestment->save();
        }

        $order->weight = $sum_weights;
        $order->save();

        return responseJson(1 , 'success' , $order);
       
    }
}
