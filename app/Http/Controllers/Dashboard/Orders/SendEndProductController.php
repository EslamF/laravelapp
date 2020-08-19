<?php

namespace App\Http\Controllers\Dashboard\Orders;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Options\Repository;
use App\Models\Organization\ShippingCompany;

class SendEndProductController extends Controller
{
    public function getAllPaginate()
    {
        $repository = Repository::select('id', 'shipping_company_id', 'product_id')->paginate();

        return view('dashboard.orders.send_end_product.list')->with('repository', $repository);
    }

    public function create()
    {
        $shipping_companies = ShippingCompany::select('id', 'name')->get();
        return view('dashboard.orders.send_end_product.create')->with('shipping_companies', $shipping_companies);
    }

    public function store(Request $request)
    {
        $request->validate([
            'products' => 'required|array',
            'products.*.product_id' => 'required|exists:products,id',
            'shipping_company_id' => 'required|exists:shipping_companies,id'
        ]);

        $shipping_company = ShippingCompany::where('id', $request->shipping_company_id)->first();
        // $shipping_companies->products()->attach($request->products);
    }
}
