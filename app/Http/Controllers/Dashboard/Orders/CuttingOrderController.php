<?php

namespace App\Http\Controllers\Dashboard\Orders;

use Illuminate\Http\Request;
use App\User;
use App\Models\Options\Size;
use App\Models\Orders\CuttingOrder;
use App\Models\Products\ProductType;
use App\Http\Controllers\Controller;
use App\Models\Orders\SpreadingOutMaterialOrder;

class CuttingOrderController extends Controller
{
    public function getAllPaginate()
    {
        $data = CuttingOrder::with(
            'user:id,name',
            'productType:id,name',
            'size:id,name',
            'spreadingOutMaterialOrder:id,spreading_code'
            )->paginate();
            
        return view('dashboard.orders.cutting_order.list')->with('data', $data);
    }

    public function createPage()
    {
        $data = [];
        $data['users'] = User::select('id', 'name')->get();
        $data['productTypes'] = ProductType::select('id', 'name')->get();
        $data['sizes'] = Size::select('id', 'name')->get();
        $data['spreading_codes'] = SpreadingOutMaterialOrder::select('id', 'spreading_code')->get();

        return view('dashboard.orders.cutting_order.create')->with('data', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_type_id'                 => 'required|exists:product_types,id',
            'user_id'                         => 'required|exists:users,id',
            'spreading_out_material_order_id' => 'required|exists:spreading_out_material_orders,id',
            'size_id'                         => 'required|exists:sizes,id',
            'layers'                          => 'required|min:3',
            'qty'                             => 'required',
            'extra_returns_weight'            => 'required'
        ]);

        CuttingOrder::create($request->all());
        return redirect()->route('cutting.material.list');
    }

    public function editPage($cutting_order_id)
    {
        $data = [];
        $data['users'] = User::select('id', 'name')->get();
        $data['productTypes'] = ProductType::select('id', 'name')->get();
        $data['sizes'] = Size::select('id', 'name')->get();
        $data['spreading_codes'] = SpreadingOutMaterialOrder::select('id', 'spreading_code')->get();

        $data['records'] = CuttingOrder::where('id', $cutting_order_id)->first();

        return view('dashboard.orders.cutting_order.edit')->with('data', $data);
    }

    public function update(Request $request)
    {
        $request->validate([
            'cutting_order_id'                => 'required|exists:cutting_orders,id',
            'product_type_id'                 => 'exists:product_types,id',
            'user_id'                         => 'exists:users,id',
            'spreading_out_material_order_id' => 'exists:spreading_out_material_orders,id',
            'size_id'                         => 'exists:sizes,id',
            'layers'                          => 'min:3',
        ]);
        
        CuttingOrder::find($request->cutting_order_id)->update($request->all());
        return redirect()->route('cutting.material.list');
    }


    public function delete(Request $request)
    {
        $request->validate([
            'cutting_order_id' => 'required|exists:cutting_orders,id',
        ]);
        
        CuttingOrder::find($request->cutting_order_id)->delete();
        return redirect()->route('cutting.material.list');
    }
}