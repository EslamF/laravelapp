@extends('index')
@section('content')
<div id="app" class="row">
    <div class="col-md-12">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">{{__('words.add_buy_order')}}</h3>
            </div>
            @include('includes.loading')
            <!-- /.card-header -->
            <!-- form start -->

            <form role="form" method="POST">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group">
                                <label for="phone">{{__('words.search_by_phone')}}</label>
                                <input type="text" @keyup="searchOnCustomer" v-model="search_phone" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="customer_id">{{__('words.customers')}}</label>
                                <select class="form-control" @change="getCustomer" v-model="customer_id">
                                    <option :value="customer.id" v-for="customer in customers" :key="customer.id">@{{customer.name}}</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="province_id">{{__('words.province')}}</label>
                                <select class="form-control" v-model="province_id">
                                    <option :value="province.id" v-for="province in provinces" :key="province.id">@{{province.name}}</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="name">{{__('words.name')}}</label>
                                <span style="color:red" v-if="customer_errors.name">@{{customer_errors.name}}</span>
                                <input type="text" v-model="customer.name" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="phone">{{__('words.phone')}}</label>
                                <span style="color:red" v-if="customer_errors.phone">@{{customer_errors.phone}}</span>
                                <input type="text" v-model="customer.phone" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="address">{{__('words.address')}}</label>
                                <span style="color:red" v-if="customer_errors.address">@{{customer_errors.address}}</span>
                                <input type="text" v-model="customer.address" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="source">{{__('words.source')}}</label>
                                <span style="color:red" v-if="customer_errors.source">@{{customer_errors.source}}</span>
                                <input type="text" v-model="customer.source" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="link">{{__('words.link')}}</label>
                                <span style="color:red" v-if="customer_errors.link">@{{customer_errors.link}}</span>
                                <input type="text" v-model="customer.link" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="link">{{__('words.notes')}}</label>
                                <span style="color:red" v-if="customer_errors.notes">@{{customer_errors.notes}}</span>
                                <input type="text" v-model="customer.notes" class="form-control">
                            </div>
                        </div>

                       

                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="order_number">{{__('words.order_reference')}}</label>
                                <input type="text" v-model="order_number" class="form-control">
                            </div>
                        </div>
                    </div>

                    <br>

                    <div class = "row" v-show="customer.buy_orders.length > 0">
                        <div class = "col-md-12">
                            <label for="link">{{__('words.previous_orders_for_customer')}}</label>
                            <table class = "table table-hover table-borded">
                                
                                <thead>
                                    <tr>
                                        <th>{{__('words.order_number')}}</th>
                                        <th>{{__('words.order_status')}}</th>
                                        <th>{{__('words.confirmation')}}</th>
                                        <th>{{__('words.delivery_date')}}</th>
                                        <th>{{__('words.description')}}</th>
                                        <th>{{__('words.order_preparation')}}</th>
                                    </tr>
                                </thead> 
                                <tbody v-show="customer.buy_orders.length > 0">
                                    <tr v-for="(order ,index) in customer.buy_orders" :key="index">
                                        <td>@{{order.bar_code}}</td>
                                        <td><span :class = "order.status_color" style = "padding:5px; border-radius:5px;">@{{order.translate_status}}</span></td>
                                        <td><span :class = "order.confirmation_color" style = "padding:5px; border-radius:5px;">@{{order.translate_confirmation}}</span></td>
                                        <td>@{{order.delivery_date}}</td>
                                        <td>@{{order.description}}</td>
                                        <td>@{{order.translate_preparation}}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <br><br>
                    <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">{{__('words.mq_r_code')}}</label>
                                    <span style="color:red" v-if="mq_r_code_err">@{{mq_r_code_err}}</span>
                                    <input type="text" class="form-control" @change="cuttingOrders" v-model="mq_r_code">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="delivery_date">{{__('words.delivery_date')}}</label>
                                    <input type="date" v-model="delivery_date" class="form-control">
                                </div>
                            </div>
                    </div>
                   
                        <div class="table-responsive-sm">
                            <table class="table" v-show="products.length > 0">
                                <p v-if = "!have_value"  v-show="products.length > 0" style = "color:red">يجب إدخال منتجات</p>
                                <thead>
                                    <tr>
                                        <th>{{__('words.product')}}</th>
                                        <th>{{__('words.mq_r_code')}}</th>
                                        <th>{{__('words.size')}}</th>
                                        <th>{{__('words.company_stock')}}</th>
                                        <th>{{__('words.factory_stock')}}</th>
                                        <th>{{__('words.qty')}}</th>
                                        {{--<th>{{__('words.price')}}</th>--}}
                                    </tr>
                                </thead>
                                <tbody>
                                    
                                    <tr v-for="(product,index) in products" :key="index">

                                            <td>@{{product.product_type}}</td>
                                            <td>@{{product.mq_r_code}}</td>
                                            <td>@{{product.size}}</td>
                                            <td>@{{product.company_count}}</td>
                                            <td>@{{product.factory_count}}</td>
                                            <td>
                                                <span v-if="have_error" style="color:red">@{{product.err}}</span>
                                                <span v-if="have_error" style="color:red">@{{products[index].error_qty}}</span>
                                                <input type="number" min="1" style="width:60%" @keyup="updateStock(index, product.qty)" class="form-control" v-model="product.qty" v-bind:id="'product' + index">
                                            </td>
                                            {{--<td>
                                                <span v-if="have_error" style="color:red">@{{product.price_err}}</span>
                                                <span v-if="have_error" style="color:red">@{{product.error_price}}</span>
                                                <input type="number" min="1" class="form-control" style="width:60%" v-model="product.price">
                                            </td>--}}
                                        
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                       
                        <div>
                            <br>

                            <div class="form-group col-md-6" v-show="products.length > 0">
                                <label for="">{{__('words.price')}}</label>
                                <span style="color:red" v-if="price_error">@{{price_error}}</span>
                                <input type = "number"  v-model="price" class="form-control">
                            </div>

                            <div class="form-group" v-show="products.length > 0">
                                <label for="">{{__('words.description')}}</label>
                                <textarea v-model="description" class="form-control" cols="30" rows="5"></textarea>
                            </div>

                            
                        </div>
                   
                    </div>
                    <!-- /.card-body -->
                </div>
                <div class="card-footer">
                    <button type="button" @click="sendOrder()" class="btn btn-primary" id = "btnSubmit">{{__('words.add')}}</button>
                    <a href="{{url()->previous()}}" class="btn btn-info">{{__('words.back')}}</a>
                </div>
            </form>
        
    </div>
</div>

</div>
@endsection

@push('scripts')
    @include('dashboard.orders.buy_order.v-scripts.vue-create')
@endpush    