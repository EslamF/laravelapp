<?php

namespace App\Http\Controllers\Dashboard\Products;

use App\Http\Controllers\Controller;
use App\Models\Materials\Material;
use App\Models\Options\Size;
use Illuminate\Http\Request;
use App\Models\Products\Product;
use App\Models\Orders\ReceivingOrder;
use App\Models\Orders\SaveOrder;
use App\Models\Products\ProductType;
use App\Policies\ProductPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{

    public function getAllPaginate()
    {
        $products = Product::with('productType' , 'size')->paginate();
        return view('dashboard.products.product.list')->with('products', $products);
    }

    public function createPage()
    {
        $product_types = ProductType::get();
        $sizes = Size::get();
        $materials = Material::where('weight', '!=', null)->get();
        return view('dashboard.products.product.create', ['product_types' => $product_types, 'sizes' => $sizes, 'materials' => $materials]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_type_id' => 'required|exists:product_types,id',
            'size_id'   => 'required|exists:sizes,id',
            'material_id' => 'required|exists:materials,id',
            'qty'   => 'required',
            'description'        => 'nullable|min:3'
        ]);

        $product = Product::where('product_type_id', $request->product_type_id)
            ->where('size_id', $request->size_id)
            ->where('material_id', $request->material_id)
            ->first();

        $product_material_code = Product::where('product_type_id' , $request->product_type_id)
                                        ->where('material_id' , $request->material_id)
                                        ->first();
        $save_order = SaveOrder::create([
            'code' => $this->generateOrderCode(),
            'stored' => 1
        ]);

        for ($i = 0; $i < $request->qty; $i++) {
            Product::create([
                'prod_code' => $this->generateCode(),
                'produce_code' => $product->produce_code ?? $this->generateOrderCode(),
                'sorted'     => 1,
                'size_id'   => $request->size_id,
                'material_id'   => $request->material_id,
                'product_type_id' => $request->product_type_id,
                'received'  => 1,
                'status'    => 'available',
                'save_order_id' => $save_order->id,
                'product_material_code' => $product_material_code->product_material_code ?? $this->generateProductMaterialCode()

            ]);
        }
        return redirect()->route('product.list')->with('success' , __('words.added_successfully') );;
    }

    public function editPage($product_id)
    {
        $product = Product::where('id', $product_id)
            ->with('material', 'productType', 'size')
            ->first();

        $materials = Material::get();
        $productTypes = ProductType::get();
        $sizes = Size::get();
        return view(
            'dashboard.products.product.edit',
            [
                'product' => $product,
                'materials' => $materials,
                'product_types' => $productTypes,
                'sizes' => $sizes
            ]
        );
    }


    public function update(Request $request)
    {
        
        $request->validate([
            'product_id'            => 'required|exists:products,id',
            'prod_code'             => 'required|unique:products,prod_code,' . $request->product_id,
            'product_material_code' => 'required|unique:products,product_material_code,' . $request->product_material_code,

            'product_type_id' => 'required|exists:product_types,id',
            'size_id'   => 'required|exists:sizes,id',
            'material_id' => 'required|exists:materials,id',
            'description'        => 'nullable|min:3'

        ]);

        Product::find($request->product_id)->update($request->all());
        return redirect()->route('product.list')->with('success' , __('words.updated_successfully') );;
    }

    public function delete(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);

        Product::find($request->product_id)->delete();
        return redirect()->route('product.list');
    }

    public function generateOrderCode()
    {
        $code = rand(0, 6000000000000);
        $check = Product::where('produce_code', $code)->exists();
        if ($check) {
            $this->generateOrderCode();
        } else {
            return $code;
        }
    }

    public function generateCode()
    {
        $code = rand(0, 6000000000000);
        $check = Product::where('prod_code', $code)->exists();
        if ($check) {
            $this->generateCode();
        } else {
            return $code;
        }
    }

    public function generateProductMaterialCode()
    {
        $code = rand(0, 6000000000000);
        $check = Product::where('product_material_code', $code)->exists();
        if ($check) {
            $this->generateProductMaterialCode();
        } else {
            return $code;
        }
    }
}
