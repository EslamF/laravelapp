@extends('index')
@section('content')
<div id="app" class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <label for="">Confirmation</label>
                <select style="display: inline;" id="confrimation" class="col-md-4 form-control" v-model="data.order.confirmation" id="">
                    <option value="" dsiabled>Choose One</option>
                    <option value="confirmed" :selected="data.order.confirmation == 'confirmed'">Confirmed</option>
                    <option value="pending" :selected="data.order.confirmation == 'pending'">Pending</option>
                    <option value="canceled" :selected="data.order.confirmation == 'canceled'">Canceled</option>
                </select>
                <div v-if="data.order.confirmation == 'pending'" style="display: inline;">
                    <label for="">Pending Until</label>
                    <input style="display: inline;" class="col-md-4 form-control" type="date" v-model="data.order.pending_date">
                </div>
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