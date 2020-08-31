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
                            <tr class="row">
                                <div class="col-md-12">
                                    <th class="col-md-3">Product code</th>
                                    <th class="col-md-3">Product</th>
                                    <th class="col-md-3">Size</th>
                                    <th class="col-md-3">Qty</th>
                                </div>
                            </tr>
                        </thead>
                        <tbody>

                            <tr class="row" v-for="order in orders">
                                <div class="col-md-12">
                                    <td class="col-md-3">@{{order.produce_code}}</td>
                                    <td class="col-md-3">@{{order.product}}</td>
                                    <td class="col-md-3">@{{order.size}}</td>
                                    <td class="col-md-3">@{{order.qty}}</td>
                                </div>
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