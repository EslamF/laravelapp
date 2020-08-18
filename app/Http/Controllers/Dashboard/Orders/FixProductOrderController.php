<?php

namespace App\Http\Controllers\Dashboard\Orders;

use Illuminate\Http\Request;
use App\Models\Products\Product;
use App\Models\Organization\Factory;
use App\Http\Controllers\Controller;
use App\Models\Orders\DamagedProductFixOrder;

class FixProductOrderController extends Controller
{
    public function createPage()
    {
        $factories = Factory::select('id', 'name')->get();
        return view('dashboard.orders.fix_product.create')->with('factories', $factories);
    }

    public function store(Request $request)
    {
        $request->validate([
            'prod_code' => 'required|exists:products,prod_code',
            'factory_id' => 'required|exists:factories,id'
        ]);

        $product = Product::where('prod_code', $request->prod_code)->first();
        $record =  new DamagedProductFixOrder();
        $record->product_id = $product->id;
        $record->factory_id = $request->factory_id;
        $record->save();

        return redirect()->route('fix.product.list');
    }

    public function getAllPaginate()
    {
        $data = DamagedProductFixOrder::with(['product' => function($q) {
            $q->where('damage_type' ,'!=', null);
        }], 'factory:id,name')->paginate();
        return view('dashboard.orders.fix_product.list')->with('data', $data);
    }
}
