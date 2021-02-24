<?php

namespace App\Http\Controllers\Dashboard\Reports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Orders\BuyOrder;
use App\Models\Orders\SpreadingOutMaterialOrder;
use App\Models\Orders\CuttingOrder;
use App\Models\Orders\ProduceOrder;
use App\Models\Users\Customer;
use App\Models\Orders\ReceivingOrder;
use App\Models\Orders\SortOrder;
use App\Models\Orders\SaveOrder;
use App\Models\Orders\StoreProductOrder;
use App\Models\Materials\Material;
use App\User;
use App\Models\Organization\ShippingCompany;
use Illuminate\Database\Eloquent\Builder;

class ReportController extends Controller
{
    public function list()
    {
        $buy_orders_count = BuyOrder::count();
        $done_buy_orders_count = BuyOrder::where('status' , 'done')->count();
        $spreading_orders_count = SpreadingOutMaterialOrder::count();
        $cutting_orders_count = CuttingOrder::count();
        $customers_count = Customer::count();
        $produce_orders_count = ProduceOrder::count();
        $receiving_products_orders_count = ReceivingOrder::count();
        $sorting_orders_count = SortOrder::count();
        $save_orders_count = SaveOrder::count();
        $store_orders_count = StoreProductOrder::count();
        $receiving_materials_orders_count = Material::count();
        return view('dashboard.reports.list' , compact('buy_orders_count' , 'done_buy_orders_count' , 'spreading_orders_count' , 'cutting_orders_count' , 'customers_count' , 'produce_orders_count' , 'receiving_products_orders_count' , 'sorting_orders_count' , 'save_orders_count' , 'store_orders_count' , 'receiving_materials_orders_count'));
    }
    public function buy_orders()
    {
        $orders = BuyOrder::where(function($query){

            if(request()->filled('employee_id'))
            {
                $query->where('created_by' , request()->employee_id);
            }

            if(request()->filled('shipping_company_id'))
            {
                $query->where('shipping_company_id' , request()->shipping_company_id);
            }

            if(request()->filled('confirmation'))
            {
                $query->where('confirmation' , request()->confirmation);
            }

            if(request()->filled('from'))
            {
                $query->where('delivery_date' , '>=' , request()->from); 
            }

            if(request()->filled('to'))
            {
                $query->where('delivery_date' , '<=' , request()->to);  
            }

        })->paginate(30);
        $employees = User::get();
        $shipping_companies = ShippingCompany::get();
        return view('dashboard.reports.buy_orders' , compact('orders' , 'employees' , 'shipping_companies'));
    }

    public function sales()
    {
        $orders = BuyOrder::where('status' , 'done')->where(function($query){

            if(request()->filled('employee_id'))
            {
                $query->where('created_by' , request()->employee_id);
            }

            if(request()->filled('from'))
            {
                $query->where('created_at' , '>=' , request()->from); 
            }

            if(request()->filled('to'))
            {
                $query->where('created_at' , '<=' , request()->to);
                
            }
        })->get();

        $total = 0;
        foreach($orders as $order)
        {
            $total+= $order->orderTotal() ;
        }

        $employees = User::get();
        return view('dashboard.reports.sales' , compact('orders' , 'employees' , 'total'));
    }

    public function receiving_materials_orders()
    {
        $orders = Material::where(function($query){

            if(request()->filled('employee_id'))
            {
                $query->where('created_by' , request()->employee_id);
            }

            if(request()->filled('buyer_id'))
            {
                $query->where('buyer_id' , request()->buyer_id);
            }

            if(request()->filled('from'))
            {
                $query->where('created_at' , '>=' , request()->from); 
            }

            if(request()->filled('to'))
            {
                $query->where('created_at' , '<=' , request()->to);
                
            }
        })->paginate(25);

        $employees = User::get(); //created by

        $buy_materials_employees = User::select('id', 'name')->whereHas('roles', function ($q) {
            $q->whereHas('permissions', function ($query) {
                $query->where('name', 'buy-material');
            });
        })->get(); //buy material

        return view('dashboard.reports.receiving_materials_orders' , compact('orders' , 'employees' , 'buy_materials_employees')); 
    }

    public function spreading_orders()
    {
        $orders = SpreadingOutMaterialOrder::where(function($query){

            if(request()->filled('employee_id'))
            {
                $query->where('created_by' , request()->employee_id);
            }

            if(request()->filled('spreading_employee_id'))
            {
                $query->where('user_id' , request()->spreading_employee_id);
            }

            if(request()->filled('from'))
            {
                $query->where('created_at' , '>=' , request()->from); 
            }

            if(request()->filled('to'))
            {
                $query->where('created_at' , '<=' , request()->to);
                
            }
        })->get()->filter(function($order){

            if(request()->filled('type'))
            {
                return $order->type == request()->type ;
            }
            else 
            {
                return true;
            }

        });

        $employees = User::get(); //created by

        $spreading_employees = User::select('id', 'name')->whereHas('roles', function ($q) {
            $q->whereHas('permissions', function ($query) {
                $query->where('name', 'spreading-material');
            });
        })->get(); //spreading employees

        return view('dashboard.reports.spreading_orders' , compact('orders' , 'employees' , 'spreading_employees')); 
    }

    public function cutting_orders()
    {
        $orders = CuttingOrder::where(function($query){

            if(request()->filled('employee_id'))
            {
                $query->where('created_by' , request()->employee_id);
            }

            if(request()->filled('cutting_employee_id'))
            {
                $query->where('user_id' , request()->cutting_employee_id);
            }

            if(request()->filled('from'))
            {
                $query->where('created_at' , '>=' , request()->from); 
            }

            if(request()->filled('to'))
            {
                $query->where('created_at' , '<=' , request()->to);
                
            }

            if(request()->filled('type'))
            {
                if(request()->type == 'inner')
                {
                    $query->where('user_id' , '!=' , null);
                }

                else if(request()->type == 'outer')
                {
                    $query->where('factory_id' , '!=' , null);
                }
            }
        })->get();

        $employees = User::get(); //created by

        $cutting_employees = User::select('id', 'name')->whereHas('roles', function ($q) {
            $q->whereHas('permissions', function ($query) {
                $query->where('name', 'cutting-material');
            });
        })->get(); //cutting employees

        return view('dashboard.reports.cutting_orders' , compact('orders' , 'employees' , 'cutting_employees')); 
    }

    public function produce_orders()
    {
        $orders = ProduceOrder::where(function($query){

            if(request()->filled('employee_id'))
            {
                $query->where('created_by' , request()->employee_id);
            }

            if(request()->filled('from'))
            {
                $query->where('created_at' , '>=' , request()->from); 
            }

            if(request()->filled('to'))
            {
                $query->where('created_at' , '<=' , request()->to);
                
            }
        })->get();

        $employees = User::get(); //created by

        return view('dashboard.reports.produce_orders' , compact('orders' , 'employees')); 
    }

    public function receiving_products_orders()
    {
        $orders = ReceivingOrder::where(function($query){

            if(request()->filled('employee_id'))
            {
                $query->where('created_by' , request()->employee_id);
            }

            if(request()->filled('from'))
            {
                $query->where('created_at' , '>=' , request()->from); 
            }

            if(request()->filled('to'))
            {
                $query->where('created_at' , '<=' , request()->to);
                
            }
        })->get();

        $employees = User::get(); //created by

        return view('dashboard.reports.receiving_products_orders' , compact('orders' , 'employees')); 
    }

    public function sorting_orders()
    {
        $orders = SortOrder::where(function($query){

            if(request()->filled('employee_id'))
            {
                $query->where('created_by' , request()->employee_id);
            }

            if(request()->filled('sorting_employee_id'))
            {
                $query->whereHas('users' , function(Builder $query2){
                    $query2->where('users.id' , request()->sorting_employee_id);
                });
                //$query->where('user_id' , request()->sorting_employee_id);
            }

            if(request()->filled('from'))
            {
                $query->where('created_at' , '>=' , request()->from); 
            }

            if(request()->filled('to'))
            {
                $query->where('created_at' , '<=' , request()->to);
                
            }
        })->get();

        $employees = User::get(); //created by

        /*$spreading_employees = User::select('id', 'name')->whereHas('roles', function ($q) {
            $q->whereHas('permissions', function ($query) {
                $query->where('name', 'spreading-material');
            });
        })->get(); //spreading employees*/
        $sorting_employees = User::get();

        return view('dashboard.reports.sorting_orders' , compact('orders' , 'employees' , 'sorting_employees')); 
    }

    public function save_orders()
    {
        $orders = SaveOrder::where(function($query){

            if(request()->filled('employee_id'))
            {
                $query->where('created_by' , request()->employee_id);
            }

            if(request()->filled('shipping_employee_id'))
            {
                $query->where('user_id' , request()->shipping_employee_id);
            }

            if(request()->filled('from'))
            {
                $query->where('created_at' , '>=' , request()->from); 
            }

            if(request()->filled('to'))
            {
                $query->where('created_at' , '<=' , request()->to);
                
            }
        })->get();

        $employees = User::get(); //created by

        /*$spreading_employees = User::select('id', 'name')->whereHas('roles', function ($q) {
            $q->whereHas('permissions', function ($query) {
                $query->where('name', 'spreading-material');
            });
        })->get(); //spreading employees*/
        $shipping_employees = User::get();

        return view('dashboard.reports.save_orders' , compact('orders' , 'employees' , 'shipping_employees')); 
    }

    public function store_orders()
    {
        $orders = StoreProductOrder::where(function($query){

            if(request()->filled('employee_id'))
            {
                $query->where('created_by' , request()->employee_id);
            }

            if(request()->filled('from'))
            {
                $query->where('created_at' , '>=' , request()->from); 
            }

            if(request()->filled('to'))
            {
                $query->where('created_at' , '<=' , request()->to);
                
            }
        })->get();

        $employees = User::get(); //created by

        return view('dashboard.reports.store_orders' , compact('orders' , 'employees')); 
    }

    public function customers()
    {
        $customers = Customer::where(function($query){

            if(request()->filled('customer'))
            {
                $query->where('name' , 'like' , '%' . request()->customer . '%')
                        ->orWhere('phone' , 'like' , '%' . request()->customer . '%');
            }
        })->paginate(25);

        return view('dashboard.reports.customers' , compact('customers'));
    }

}
