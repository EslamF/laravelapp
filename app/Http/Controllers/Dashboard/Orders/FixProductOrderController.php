<?php

namespace App\Http\Controllers\Dashboard\Orders;

use Illuminate\Http\Request;
use App\Models\Products\Product;
use App\Models\Organization\Factory;
use App\Http\Controllers\Controller;
use App\Models\Orders\DamagedProductFixOrder;
use Illuminate\Support\Facades\Session;

class FixProductOrderController extends Controller
{
    public function createPage()
    {
        $factories = Factory::select('id', 'name')->get();
        return view('dashboard.orders.fix_product.create')->with('factories', $factories);
    }

    /*public function store(Request $request)
    {
        $validator = validator()->make($request->all() , [

            'prod_code' => 'required|exists:products,prod_code',
            'factory_id' => 'required|exists:factories,id'
        ]);

        $product = null;

        $validator->after(function($validator) use($request){

            $product = Product::where('prod_code', $request->prod_code)
                                ->where('status', 'damaged')
                                ->where('sorted', 1)
                                ->first();
            
            if(!$product)
            {
                $validator->errors()->add('prod_code', 'كود المنتج خطأ');
            }

        });

        if($validator->fails())
        {
            return back()->withErrors($validator->errors())->withInput();
        }

        $product = Product::where('prod_code', $request->prod_code)
                                ->where('status', 'damaged')
                                ->where('sorted', 1)
                                ->first();
        

        if (isset($product)) {
            $record =  new DamagedProductFixOrder();
            $record->product_id = $product->id;
            $record->factory_id = $request->factory_id;
            $record->save();
            return redirect()->route('fix.product.list');
        }

        else 
        {
            return back()->withInput()->withErrors(['prod_code' , 'كود المنتج خطأ']);
        }
    }*/

    public function store(Request $request)
    {
        $validator = validator()->make($request->all() , [

            'products' => 'required|array',
            'products.*' => 'exists:products,prod_code' ,
            'factory_id' => 'required|exists:factories,id'
        ]);


        if($validator->fails())
        {
            return back()->withErrors($validator->errors())->withInput();
        }

        $number_of_damaged_products = 0;

        foreach($request->products as $prod_code)
        {
            $product = Product::where('prod_code', $prod_code)
                                ->where('status', 'damaged')
                                ->where('sorted', 1)
                                ->first();

            if($product)
            {
                $number_of_damaged_products++;
                $record =  new DamagedProductFixOrder();
                $record->product_id = $product->id;
                $record->factory_id = $request->factory_id;
                $record->save();
                
            }
        }

        //$number_of_damaged_products++
        Session::flash('success',  __('words.added_successfully') );
        return response()->json('success' , 200);
        //return redirect()->route('fix.product.list');

    }

    public function checkIfSortedAndDamaged(Request $request )
    {
        if($request->filled('prod_code'))
        {
            $product = Product::where('prod_code', $request->prod_code)
                            ->where('sorted', 1)
                            ->where('status', 'damaged')
                            ->first();

            $can_fix = false;

            if($product)
            {
                if(DamagedProductFixOrder::where('product_id' , $product->id)->first())
                {
                    $can_fix = false;
                }

                else
                {
                    $can_fix = true;
                }
            }

            else 
            {
                $can_fix = false;
            }
                    
            return response()->json($can_fix, 200);
        }
    }

    public function getAllPaginate()
    {
        $data = DamagedProductFixOrder::with(['product' => function ($q) {
            $q->where('damage_type', '!=', null);
        }], 'factory:id,name')->paginate();
        return view('dashboard.orders.fix_product.list')->with('data', $data);
    }


    public function delete(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:damaged_product_fix_orders,id'
        ]);

        DamagedProductFixOrder::find($request->id)->delete();
        return redirect()->route('fix.product.list');
    }
}
