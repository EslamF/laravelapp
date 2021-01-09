<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Products\Product;
use App\Http\Controllers\Dashboard\Alarms\ProductsAlarmController;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\Products2Import;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    
    public function index()
    {
        return view('home');
    }

    public function home()
    {
        //return Excel::import(new Products2Import, public_path('products2.xlsx'));
        $object = new ProductsAlarmController();
        
        $about_to_run_products_count = count($object->get_about_to_run_products());
        $low_sale_products_count     = count($object->get_low_sale_products());
        $best_selling_products_count = count($object->get_best_selling_products());

        return view('main_page' , compact('about_to_run_products_count' , 'low_sale_products_count' , 'best_selling_products_count'));
    }
}
