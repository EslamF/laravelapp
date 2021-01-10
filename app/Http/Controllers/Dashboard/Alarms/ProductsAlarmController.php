<?php

namespace App\Http\Controllers\Dashboard\Alarms;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Products\Product;
use App\Models\Orders\BuyOrderProduct;
use App\Models\Orders\BuyOrder;
use Illuminate\Database\Eloquent\Builder;


class ProductsAlarmController extends Controller
{

    public function about_to_run_products()
    {
        $about_to_run_products = $this->get_about_to_run_products();
        //return $about_to_run_products;
        return view('dashboard.alarms.about_to_run_products' , compact('about_to_run_products'));
    }

    public function low_sale_products()
    {
        $low_sale_products = $this->get_low_sale_products();
        return view('dashboard.alarms.low_sale_products' , compact('low_sale_products'));
    }

    public function best_selling_products()
    {
        $best_selling_products = $this->get_best_selling_products();
        //return $best_selling_products;
        return view('dashboard.alarms.best_selling_products' , compact('best_selling_products'));
    }


    public function get_about_to_run_products()
    {
        $products = Product::where('status' , 'available')
                            ->with('material' , 'material.materialType' , 'productType')
                            ->get()
                            ->groupBy('product_material_code');
        
        //return $products;
        $about_to_run_products = $products->map(function ($product , $key) use($products) {

            if(count($product) <= 5)
            {
                return $product;
            }
            else 
            {
                $products->forget($key);
            }

        });

        $about_to_run_products = $products;
        return $about_to_run_products;
    }

    public function get_low_sale_products()
    {
        $products = Product::with('material' , 'material.materialType' , 'productType')
                            ->get()
                            ->groupBy('product_material_code');

        $NewDate = date('Y-m-d', strtotime('-30 days'));

        $low_sale_products = $products->map(function ($product , $key) use($products , $NewDate) {

            $records = BuyOrderProduct::where('product_material_code' , $key)
                            ->where('created_at' , '>=' , $NewDate )
                            ->get();

            if(count($records) > 0)
            {
                $order = BuyOrder::whereIn('id' , $records->pluck('buy_order_id')->toArray() )
                                    ->where('status' , 'done')
                                    ->first();
                if($order)
                {
                    $products->forget($key);
                }
                else 
                {
                    return $product;
                }
            }

            else 
            {
                return $product;
            }

        });

        $low_sale_products = $products;
        return $low_sale_products;

    }


    public function get_best_selling_products()
    {
        $products = Product::where('status' , 'reserved')
                            ->with('material' , 'material.materialType' , 'productType')
                            ->get()
                            ->groupBy('product_material_code');

        $NewDate = date('Y-m-d', strtotime('-30 days'));

        $best_selling_products = $products->map(function ($product , $key) use($products , $NewDate) {

            $orders = BuyOrder::where('status' , 'done')->whereHas('buyOrderProducts' , function(Builder $query) use($key){
                                                            $query->where('product_material_code' , $key);
                                                        })->get();

            if(count($orders) > 0)
            {
                /*return [
                    'product_type' => $product->first()->productType->name , 
                    'material'     => $product->first()->material->mq_r_code , 
                    'orders_count' => count($orders)
                ];*/
                $products[$key]['orders_count'] = count($orders);
                //$product->orders_count = count($orders);
                return $product;
            }
            else 
            {
                $products->forget($key);
            }
            
        });
        return $products->sortByDesc('orders_count');
        //return $best_selling_products->sortByDesc('orders_count');
        $best_selling_products = $products;
        return $best_selling_products;
    }

}
