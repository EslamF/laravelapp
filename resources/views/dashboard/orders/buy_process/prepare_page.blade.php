@extends('index')
@section('content')
<div id="app" class="row">
    <div id="loader" style="display:none" class="col-md-12">
        <div class="card">
            <div class="card-header">
                <label for="">Add Product</label>
                <span v-if="add_error" style="color: red;">@{{add_error}}</span>
                <span v-if="invalid_error" style="color: red;">@{{invalid_error}}</span>
                <span v-if="save_error" style="color: red;">@{{save_error}}</span>
                <label style="color: red;">count(@{{count}})</label>
                <input type="text" @keyup.enter="validateProduct()" v-model="prod_code" class="form-control col-md-6">

            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table class="table ">
                    <thead>
                        <tr class="row">
                            <div class="col-md-12">
                                <th class="col-md-4">Product</th>
                                <th class="col-md-4">Size</th>
                                <th class="col-md-4">Qty</th>
                            </div>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="row" v-for="product in items">
                            <div>
                                <td class="col-md-4">@{{product.product}}</td>
                                <td class="col-md-4">@{{product.size}}</td>
                                <td class="col-md-4">@{{product.qty}}</td>
                            </div>
                        </tr>
                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
            <div class="card-footer clearfix">
                <a href="{{url()->previous()}}" class="btn btn-dark float-right">Back</a>
                <button @click="saveOrder" class="btn btn-primary mr-2 float-right">save</button>
            </div>
        </div>
        <!-- /.card -->
    </div>
    @include('dashboard.orders.buy_process.v-scripts.vue-prepare')
</div>
@endsection