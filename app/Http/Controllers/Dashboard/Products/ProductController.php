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
use Illuminate\Support\Facades\Storage;
use Milon\Barcode\DNS1D;
use App\Models\Organization\Factory;
use App\Models\Orders\BuyOrder;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\Products2Import;
use DateTime;
use App\User;
use App\Models\Organization\Supplier;
use App\Exports\ProductsExport;

ini_set('memory_limit', '1024M');

class ProductController extends Controller
{

    public function getAllPaginate()
    {
        $products = Product::where(function($query){

            if(request()->filled('size_id'))
            {
                $query->where('size_id' , request()->size_id);
            }

            if(request()->filled('material_code'))
            {
                $materials = Material::where('mq_r_code' , 'like' , '%' . request()->material_code . '%')->get()->pluck('id')->toArray();
               
                $query->whereIn('material_id' , $materials);
            }

            if(request()->filled('product_type'))
            {
                $product_types = ProductType::where('name' , 'like' , '%' . request()->product_type . '%')->get()->pluck('id')->toArray();

                $query->whereIn('product_type_id' , $product_types);
            }

            if(request()->filled('factory_id'))
            {
                $query->where('factory_id' , request()->factory_id);
            }

            if(request()->filled('available_in_company'))
            {
                if(request()->available_in_company == 'available')
                {
                    $query->where('save_order_id' , '!=' , null );
                }
                else 
                {
                    $query->where('save_order_id' , null );
                }
            }

            
        })->with('productType' , 'size')->paginate();
        return view('dashboard.products.product.list')->with('products', $products);
    }

    public function createPage()
    {
        $product_types = ProductType::get();
        $sizes = Size::get();
        $factories = Factory::get();
        $materials = Material::where('weight', '!=', null)->get();
        return view('dashboard.products.product.create', ['product_types' => $product_types, 'sizes' => $sizes, 'materials' => $materials, 'factories' => $factories]);
    }

    public function store(Request $request)
    {
        //return $request;
        $request->validate([
            'product_type_id' => 'required|exists:product_types,id',
            'size_id'   => 'required|exists:sizes,id',
            //'material_id' => 'required|exists:materials,id',
            'material_code' => 'required',
            'qty'   => 'required',
            'description'        => 'nullable|min:3',
            'factory_id'    => 'nullable|exists:factories,id'
        ]);

        $material = Material::where('mq_r_code' , $request->material_code)->first();
        if(!$material)
        {
            $material = Material::create([
                'mq_r_code' => $request->material_code,
                'buyer_id'  => User::first()->id,
                'supplier_id' => Supplier::first()->id,
                'bill_number' => '00000',
            ]);
        }

        $request->merge([
            'material_id' => $material->id
        ]);



        $product = Product::where('product_type_id', $request->product_type_id)
            ->where('size_id', $request->size_id)
            ->where('material_id', $request->material_id)
            ->first();
        $produce_code = $product->produce_code ?? generate_product_produce_code();


        $product_material_code = Product::where('product_type_id' , $request->product_type_id)
                                        ->where('material_id' , $request->material_id)
                                        ->first();
        $material_code = $product_material_code->product_material_code ?? generate_product_material_code();
        

        $save_order = SaveOrder::create([
            'code' => generate_save_order_code(),
            'stored' => 1
        ]);


        //check if available_in_company , then update the products
        $not_available_products = [];
        $num_of_products_will_insert = 0;
        if($request->has('available_in_company') && $request->available_in_company )
        {
            //number of reserved products
            $num_of_products_will_insert = Product::where('product_type_id' , $request->product_type_id)
                                                    ->where('material_id' , $request->material_id)
                                                    ->where('size_id', $request->size_id)
                                                    ->whereNull('save_order_id')
                                                    ->count(); // 40
            //select the products that has the same info and update the save order id such that the products be available
            
            $not_available_products = Product::where('product_type_id' , $request->product_type_id)
                                                ->where('material_id' , $request->material_id)
                                                ->where('size_id', $request->size_id)
                                                ->whereNull('save_order_id')
                                                ->take($request->qty) //10
                                                ->update(['save_order_id' => $save_order->id ]);
        }

        $num_of_products_will_insert = $request->qty - $num_of_products_will_insert ; //50 -10 =40 
    
        $all_inserted_products = [];
        $all_generated_codes = [];
        $dns1d = new DNS1D();
        for ($i = 0; $i < $num_of_products_will_insert; $i++) 
        {
            $code = generate_product_code_not_in_array($all_generated_codes);
        
            array_push($all_inserted_products , [

                    'prod_code' => $code,
                    'produce_code' => $produce_code,
                    'sorted'     => 1,
                    'size_id'   => $request->size_id,
                    'material_id'   => $request->material_id,
                    'product_type_id' => $request->product_type_id,
                    'received'  => 1,
                    'status'    => 'available',
                    'save_order_id' => $save_order->id ,
                    'product_material_code' => $material_code ,
                    'factory_id'    => $request->factory_id,
                    'description' => $request->description
            ]);

            array_push($all_generated_codes , $code );

            //DNS1D::getBarcodePNG('4', 'C39+')
            
            Storage::disk('barcodes')->put($code . '.png', base64_decode($dns1d->getBarcodePNG($code, "C39", 1 , 50 , array(0 , 0 , 0) , true)));

        }

        Product::insert($all_inserted_products);

        $products = Product::select('id' , 'prod_code' , 'size_id' , 'material_id' , 'product_type_id')
                            ->with('size', 'material', 'productType')
                            ->where('save_order_id' , $save_order->id)
                            ->get();
        
        if(!$request->has('available_in_company'))
        {
            Product::where('save_order_id' , $save_order->id)->update(['save_order_id' => null]);
            //$products_will_updated->update(['save_order_id' => null]);
        }
        else if($request->has('available_in_company') && $request->available_in_company  )
        {
            $obj = new \App\Http\Controllers\Dashboard\Orders\StoreProductOrderController();
            $obj->addQtyToOrders($save_order->id);
        }


        if(request()->has('print'))
        {
            return view('dashboard.products.product.print' , compact('products'));
        }
        else 
        {
            return redirect()->route('product.list')->with('success' , __('words.added_successfully') );
        }
        
    }

    public function editPage($product_id)
    {
        $product = Product::where('id', $product_id)
            ->with('material', 'productType', 'size', 'factory')
            ->first();

        $materials = Material::get();
        $productTypes = ProductType::get();
        $sizes = Size::get();
        $factories = Factory::get();
        return view(
            'dashboard.products.product.edit',
            [
                'product' => $product,
                'materials' => $materials,
                'product_types' => $productTypes,
                'sizes' => $sizes,
                'factories' => $factories
            ]
        );
    }


    public function update(Request $request)
    {
        //return $request->product_material_code;
        $request->validate([
            'product_id'            => 'required|exists:products,id',
            'prod_code'             => 'required|unique:products,prod_code,' . $request->product_id,
            //'product_material_code' => 'required|unique:products,product_material_code,' . $request->product_material_code,

            'product_type_id' => 'required|exists:product_types,id',
            'size_id'   => 'required|exists:sizes,id',
            //'material_id' => 'required|exists:materials,id',
            'material_code' => 'required',
            'description'        => 'nullable|min:3',
            'factory_id'    => 'nullable|exists:factories,id',

        ]);


        $material = Material::where('mq_r_code' , $request->material_code)->first();
        if(!$material)
        {
            $material = Material::create([
                'mq_r_code' => $request->material_code,
                'buyer_id'  => User::first()->id,
                'supplier_id' => Supplier::first()->id,
                'bill_number' => '00000',
            ]);
        }

        $request->merge([
            'material_id' => $material->id
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

    public function print($id)
    {
        $ids = [];
        array_push($ids , $id);
        $products = Product::whereIn('id' , $ids)->select('id' , 'prod_code' , 'size_id' , 'material_id' , 'product_type_id')->with('size', 'material', 'productType')->get();
        //return view('dashboard.products.product.print' , compact('products'));
        return view('dashboard.products.product.print' , compact('products'));
    }

    public function print_material_barcode($id)
    {
        /*$ids = [];
        array_push($ids , $id);
        $products = Product::whereIn('id' , $ids)->select('id' , 'prod_code' , 'size_id' , 'material_id' , 'product_type_id')->with('size', 'material', 'productType')->get();
        return view('dashboard.products.product.print_material_barcode' , compact('products'));*/
        $product = Product::findOrFail($id);
        $material = $product->material;
        return view('dashboard.orders.receiving_materials.print' , compact('material'));
    }

    public function delete_all_products()
    {
        Product::query()->delete();
        BuyOrder::query()->delete();
        return redirect()->route('product.list')->with('success' , 'تم حذف جميع المنتجات');
    }

    public function import_sheet_excel_view()
    {
        return view('dashboard.products.product.import_sheet');
    }

    public function import_sheet_excel(Request $request)
    {
        $rules = [
            'file' => 'required|file' //|mimes:csv,xlsx,xls
        ];

        $file = $request->file;
        $extension =  $file->getClientOriginalExtension();
        $available_extensions = ['csv','xlsx','xls']; 
        if(! in_array($extension , $available_extensions ) )
        {
            return back()->with('error' , 'يجب أن يكون الملف csv أو xlsx أو xls');
        }

        $request->validate($rules);

        Excel::import(new Products2Import, $request->file);

        return redirect()->route('product.list')->with('success' , __('words.added_successfully') );
    }

    public function print_products($ids)
    {
        //return $ids;
        $ids = json_decode($ids , true);
        //$ids = $ids[0];
        //return $ids[0];
        $products = Product::select('id' , 'prod_code' , 'size_id' , 'material_id' , 'product_type_id')->with('size', 'material', 'productType')->whereIn('id' , $ids)->get();
        //return $products;
       
        return view('dashboard.products.product.print' , compact('products'));
    }

    public function print_receiving_order_products($id)
    {
        $products = Product::select('id' , 'prod_code' , 'size_id' , 'material_id' , 'product_type_id')
                            ->with('size', 'material', 'productType')
                            ->where('receiving_order_id' , $id)
                            ->get();
    
       
        return view('dashboard.products.product.print' , compact('products'));
    }

    public function export()
    {
        $export = new ProductsExport();
        return Excel::download($export, 'products.xlsx');
    }

    
}
