@extends('index')
@section('content')
<div id="app" class="row">
    <div id="loader" style="display: none;" class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="row">

                    <div class="col-md-3">
                        <label for="">{{__('words.confirmation')}}</label>
                        <select id="confrimation" class="form-control" v-if="data.order.preparation != 'shipped'" v-model="data.order.confirmation" id="">
                            <option value="" disabled>{{__('words.choose')}}</option>
                            <option value="confirmed" :selected="data.order.confirmation == 'confirmed'">{{__('words.confirmed')}}</option>
                            <option value="pending" :selected="data.order.confirmation == 'pending'">{{__('words.pending')}}</option>
                            <option value="canceled" :selected="data.order.confirmation == 'canceled'">{{__('words.canceled')}}</option>
                            <option value="delayed" :selected="data.order.confirmation == 'delayed'">{{__('words.delayed')}}</option>
                        </select>
                    </div>
                    <div v-if="data.order.confirmation == 'delayed'" class="col-md-3 flex">
                        <label for="">{{__('words.pending_until')}}</label>
                        
                        <input class="form-control" type="date" v-model="data.order.pending_date">
                    </div>

                    <div v-if="data.order.confirmation == 'confirmed'" class="col-md-3 flex">
                        <label for="">{{__('words.shipping_company')}}</label>
                        <select class="form-control" v-model="shipping_company_id">
                            <option value="" disabled selected>{{__('words.choose_company')}}</option>
                            <option :value="company.id" v-for="company in shipping_companies">@{{company.name}}</option>
                        </select>
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

                <div class="row">
                    <div class="col-sm-12">
                        <div class = "row row_style">
                            <div class = "col-md-3 first_col">  {{__('words.customer')}} </div>
                            <div class = "col-md-6 second_col">@{{customer.name + ' - ' + customer.phone}}  </div>
                        </div>
    
                        <div class = "row row_style">
                            <div class = "col-md-3 first_col">  {{__('words.bar_code')}} </div>
                            <div class = "col-md-6 second_col">@{{data.order.bar_code}}  </div>
                        </div>
    
                        <div class = "row row_style">
                            <div class = "col-md-3 first_col">  {{__('words.delivery_date')}} </div>
                            <div class = "col-md-6 second_col">@{{data.order.delivery_date}} </div>
                        </div>
    
                    </div> 
                </div>
                <br>

                
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
                        <div class="col-md-12">
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
    @include('dashboard.orders.buy_order.v-scripts.vue-show')
</div>
@endsection

@push('styles')
<style>
    .row_style
    {
        margin: 10px 5px;
    }

    .second_col
    {
        border: solid 1px #2359a5;
        padding: 3px 5px ;
        font-size: 1.2em;
    }

    .first_col
    {
        color: #2359a5;
        font-size: 1.2em;
    }
</style>
@endpush