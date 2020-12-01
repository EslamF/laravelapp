@extends('index')
@section('content')
<div id="app" class="row">
    <div id="loader" style="display: none;" class="col-md-12">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Add Produce Order</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->

            <form role="form" method="POST">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group">
                                <label for="phone">Search By phone</label>
                                <input type="text" @keyup="searchOnCustomer" v-model="search_phone" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="customer_id">Customers</label>
                                <select class="form-control" @change="getCustomer" v-model="customer_id" id="">
                                    <option :value="customer.id" v-for="customer in customers" :key="customer.id">@{{customer.name}}</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="name">Name</label>
                                <span style="color:red" v-if="customer_errors.name">@{{customer_errors.name}}</span>
                                <input type="text" v-model="customer.name" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="phone">Phone</label>
                                <span style="color:red" v-if="customer_errors.phone">@{{customer_errors.phone}}</span>
                                <input type="text" v-model="customer.phone" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="address">Address</label>
                                <span style="color:red" v-if="customer_errors.address">@{{customer_errors.address}}</span>
                                <input type="text" v-model="customer.address" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="source">Source</label>
                                <span style="color:red" v-if="customer_errors.source">@{{customer_errors.source}}</span>
                                <input type="text" v-model="customer.source" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="link">Link</label>
                                <span style="color:red" v-if="customer_errors.link">@{{customer_errors.link}}</span>
                                <input type="text" v-model="customer.link" class="form-control">
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">Product Code</label>
                                <input type="text" class="form-control" @keyup.enter="cuttingOrders" v-model="mq_r_code" id="">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="delivery_date">Delivery Date</label>
                                <input type="date" v-model="delivery_date" class="form-control">
                            </div>
                        </div>
                        <table class="table" v-show="products.length > 0">
                            <thead>
                                <tr class="row">
                                    <div class="col-md-12">
                                        <th class="col-md-2">Product</th>
                                        <th class="col-md-2">Size</th>
                                        <th class="col-md-2">Company Stock</th>
                                        <th class="col-md-2">Factory Stock</th>
                                        <th class="col-md-2">Qty</th>
                                        <th class="col-md-2">Price</th>
                                    </div>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="row" v-for="(product,index) in products" :key="index">
                                    <div class="col-md-12">
                                        <td class="col-md-2">@{{product.product_type}}</td>
                                        <td class="col-md-2">@{{product.size}}</td>
                                        <td class="col-md-2">@{{product.company_count}}</td>
                                        <td class="col-md-2">@{{product.factory_count}}</td>
                                        <td class="col-md-2">
                                            <span v-if="have_error" style="color:red">@{{product.err}}</span>
                                            <span v-if="have_error" style="color:red">@{{products[index].error_qty}}</span>
                                            <input type="number" min="1" style="width:60%" @keyup="updateStock(index, product.qty)" class="form-control" v-model="product.qty" id="">
                                        </td>
                                        <td class="col-md-2">
                                            <span v-if="have_error" style="color:red">@{{product.price_err}}</span>
                                            <span v-if="have_error" style="color:red">@{{product.error_price}}</span>
                                            <input type="number" min="1" class="form-control" style="width:60%" v-model="product.price">
                                        </td>
                                    </div>
                                </tr>
                            </tbody>
                            <div class="col-md-12">

                                <div class="form-group" v-show="products.length > 0">
                                    <label for="">Order Description</label>
                                    <textarea v-model="description" class="form-control" id="" cols="30" rows="5"></textarea>
                                </div>
                            </div>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
                <div class="card-footer">
                    <button type="button" @click="sendOrder()" class="btn btn-primary">Submit</button>
                    <a href="{{url()->previous()}}" class="btn btn-info">Back</a>
                </div>
            </form>
        </div>
    </div>
</div>
@include('dashboard.orders.buy_order.v-scripts.vue-create')
</div>
@endsection