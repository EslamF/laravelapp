@extends('index')
@section('content')
<div id="app" class="row">
    <div class="col-md-12">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">إنشاء إذن إستلام المنتجات</h3>
            </div>
            @include('includes.loading')
            <!-- /.card-header -->
            <!-- form start -->
            <form role="form" action="{{Route('receiving.product.store')}}" method="POST">
                @csrf
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="factory">إذن التصنيع</label>
                                <span style="color:red" v-if="error.produce_order_id">*@{{error.produce_order_id}}</span> 
                                <select class="form-control" @change="listProducts(produce_order_id)" v-model="produce_order_id">
                                    <option value="" disabled selected>حدد إذن التصنيع</option>
                                    <option :value="order.id" v-for="order in produce_orders">@{{order.id + ' - ' + order.factory.name + ' - ' + order.user.name}}</option>
                                </select>
                                @error('produce_order_id')
                                <p class="help is-danger">
                                    {{$message}}
                                </p>
                                @enderror
                            </div>
                        </div>
                    </div>
                  
                    <table class="table" v-if="products.length > 0">
                        <thead>
                            <tr>
                                <th>id</th>
                                <th>Product type</th>
                                <th>Size</th>
                                <th>Total quantity</th>
                                <th>Received</th>
                                <th>Required</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(product,index) in products">
                                <td>@{{index + 1 }}</td>
                                <td>@{{product.product_type}}</td>
                                <td>@{{product.size}}</td>
                                <td>@{{product.count}}</td>
                                <td>@{{product.number_of_received}}</td>

                                <td>
                                    <span v-if="have_error" style="color:red">@{{product.err}}</span>
                                    {{--<span v-if="have_error" style="color:red">@{{available_products[index].error_qty}}</span>--}}
                                    <input type="number" min="0" :max = "product.count" style="width:60%" class="form-control" v-model="product.required" v-bind:id="'product' + index">
                                </td>
                            </tr>
                        </tbody>
                    </table>

                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                    <button type="button" id = "btnSubmit" @click="goToProduceOrderList()" class="btn btn-primary">Approve</button>
                </div>
            </form>
        </div>
    </div>
</div>
@include('dashboard.orders.receiving_products.v-script.create-script')

@endsection