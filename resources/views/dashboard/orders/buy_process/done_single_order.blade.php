@extends('index')
@section('content')
<div id="app" class="row">
    <div id="loader" style="display: none;" class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="row">

                    <div class="col-md-3">
                        <label for="">{{__('words.order_status')}}</label>
                        <select id="order_status" class="form-control" v-if="data.order.status != 'returned'" v-model="order_status" id="">
                            <option value="" disabled>{{__('words.choose')}}</option> 
                            <option value="pending" :selected="data.order.status == 'pending'">{{__('words.pending_order')}}</option>
                            <option value="done" :selected="data.order.status == 'done'">{{__('words.done_order')}}</option>
                            <option value="rejected" :selected="data.order.status == 'rejected'">{{__('words.rejected_order')}}</option>
                        </select>
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
                                        {{--<th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending">{{__('words.product')}}</th>--}}
                                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending">{{__('words.mq_r_code')}}</th>
                                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending">{{__('words.product')}}</th>
                                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending">{{__('words.size')}}</th>
                                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Platform(s): activate to sort column ascending">{{__('words.company_qty')}}</th>
                                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Engine version: activate to sort column ascending">{{__('words.factory_qty')}}</th>
                                        <th style="width: 12%;" class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Engine version: activate to sort column ascending">{{__('words.price')}}</th>
                                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="CSS grade: activate to sort column ascending">{{__('words.total')}}</th>
                                        <!-- <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="CSS grade: activate to sort column ascending">Remove</th> -->
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr role="row" v-for="(product,index) in data.products" class="odd">
                                        {{--<td tabindex="0" class="sorting_1">@{{product.product_type}}</td>--}}
                                        <td tabindex="0" class="sorting_1">@{{product.mq_r_code}}</td>
                                        <td>@{{product.product_type}}</td>
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
                                        <th rowspan="1" colspan="1"></th>
                                        <th rowspan="1" colspan="1">{{__('words.grand_total')}}</th>
                                        <th rowspan="1" colspan="1">@{{grand_total}}</th>
                                        <!-- <th rowspan="1" colspan="1"></th> -->
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        <div class="col-md-12" v-if="data.order.status != 'returned'">
                            <button @click="updateData()" class="mr-4 float-right btn btn-primary" {{ Laratrust::isAbleTo('edit-buy-order') ? '' : 'disabled' }} >
                                {{__('words.edit')}}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.card-body -->
        </div>
    </div>
    @include('dashboard.orders.buy_process.v-scripts.vue-show-done')
</div>
@endsection