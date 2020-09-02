@extends('index')
@section('content')
<div id="app" class="row">
    <div id="loader" style="display: none;" class="col-md-12">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">انشاء اذن استلام المنتجات</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form role="form" action="{{Route('receiving.product.store')}}" method="POST">
                @csrf
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="factory">اذن التصنيع</label>
                                <select class="form-control" @change="listProducts(produce_order_id)" v-model="produce_order_id">
                                    <option value="" disabled selected>حدد اذن التصنيع</option>
                                    <option :value="order.id" v-for="order in produce_orders">@{{order.id}}</option>
                                </select>
                                @error('produce_order_id')
                                <p class="help is-danger">
                                    {{$message}}
                                </p>
                                @enderror
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
                                    <td class="col-md-3">@{{product.product_type}}</td>
                                    <td class="col-md-3">@{{product.size}}</td>
                                    <td class="col-md-3">@{{product.count}}</td>
                                    <td class="col-md-2">
                                        <button class="btn btn-danger" type="button" @click="changeStatus(0, product.produce_code, index)">UnApprove</button>
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
                                    <td class="col-md-3">@{{product.product_type}}</td>
                                    <td class="col-md-3">@{{product.size}}</td>
                                    <td class="col-md-3">@{{product.count}}</td>
                                    <td class="col-md-2">
                                        <button class="btn btn-success" type="button" @click="changeStatus(1, product.produce_code, index)">Approve</button>
                                    </td>
                                </div>
                            </tr>
                        </tbody>
                    </table>

                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                    <button type="button" @click="goToProduceOrderList()" class="btn btn-primary">Approve</button>
                </div>
            </form>
        </div>
    </div>
</div>
@include('dashboard.orders.receiving_products.v-script.create-script')
</div>
@endsection