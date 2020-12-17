@extends('index')
@section('content')
<div id="app" class="row">
    <div id="loader" style="display:none" class="col-md-12">
        <div class="card">
            <div class="card-header">
                <label for="">{{__('words.add_product')}}</label>
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
                        <tr>
                            <th>{{__('words.product')}}</th>
                            <th>{{__('words.size')}}</th>
                            <th>{{__('words.qty')}}</th>
                            
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="product in items">
                            <td>@{{product.product}}</td>
                            <td>@{{product.size}}</td>
                            <td>@{{product.qty}}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
            <div class="card-footer clearfix">
                <a href="{{url()->previous()}}" class="btn btn-dark float-right" style = "margin: 0 5px;">{{__('words.back')}}</a>
                <button @click="saveOrder" class="btn btn-primary mr-2 float-right">{{__('words.save')}}</button>
            </div>
        </div>
        <!-- /.card -->
    </div>
    @include('dashboard.orders.buy_process.v-scripts.vue-prepare')
</div>
@endsection