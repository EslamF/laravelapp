@extends('index')
@section('content')
<div id="app" class="row">
    <div class="col-md-12">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Add Receiving Products Order</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form role="form" action="{{Route('receiving.product.store')}}" method="POST">
                @csrf
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="factory">Produce Order</label>
                                <select class="form-control" @change="listProducts(produce_order_id)" v-model="produce_order_id">
                                    <option value="" disabled selected>Select Produce Order</option>
                                    <option :value="order.id" v-for="order in produce_orders">@{{order.id}}</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <table class="table" v-if="received_products.length > 0">
                        <h4 v-if="received_products.length> 0"> Received Products</h4>
                        <thead>
                            <tr class="row">
                                <div class="col-md-12">
                                    <th class="col-md-1">id</th>
                                    <th class="col-md-3">Product type</th>
                                    <th class="col-md-3">Size</th>
                                    <th class="col-md-3">Qty</th>
                                    <th class="col-md-2">Action</th>
                                </div>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="row" v-for="(product,index) in received_products">
                                <div class="col-md-12">
                                    <td class="col-md-1">@{{index + 1 }}</td>
                                    <td class="col-md-3">@{{product.product_type.name}}</td>
                                    <td class="col-md-3">@{{product.size.name}}</td>
                                    <td class="col-md-3">@{{product.qty}}</td>
                                    <td class="col-md-2">
                                        <button class="btn btn-danger" type="button" @click="changeStatus(0, product.id, index)">UnApprove</button>
                                    </td>
                                </div>
                            </tr>
                        </tbody>
                    </table>
                    <table class="table" v-if="products.length > 0">
                        <thead>
                            <tr class="row">
                                <div class="col-md-12">
                                    <th class="col-md-1">id</th>
                                    <th class="col-md-3">Product type</th>
                                    <th class="col-md-3">Size</th>
                                    <th class="col-md-3">Qty</th>
                                    <th class="col-md-2">Action</th>
                                </div>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="row" v-for="(product,index) in products">
                                <div class="col-md-12">
                                    <td class="col-md-1">@{{index + 1 }}</td>
                                    <td class="col-md-3">@{{product.product_type.name ?? ""}}</td>
                                    <td class="col-md-3">@{{product.size.name ?? ""}}</td>
                                    <td class="col-md-3">@{{product.qty}}</td>
                                    <td class="col-md-2">
                                        <button class="btn btn-success" type="button" @click="changeStatus(1, product.id, index)">Approve</button>
                                    </td>
                                </div>
                            </tr>
                        </tbody>
                    </table>

                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                    <button type="button" @click="goToProduceOrderList()" class="btn btn-primary">Go To List</button>
                </div>
            </form>
        </div>
    </div>
</div>
@include('dashboard.orders.receiving_products.v-script.create-script')
</div>
@endsection