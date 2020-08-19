<?php

namespace App\Http\Controllers\Dashboard\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Users\Customer;

class CustomerController extends Controller
{
    /**
     * 
     * create customer 
     * 
     * 
     */
    public function create(Request $request)
    {
        $request->validate([
            'name' => 'required|min:3',
            'phone' => 'required|min:11',
            'address' => 'required|min:3',
            'source' => 'required|min:3',
            'link' => 'required|min:3',
            'type' => 'required|in:individual,wholesaler,retailer'
        ]);

        
        
        Customer::create($request->all());

        return redirect()->route('customer.list');
    }
    public function createPage()
        {
            return view('dashboard.personal.customer.create');
        }
    /**
     * 
     * update customer 
     * request input customer_id required
     * 
     */
    public function update(Request $request)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'name' => '|min:3',
            'phone' => '|min:11',
            'address' => 'min:4',
            'source' => 'min:3',
            'link' => 'min:2',
            'type' => 'in:individual,wholesaler,retailer'
        ]);

        Customer::find($request->customer_id)->update($request->all());
        return redirect()->route('customer.list');


    }
    public function delete(Request $request)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,id'
        ]);
        Customer::find($request->customer_id)->delete();

        return redirect()->route('customer.list');
    }
    /**
     * 
     * get all for select
     * 
     */
    public function getAll()
    {
        $customers = Customer::all();
    }
    /**
     * 
     * get all for pagination
     * 
     */
    public function getAllPaginate()
    {
        $customers = Customer::paginate(15);
        return view('dashboard.personal.customer.list')->with('customers', $customers);
    }

    public function editPage( $cust_id)
    {
        $customer = Customer::where('id', $cust_id)->first();
        return view('dashboard.personal.customer.edit')->with('customer', $customer);
    }


    /**
     * 
     * get customer by id
     * request input customer_id
     * 
     */
    public function getCustomerById(Request $request)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,id'
        ]);
        $customer = Customer::where('id', $request->customer_id)->first();
    }
}