<?php

namespace App\Http\Controllers\Dashboard\Orders;

use Illuminate\Http\Request;
use App\User;
use App\Models\Options\Size;
use App\Models\Orders\CuttingOrder;
use App\Models\Products\ProductType;
use App\Http\Controllers\Controller;
use App\Models\Materials\Material;
use App\Models\Orders\CuttingOrderProduct;
use App\Models\Organization\FactoryType;
use App\Models\Products\Product;
use Illuminate\Support\Facades\Redirect;

class CuttingOrderController extends Controller
{
    public function getAllForHold()
    {
        $data = CuttingOrder::where('user_id', '!=', null)->doesntHave('produceOrders')->with('user:id,name', 'spreadingOutMaterialOrder', 'spreadingOutMaterialOrder.material', 'spreadingOutMaterialOrder.user')->orderBy('id', 'DESC')->paginate();

        return view('dashboard.orders.cutting_order.list')->with('data', $data);
    }

    public function getAllForUsed()
    {
        $data = CuttingOrder::where('user_id', '!=', null)->has('produceOrders')->with('user:id,name', 'spreadingOutMaterialOrder', 'spreadingOutMaterialOrder.material', 'spreadingOutMaterialOrder.user')->orderBy('id', 'DESC')->paginate();

        return view('dashboard.orders.cutting_order.list')->with('data', $data);
    }

    public function companyList()
    {
        $data = CuttingOrder::where('factory_id', '!=', null)->with('factory:id,name', 'spreadingOutMaterialOrder', 'spreadingOutMaterialOrder.material', 'spreadingOutMaterialOrder.user')->orderBy('id', 'DESC')->paginate();
        return view('dashboard.orders.cutting_order.factory_list', ['data' => $data]);
    }
    // public function companyListForUsed()
    // {
    //     $data = CuttingOrder::where('factory_id', '!=', null)->with('factory:id,name', 'spreadingOutMaterialOrder', 'spreadingOutMaterialOrder.material', 'spreadingOutMaterialOrder.user')->orderBy('id', 'DESC')->paginate();
    //     return view('dashboard.orders.cutting_order.factory_list', ['data' => $data]);
    // }


    public function outerList()
    {
        $ordersInner = CuttingOrder::where('user_id', '!=', null)->count();
        $ordersOuter = CuttingOrder::where('factory_id', '!=', null)->count();

        return view('dashboard.orders.cutting_order.outer_list', ['outer' => $ordersOuter, 'inner' => $ordersInner]);
    }

    public function getAllCounterInnerList()
    {
        $hold = CuttingOrder::where('factory_id', '!=', null)->has('produceOrders')->count();
        $used = CuttingOrder::where('factory_id', '!=', null)->doesntHave('produceOrders')->count();

        return view('dashboard.orders.cutting_order.counter_inner', ['hold' => $hold, 'used' => $used]);
    }
    public function getAll()
    {
        return response()->json(CuttingOrder::select('id')->doesntHave('produceOrders')->get(), 200);
    }

    public function createPage()
    {
        $data = [];
        $data['users'] = User::select('id', 'name')->get();
        $data['productTypes'] = ProductType::select('id', 'name')->get();
        $data['sizes'] = Size::select('id', 'name')->get();

        return view('dashboard.orders.cutting_order.create')->with('data', $data);
    }

    public function store(Request $request)
    {
        //return $request ;
        //dd($request->all());
        $order = CuttingOrder::create($request->all());
        $material = Material::whereHas('spreadingOutMaterialOrders', function ($q) use ($order) {
            $q->whereHas('cuttingOrders', function ($query) use ($order) {
                $query->where('id', $order->id);
            });
        })->first();
        
        if ($request->extra_returns_weight) {
            $material->weight = $request->extra_returns_weight + $material->weight;
            $material->save();
        }
        if (request('items')) {
            foreach ($request->items as $item) {
                $count = ($item['qty'] * $request->layers) / 2;
                while ($count > 0) {

                    $product = Product::where('product_type_id', $item['product_type_id'])
                        ->where('size_id', $item['size_id'])
                        ->where('material_id', $material->id)
                        ->first();

                    Product::create([
                        'prod_code' => $this->generateCode(),
                        'cutting_order_id' => $order->id,
                        'damage_type' => 'pending',
                        'material_id' => $material->id,
                        'product_type_id' => $item['product_type_id'],
                        'size_id' => $item['size_id'],
                        'produce_code' => $product->produce_code ?? $this->generateOrderCode()
                    ]);
                    $count--;
                }
            }
        }
        return response()->json('success', 200);
    }

    public function storeExtra(Request $request)
    {
        //return $request;
        $order = CuttingOrder::where('id', $request->cutting_order_id)->first();
        $material = Material::whereHas('spreadingOutMaterialOrders', function ($q) use ($order) {
            $q->whereHas('cuttingOrders', function ($query) use ($order) {
                $query->where('id', $order->id);
            });
        })->first();
        if ($request->extra_returns_weight) {
            $material->weight = $request->extra_returns_weight + $material->weight;
            $material->save();
        }
        if ($request->has('layers')) {
            $order->layers = $request->layers;
        }
        if ($request->has('extra_returns_weight')) {
            $order->extra_returns_weight = $request->extra_returns_weight;
        }
        $order->save();

        if (request('items')) {
            foreach ($request->items as $item) {
                $count = $item['qty'] * $order->layers / 2;

                $product = Product::where('product_type_id', $item['product_type_id'])
                    ->where('size_id', $item['size_id'])
                    ->where('material_id', $material->id)
                    ->first();

                while ($count > 0) {
                    Product::create([
                        'prod_code' => $this->generateCode(),
                        'cutting_order_id' => $order->id,
                        'damage_type' => 'pending',
                        'material_id' => $material->id,
                        'product_type_id' => $item['product_type_id'],
                        'size_id' => $item['size_id'],
                        'produce_code' => $product->produce_code ?? $this->generateOrderCode()
                    ]);
                    $count--;
                }
            }
        }
        return response()->json('deleted', 200);
    }
    public function editPage($cutting_order_id)
    {
        $data = [];
        $data['users'] = User::select('id', 'name')->get();
        $data['productTypes'] = ProductType::select('id', 'name')->get();
        $data['sizes'] = Size::select('id', 'name')->get();

        $data['records'] = CuttingOrder::where('id', $cutting_order_id)->first();

        return view('dashboard.orders.cutting_order.edit')->with('data', $data);
    }

    public function update(Request $request)
    {
        $request->validate([
            'cutting_order_id'                => 'required|exists:cutting_orders,id',
            'product_type_id'                 => 'exists:product_types,id',
            'user_id'                         => 'exists:users,id',
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
        return redirect()->back();
    }

    public function getWithProduct($id)
    {
        $cutting_order = CuttingOrder::where('id', $id)->with('user:id,name', 'factory:id,name')->first();
        // dd();
        $orders = Product::where('cutting_order_id', $id)->with('productType:id,name', 'size:id,name')->get()->groupBy('produce_code');
        
        $orders = $orders->map(function ($item) {
            return [
                'id' => $item[0]->id,
                'qty' => $item->count(),
                'product_type' => $item[0]->productType->name,
                'size'         => $item[0]->size->name
            ];
        });

        //return $orders;
        
        $orders = array_values($orders->toArray());
        // return $orders;
        
        return view('dashboard.orders.cutting_order.show', ['orders' => $orders, 'cutting_order' => $cutting_order]);
    }

    public function addExtraCreate($id)
    {
        $order = CuttingOrder::where('id', $id)->select('id')->first();
        return view('dashboard.orders.cutting_order.edit', ['order' => $order]);
    }


    public function deleteProduct(Request $request)
    {
        CuttingOrderProduct::find($request->id)->delete();
        return Redirect::back();
    }

    public function getFactoryForOrder($id)
    {
        CuttingOrder::find($id)->with('factory:id,name')->first();
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

    public function generateOrderCode()
    {
        $code = rand(0, 6000000000000);
        $check = Product::where('produce_code', $code)->exists();
        if ($check) {
            $this->generateCode();
        } else {
            return $code;
        }
    }

    public function deleteProductsFromOrder(Request $request)
    {
        $ids = Product::select('id', 'cutting_order_id', 'produce_code')
            ->where('cutting_order_id', $request->cutting_order_id)
            ->where('produce_code', $request->produce_code)
            ->get()->pluck('id');

        Product::whereIn('id', $ids)->delete();
        return redirect()->route('cutting_order.show_products', $request->cutting_order_id);
    }

    public function innerOrderEdit($cutting_order_id)
    {
        $data = [];
        $data['cutting_order'] = CuttingOrder::select('id', 'spreading_out_material_order_id', 'user_id', 'layers', 'extra_returns_weight')
            ->with('user:id,name')
            ->where('id', $cutting_order_id)->first();

        $data['products'] = Product::select('id', 'produce_code', 'product_type_id', 'size_id')
            ->where('cutting_order_id', $cutting_order_id)
            ->with('productType', 'size')
            ->get()
            ->groupBy('produce_code');


        $data['products'] = $data['products']->map(function ($item, $key) use ($data) {
            return [
                'produce_code' => $key,
                'qty' => $item->count() * 2 / $data['cutting_order']->layers,
                'size' => $item[0]->size->id,
                'type' => $item[0]->product_type_id
            ];
        });
        $data['products'] = array_values($data['products']->toArray());
        return response()->json($data, 200);
    }

    // public function outerOrderEdit($cutting_order_id)
    // {
    //     $data = [];
    //     $data['cutting_order'] = CuttingOrder::select('id', 'spreading_out_material_order_id', 'factory_id', 'layers', 'extra_returns_weight')
    //         ->with('factory:id,name')
    //         ->where('id', $cutting_order_id)
    //         ->first();

    //     $data['factory_type'] = FactoryType::whereHas('factory', function ($q) use ($data) {
    //         $q->where('id', $data['cutting_order']->factory->id);
    //     })->first();

    //     $data['products'] = Product::select('id', 'produce_code', 'product_type_id', 'size_id')
    //         ->where('cutting_order_id', $cutting_order_id)
    //         ->with('productType', 'size')
    //         ->get()
    //         ->groupBy('produce_code');


    //     $data['products'] = $data['products']->map(function ($item, $key) use ($data) {
    //         return [
    //             'produce_code' => $key,
    //             'qty' => $item->count() * 2 / $data['cutting_order']->layers,
    //             'size' => $item[0]->size->id,
    //             'type' => $item[0]->product_type_id
    //         ];
    //     });
    //     $data['products'] = array_values($data['products']->toArray());
    //     return response()->json($data, 200);
    // }

    public function innerEditPage($id)
    {
        return view('dashboard.orders.cutting_order.edit_company', ['id' => $id]);
    }

    public function cuttingOrderEmployee()
    {
        $users = User::whereHas('roles', function ($q) {
            $q->whereHas('peremissions', function ($query) {
                $query->where('name', 'add-cutting');
            });
        })->get();

        return response()->json($users, 200);
    }

    public function updateCuttingOrder(Request $request)
    {
        $material = Material::whereHas('spreadingOutMaterialOrders', function ($q) use ($request) {
            $q->where('id', $request->spreading_out_material_order_id);
        })->first();
        if ($request->extra_returns_weight) {
            $material->weight = $request->extra_returns_weight + $material->weight;
            $material->save();
        }
        $ids = Product::where('cutting_order_id', $request->cutting_order_id)
            ->get()
            ->pluck('id');
        Product::whereIn('id', $ids)->delete();

        foreach ($request->products as $product) {
            $count = ($product['qty'] * $request->layers) / 2;
            while ($count > 0) {

                $item = Product::where('product_type_id', $product['type'])
                    ->where('size_id', $product['size'])
                    ->where('material_id', $material->id)
                    ->first();

                Product::create([
                    'prod_code' => $this->generateCode(),
                    'cutting_order_id' => $request->cutting_order_id,
                    'damage_type' => 'pending',
                    'material_id' => $material->id,
                    'product_type_id' => $product['type'],
                    'size_id' => $product['size'],
                    'produce_code' => $item->produce_code ?? $this->generateOrderCode()
                ]);
                $count--;
            }
        }
        return response()->json('updated', 200);
    }
}
