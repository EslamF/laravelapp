@extends('index')
@section('content')
<div id="app" class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title" style="display: block;">Order code @{{orders[0].order_code}}</h3>
                <h3 class="card-title float-right">Delivery date @{{orders[0].delivery_date}}</h3>
            </div>
            <h4 class="ml-3 mt-2">
                </h3>
                <!-- /.card-header -->
                <div class="card-body">
                    <table class="table ">
                        <thead>
                            <tr>
                                <th>Product code</th>
                                <th>Product</th>
                                <th>Size</th>
                                <th>Qty</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="order in orders">
                                    <td>@{{order.produce_code}}</td>
                                    <td>@{{order.product}}</td>
                                    <td>@{{order.size}}</td>
                                    <td>@{{order.qty}}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
                <div class="card-footer clearfix">
                    <a href="{{url()->previous()}}" class="btn btn-dark float-right">Back</a>
                </div>
        </div>
        <!-- /.card -->
    </div>
    @include('dashboard.orders.buy_process.v-scripts.vue-ready-order')
</div>
@endsection