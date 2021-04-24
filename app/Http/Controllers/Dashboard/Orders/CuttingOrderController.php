<?php

namespace App\Http\Controllers\Dashboard\Orders;

use Illuminate\Http\Request;
use App\User;
use App\Models\Options\Size;
use App\Models\Orders\CuttingOrder;
use App\Models\Products\ProductType;
use App\Http\Controllers\Controller;
use App\Models\Materials\Material;
use App\Models\Materials\Vestment;
use App\Models\Orders\CuttingOrderProduct;
use App\Models\Organization\FactoryType;
use App\Models\Products\Product;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use stdClass ;
use DateTime;
use Illuminate\Support\Facades\Log;

class CuttingOrderController extends Controller
{
    public function getAllForHold()
    {
        $data = CuttingOrder::where('user_id', '!=', null)
                            ->with('user:id,name', 'spreadingOutMaterialOrder', 'spreadingOutMaterialOrder.material', 'spreadingOutMaterialOrder.user')
                            ->orderBy('id', 'DESC')
                            ->get()
                            ->filter( function($order) {
                                        return $order->status == 'current' ;
                            }) ;
                            //->paginate();

        $paginator = new \Illuminate\Pagination\Paginator($data, 10);


        //return CuttingOrder::paginate(10);
        //return $paginator;

        /*$previous = CuttingOrder::where('user_id', '!=', null)->get()->filter( function($order) {
            return $order->status == 'previous' ;
        }) ;*/


        //$data = CuttingOrder::where('user_id', '!=', null)->doesntHave('produceOrders')->with('user:id,name', 'spreadingOutMaterialOrder', 'spreadingOutMaterialOrder.material', 'spreadingOutMaterialOrder.user')->orderBy('id', 'DESC')->paginate();

        return view('dashboard.orders.cutting_order.list')->with('data', $paginator);
    }

    public function getAllForUsed()
    {
        //$data = CuttingOrder::where('user_id', '!=', null)->has('produceOrders')->with('user:id,name', 'spreadingOutMaterialOrder', 'spreadingOutMaterialOrder.material', 'spreadingOutMaterialOrder.user')->orderBy('id', 'DESC')->paginate();

        $data = CuttingOrder::where('user_id', '!=', null)
                            ->with('user:id,name', 'spreadingOutMaterialOrder', 'spreadingOutMaterialOrder.material', 'spreadingOutMaterialOrder.user')
                            ->orderBy('id', 'DESC')
                            ->get()
                            ->filter( function($order) {
                                        return $order->status == 'previous' ;
                            }) ;
                           
        $paginator = new \Illuminate\Pagination\Paginator($data, 10);


        return view('dashboard.orders.cutting_order.list')->with('data', $paginator);
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
        $current = CuttingOrder::where('user_id', '!=', null)->get()->filter( function($order) {
            return $order->status == 'current' ;
        }) ;

        $previous = CuttingOrder::where('user_id', '!=', null)->get()->filter( function($order) {
            return $order->status == 'previous' ;
        }) ;

        return view('dashboard.orders.cutting_order.counter_inner', ['current' => $current->count(), 'previous' => $previous->count()]);
    }
    public function getAll()
    {
        $cutting_orders_ids = CuttingOrder::with('cuttinguser' , 'factory' ,'spreadingOutMaterialOrder','spreadingOutMaterialOrder.spreadinguser' , 'spreadingOutMaterialOrder.factory')->select('id' , 'user_id' , 'created_at' , 'spreading_out_material_order_id')->get()->filter( function($order) {
            return $order->status == 'current' ;

        } ) ;
        return response()->json( $cutting_orders_ids , 200);
    }

    public function createPage()
    {
        $data = [];
        //$data['users'] = User::select('id', 'name')->get();
        $data['users'] = User::select('id', 'name')->whereHas('roles', function ($q) {
            $q->whereHas('permissions', function ($query) {
                $query->where('name', 'cutting-material');
            });
        })->get();
        //return $data['users'];
        $data['productTypes'] = ProductType::select('id', 'name')->get();
        $data['sizes'] = Size::select('id', 'name')->get();

        return view('dashboard.orders.cutting_order.create')->with('data', $data);
    }

    public function getCuttingEmployees()
    {
        $users = User::select('id', 'name')->whereHas('roles', function ($q) {
            $q->whereHas('permissions', function ($query) {
                $query->where('name', 'cutting-material');
            });
        })->get();

        return response()->json($users , 200);

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
        
        
        if (request('items')) {
            $all_inserted_products = [];
            $all_generated_codes = [];

            foreach ($request->items as $item) {
                $count = ($item['qty'] * $request->layers);

                $product = Product::where('product_type_id', $item['product_type_id'])
                                    ->where('size_id', $item['size_id'])
                                    ->where('material_id', $material->id)
                                    ->first();

                $produce_code = $product->produce_code ?? generate_product_produce_code();

                $product_material_code = Product::where('product_type_id' , $item['product_type_id'])
                    ->where('material_id' , $material->id)
                    ->first();

                $material_code = $product_material_code->product_material_code ?? generate_product_material_code();
                
                while ($count > 0) {

                    $code = generate_product_code_not_in_array($all_generated_codes);
        
                    array_push($all_inserted_products , [

                            'prod_code' => $code,
                            'cutting_order_id' => $order->id,
                            'damage_type' => 'pending',
                            'material_id' => $material->id,
                            'product_type_id' => $item['product_type_id'],
                            'size_id' => $item['size_id'],
                            'produce_code' => $produce_code,
                            'product_material_code' => $material_code ,
                    ]);

                    array_push($all_generated_codes , $code );

                    /*Product::create([
                        'prod_code' => $this->generateEANCode() ?? $this->generateEANCode() ,
                        'cutting_order_id' => $order->id,
                        'damage_type' => 'pending',
                        'material_id' => $material->id,
                        'product_type_id' => $item['product_type_id'],
                        'size_id' => $item['size_id'],
                        'produce_code' => $product->produce_code ?? ($this->generateEANOrderCode() ?? $this->generateEANOrderCode()) ,
                        'product_material_code' => $product_material_code->product_material_code ?? $this->generateEANProductMaterialCode()
                    ]);*/
                    $count--;
                }
            }

            Product::insert($all_inserted_products);
            
        }

        if ($request->extra_returns_weight) 
        {
            $vestment = $material->vestments()->create([
                            'name' => 'توب إضافي',
                            'weight' => $request->extra_returns_weight ,
                            'barcode' => generate_vestment_barcode()
                        ]);
            //return $vestment;

            
            $ids = [];
            array_push($ids , $vestment->id);
    
            return response()->json($ids, 200); 

            ///return view('dashboard.orders.receiving_materials.vestment_print' , compact('vestments') );
                //return $this->print_vestments2($ids);
            //return redirect()->route('receiving.material.print_vestments2' , $ids);
        }
        else 
        {
            Session::flash('success',  __('words.added_successfully') );
            return response()->json('success', 200); 
        }


        
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
                $count = $item['qty'] * $order->layers;

                $product = Product::where('product_type_id', $item['product_type_id'])
                    ->where('size_id', $item['size_id'])
                    ->where('material_id', $material->id)
                    ->first();

                $product_material_code = Product::where('product_type_id' , $item['product_type_id'])
                    ->where('material_id' , $material->id)
                    ->first();

                while ($count > 0) {
                    Product::create([
                        'prod_code' => $this->generateEANCode(),
                        'cutting_order_id' => $order->id,
                        'damage_type' => 'pending',
                        'material_id' => $material->id,
                        'product_type_id' => $item['product_type_id'],
                        'size_id' => $item['size_id'],
                        'produce_code' => $product->produce_code ?? $this->generateEANOrderCode() ,
                        'product_material_code' => $product_material_code->product_material_code ?? $this->generateEANProductMaterialCode()
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

        $data['order'] = CuttingOrder::findOrFail($cutting_order_id);
        $products      = Product::where('cutting_order_id' , $cutting_order_id)
                                ->get()
                                ->groupBy('produce_code');

        if(! $data['order']->can_edit)
        {
            abort(404);
        }

        /*$data['items'] = [];

        foreach($products as $key => $product)
        {
            $object = new stdClass();
            $object->product_type_id = $product[0]->product_type_id ;
            $object->size_id = $product[0]->size_id ;
            $object->qty = count($product) ;

            array_push($data['items'] , $object );
        }*/
        $data['type'] = $data['order']->type == 'inner' ? 'employee' : 'company' ;
        //return $data;
        //return $data;
        //$order = CuttingOrder::where('id', $cutting_order_id)->first();

        //return view('dashboard.orders.cutting_order.edit')->with('data', $data);
        return view('dashboard.orders.cutting_order.edit' , compact('data'));
    }
    

    public function getProducts($cutting_order_id)
    {
        $order = CuttingOrder::find($cutting_order_id);
        if($order)
        {
            $products = Product::where('cutting_order_id' , $cutting_order_id)
                                ->get()
                                ->groupBy('produce_code');
            $items = [];

            foreach($products as $key => $product)
            {
                $object = new stdClass();
                $object->product_type_id = $product[0]->product_type_id ;
                $object->size_id = $product[0]->size_id ;
                $object->qty = count($product) ;
    
                array_push($items , $object );
            }

            return response()->json($items , 200);
        }

        return response()->json('error' , 200);
    }

    public function update(Request $request)
    {
        $validator = validator()->make($request->all() , [
            'cutting_order_id'                => 'required|exists:cutting_orders,id',
            'items'                           => 'required|array',
            'user_id'                         => 'exists:users,id',
            'layers'                          => '',
        ]);

        if($validator->fails())
        {
            return response()->json($validator->errors() , 200);
        }

        $cutting_order = CuttingOrder::find($request->cutting_order_id);

        if(! $cutting_order->can_edit)
        {
            abort(404);
        }

        $material = Material::whereHas('spreadingOutMaterialOrders', function ($q) use ($cutting_order) {
            $q->whereHas('cuttingOrders', function ($query) use ($cutting_order) {
                $query->where('id', $cutting_order->id);
            });
        })->first();

        //Back 
        $material->weight = $material->weight - $cutting_order->extra_returns_weight ;
        $material->save();

        //delete the old items
        $old_products = Product::where('cutting_order_id' , $cutting_order->id )->delete();

        if ($request->extra_returns_weight) 
        {
            $material->weight = $request->extra_returns_weight + $material->weight;
            $material->save();
        }

        $cutting_order->update($request->all());
        if (request('items')) 
        {
            foreach ($request->items as $item) {
                $count = ($item['qty'] * $request->layers);
                while ($count > 0) {

                    $product = Product::where('product_type_id', $item['product_type_id'])
                        ->where('size_id', $item['size_id'])
                        ->where('material_id', $material->id)
                        ->first();

                    $product_material_code = Product::where('product_type_id' , $item['product_type_id'])
                        ->where('material_id' , $material->id)
                        ->first();

                    Product::create([
                        'prod_code' => $this->generateEANCode(),
                        'cutting_order_id' => $cutting_order->id,
                        'damage_type' => 'pending',
                        'material_id' => $material->id,
                        'product_type_id' => $item['product_type_id'],
                        'size_id' => $item['size_id'],
                        'produce_code' => $product->produce_code ?? $this->generateEANOrderCode() ,
                        'product_material_code' => $product_material_code->product_material_code ?? $this->generateEANProductMaterialCode()
                    ]);
                    $count--;
                }
            }
        }

        return response()->json('success' , 200);
        
        //return redirect()->route('cutting.material.list')->with('success' , __('words.updated_successfully'));
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
        $cutting_order = CuttingOrder::where('id', $id)->with('user:id,name', 'factory:id,name' , 'spreadingOutMaterialOrder:id,user_id,material_id,weight' , 'spreadingOutMaterialOrder.material' , 'spreadingOutMaterialOrder.user')->first();
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

    public function generateEANCode()
    {
        Log::info('generate ean code');
        $date = new DateTime();
        $time = $date->getTimestamp();
        $code = '20' . str_pad($time, 10, '0');
        $weightflag = true;
        $sum = 0;
        for ($i = strlen($code) - 1; $i >= 0; $i--) {
            $sum += (int)$code[$i] * ($weightflag ? 3 : 1);
            $weightflag = !$weightflag;
        }
        $code .= (10 - ($sum % 10)) % 10;
        Log::info('code ' . $code);

        $check = Product::where('prod_code', $code)->exists();
        if ($check || !$code) {
            $this->generateEANCode();
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

    public function generateEANOrderCode()
    {
        $date = new DateTime();
        $time = $date->getTimestamp();
        $code = '20' . str_pad($time, 10, '0');
        $weightflag = true;
        $sum = 0;
        for ($i = strlen($code) - 1; $i >= 0; $i--) {
            $sum += (int)$code[$i] * ($weightflag ? 3 : 1);
            $weightflag = !$weightflag;
        }
        $code .= (10 - ($sum % 10)) % 10;

        $check = Product::where('produce_code', $code)->exists();
        if ($check) {
            $this->generateEANOrderCode();
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

    public function generateEANProductMaterialCode()
    {
        $date = new DateTime();
        $time = $date->getTimestamp();
        $code = '20' . str_pad($time, 10, '0');
        $weightflag = true;
        $sum = 0;
        for ($i = strlen($code) - 1; $i >= 0; $i--) {
            $sum += (int)$code[$i] * ($weightflag ? 3 : 1);
            $weightflag = !$weightflag;
        }
        $code .= (10 - ($sum % 10)) % 10;

        $check = Product::where('product_material_code', $code)->exists();
        if ($check) {
            $this->generateEANProductMaterialCode();
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

                $product_material_code = Product::where('product_type_id' , $product['type'])
                    ->where('material_id' , $material->id)
                    ->first();

                Product::create([
                    'prod_code' => $this->generateEANCode(),
                    'cutting_order_id' => $request->cutting_order_id,
                    'damage_type' => 'pending',
                    'material_id' => $material->id,
                    'product_type_id' => $product['type'],
                    'size_id' => $product['size'],
                    'produce_code' => $item->produce_code ?? $this->generateEANOrderCode() , 
                    'product_material_code' => $product_material_code->product_material_code ?? $this->generateEANProductMaterialCode()
                ]);
                $count--;
            }
        }
        return response()->json('updated', 200);
    }

}
