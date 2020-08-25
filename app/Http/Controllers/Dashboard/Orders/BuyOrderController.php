<?php

namespace App\Http\Controllers\Dashboard\Orders;

use App\Http\Controllers\Controller;
use App\Models\Materials\Material;
use App\Models\Orders\CuttingOrderProduct;
use Illuminate\Http\Request;

class BuyOrderController extends Controller
{
    public function createPage()
    {
        return view('dashboard.orders.buy_order.create');
    }

    public function getAllPaginate()
    {
        return view('dashboard.orders.buy_order.list');
    }

    public function cuttingOrdersByMaterial($mq_r_code)
    {
        $material = Material::with('cuttingOrders')->where('mq_r_code', $mq_r_code)->first();
        $orders = $material->cuttingOrders->pluck('id');
        $data = [];
        foreach ($orders as $order_id) {
            $data[] = CuttingOrderProduct::where('cutting_order_id', $order_id)->with('productType', 'size')->withCount(
                ['products' => function ($q) {
                    $q->where('status', 'available');
                }]
            )->get();
        }
        $products = [];
        collect($data)->map(function ($value)  use (&$products) {
            foreach ($value as $item) {
                $products[$item->id]['product'] = $item->productType->name;
                $products[$item->id]['size'] = $item->size->name;
                $products[$item->id]['count'] = $item->products_count;
            }
        });
        return response()->json($products, 200);
    }
}
