<?php

namespace App\Http\Controllers\Dashboard\Orders;

use Illuminate\Http\Request;
use App\Models\Orders\ProduceOrder;
use App\Models\Orders\CuttingOrder;
use App\Http\Controllers\Controller;
use App\Models\Orders\ReceivingOrder;
use App\Models\Orders\SpreadingOutMaterialOrder;
use App\Models\Products\Product;

class OrdersController extends Controller
{

    /**
     * 
     * create spreading out order
     * 
     */
    public function spreadingOrderCreate(Request $request)
    {
        $validate = $request->validate([
            'user_id' => 'required|exists:users,id',
            'material_id' => 'required|exists:materials,id',
            'weight' => 'required'
        ]);

        SpreadingOutMaterialOrder::create($request->all());
    }
    /**
     * 
     * create cutting order
     * 
     * 
     */
    public function cuttingOrderCreate(Request $request)
    {
        $validate = $request->validate([
            'spreading_out_material_order_id' => 'required|exists:spreading_out_material_orders,id',
            'user_id'                         => 'required|exists:users,id',
            'sizer_id'                        => 'required|exists:sizes,id',
            'product_type_id'                 => 'required|exists:product_types,id',
            'layers'                          => 'required',
            'extra_returns_weight'            => 'required',
        ]);

        CuttingOrder::create($request->all());
    }
    /**
     * 
     * send product for production order
     * 
     */
    public function produceOrder(Request $request)
    {
        $validate = $request->validate([
            'cutting_order_id' => 'required|exists:cutting_orders,id',
            'material_id'      => 'required|exists:materials,id',
            'qty'              => 'required',
            'receiving_date'   => 'required|date'
        ]);

        ProduceOrder::create($request->all());
    }
    /**
     * 
     * receiving product from production
     * 
     */
    public function receivingOrderCreate(Request $request)
    {
        $validate = $request->validate([
            'produce_order_id' => 'required|exists:produce_orders,id',
            'product_type_id'  => 'required|exists:product_types,id',
            'qty'              => 'required',
            'status'           => 'required|in:0,1',
            'size_id'          => 'required|exists:sizes,id'
        ]);

        ReceivingOrder::create($request->all());

    }
    /**
     * 
     * create product after receiving
     * 
     */
    public function createProducts(Request $request)
    {
        $validate = $request->validate([
            'receiving_order_id' => 'required|exists:receiving_orders,id',
            'prod_code'          => 'required',
            'damaged'            => 'in:0,1',
            'description'        => 'min:3',
        ]);

        Product::create($request->all());
    }
}