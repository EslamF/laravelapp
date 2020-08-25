@extends('index')
@section('content')
<div id="app" class="row">
    <div class="col-md-12">
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
                                <label for="mq_r_code">Customers</label>
                                <select class="form-control" @change="getCustomer" v-model="customer_id" id="">
                                    <option :value="customer.id" v-for="customer in customers">@{{customer.name}}</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">

                            <div class="form-group">
                                <label for="weight">Name</label>
                                <input type="text" v-model="customer.name" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-4">

                            <div class="form-group">
                                <label for="weight">Phone</label>
                                <input type="text" v-model="customer.phone" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-4">

                            <div class="form-group">
                                <label for="weight">Address</label>
                                <input type="text" v-model="customer.address" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="weight">Source</label>
                                <input type="text" v-model="customer.source" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="weight">Link</label>
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
                    </div>
                    <!-- /.card-body -->
                </div>
                <div class="card-footer">
                    <button type="button" class="btn btn-primary">Submit</button>
                    <a class="btn btn-info">Back</a>
                </div>
            </form>
        </div>
    </div>
</div>
@include('dashboard.orders.buy_order.v-scripts.vue-create')
</div>
@endsection