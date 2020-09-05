@extends('index')
@section('content')
<div id="app" class="row">
    <div id="loader" style="display: none;" class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="row">

                    <div class="col-md-3">
                        <label for="">Confirmation</label>
                        <select id="confrimation" class="form-control" v-if="data.order.preparation != 'shipped'" v-model="data.order.confirmation" id="">
                            <option value="" dsiabled>Choose One</option>
                            <option value="confirmed" :selected="data.order.confirmation == 'confirmed'">Confirmed</option>
                            <option value="pending" :selected="data.order.confirmation == 'pending'">Pending</option>
                            <option value="canceled" :selected="data.order.confirmation == 'canceled'">Canceled</option>
                        </select>
                    </div>
                    <div v-if="data.order.confirmation == 'pending'" class="col-md-3 flex">
                        <label for="">Pending Until</label>
                        <input class="form-control" type="date" v-model="data.order.pending_date">
                    </div>
                    <!-- <div class="col-md-3  flex">
                        <label for="">اختر حالة الاوردر</label>
                        <select v-model="order_status" class="form-control">
                            <option value="" disabled selected>اختر</option>
                            <option :value="'Delivered'">Delivered</option>
                            <option :value="'InProgress'">InProgress</option>
                            <option :value="'LOST'">LOST</option>
                            <option :value="'Returned'">Returned</option>
                            <option :value="'UnDelivered'">UnDelivered</option>
                        </select>
                    </div> -->
                </div>
                <!-- <div v-if="order_status" class="row  mt-4">
                    <label for="">تعليق علي حالة الاوردر</label>
                    <textarea v-model="status_message" class="form-control" id="" cols="30" rows="10"></textarea>
                </div> -->
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <div id="example2_wrapper" class="dataTables_wrapper dt-bootstrap4">
                    <div class="row">
                        <div class="col-sm-12 col-md-6"></div>
                        <div class="col-sm-12 col-md-6"></div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <table id="example2" class="table table-bordered table-hover dataTable dtr-inline" role="grid" aria-describedby="example2_info">
                                <thead>
                                    <tr role="row">
                                        <th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending">Product</th>
                                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending">Size</th>
                                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Platform(s): activate to sort column ascending">Company Qty</th>
                                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Engine version: activate to sort column ascending">Factory Qty</th>
                                        <th style="width: 12%;" class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Engine version: activate to sort column ascending">Price</th>
                                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="CSS grade: activate to sort column ascending">Total</th>
                                        <!-- <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="CSS grade: activate to sort column ascending">Remove</th> -->
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr role="row" v-for="(product,index) in data.products" class="odd">
                                        <td tabindex="0" class="sorting_1">@{{product.product_type}}</td>
                                        <td>@{{product.product_size}}</td>
                                        <td>@{{product.company_qty}}</td>
                                        <td>@{{product.factory_qty}}</td>
                                        <td>
                                            @{{product.price}}
                                            <!-- <span style="color:red" v-if="have_error">@{{errors[index].price_err}}</span> -->
                                            <!-- <input type="number" @keyup="getGrandTotal()" class="form-control" v-model="product.price"> -->
                                        </td>
                                        <td>@{{product.price * (product.company_qty + product.factory_qty)}}</td>
                                        <!-- <td>
                                            <button type="button" @click="removeItem(index, product.id)" class="btn btn-danger">Remove</button>
                                        </td> -->

                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th rowspan="1" colspan="1"></th>
                                        <th rowspan="1" colspan="1"></th>
                                        <th rowspan="1" colspan="1"></th>
                                        <th rowspan="1" colspan="1"></th>
                                        <th rowspan="1" colspan="1">Grand Total</th>
                                        <th rowspan="1" colspan="1">@{{grand_total}}</th>
                                        <!-- <th rowspan="1" colspan="1"></th> -->
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        <div class="col-md-12">
                            <button @click="updateData()" class="mr-4 float-right btn btn-primary">
                                Update
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.card-body -->
        </div>
    </div>
    @include('dashboard.orders.buy_order.v-scripts.vue-show')
</div>
@endsection