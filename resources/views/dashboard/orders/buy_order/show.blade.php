@extends('index')
@section('content')
<div id="app" class="row">
    <div id="loader" style="display: none;" class="col-12">
        <div class="card">
            <div class="card-header noprint">
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

                    <div class="col-md-3">
                        <label for="">{{__('words.status_message')}}</label>
                        <input type = "text" id="status_message" class="form-control" v-model="status_message">
                    </div>

                    <div class="col-md-3 flex">
                        <label for="">{{__('words.shipping_company')}}</label>
                        <select class="form-control" v-model="shipping_company_id">
                            <option value="" disabled selected>{{__('words.choose_company')}}</option>
                            <option :value="company.id" v-for="company in shipping_companies">@{{company.name}}</option>
                        </select>
                    </div>
                </div>
                <br><br>
                <div>
                    
                    {{-- <a href = "{{route('buy.print' , $order->id)}}" class = "btn btn-info float-left">طباعة</a> --}}
                    <button onclick="printing()" class = "btn btn-info float-left noprint">طباعة</button>
                </div>
                <!-- <div v-if="order_status" class="row  mt-4">
                    <label for="">تعليق علي حالة الاوردر</label>
                    <textarea v-model="status_message" class="form-control" id="" cols="30" rows="10"></textarea>
                </div> -->
            </div>
            <!-- /.card-header -->
            
            <div class="card-body">

                <div class = "row">
                    <div class="col-sm-12 text-center">
                        {!! DNS1D::getBarcodeSVG($order->bar_code, 'EAN13',2.1,100,'black', true) !!}
                    </div>
                </div>
                <br>

                <div class = "row" dir = "ltr">
                    <div class = "col-sm-12">
                        <table class = "table table-bordered">
                            <thead>
                                <th>{{__('words.order_reference_en')}}</th>
                                <th>{{__('words.delivery_date_en')}}</th>
                                <th>{{__('words.shipping_company_en')}}</th> 
                            </thead>

                            <tbody>
                                <td>@{{data.order.order_number}}</td>
                                <td>@{{data.order.delivery_date}}</td>
                                <td>@{{data.order.shipping_company ? data.order.shipping_company.name : ''}}</td>
                            </tbody>
                        </table>
                    </div>

                </div>
                
                <div class="row " dir = "ltr">
                    <div class="col-sm-7 bordering">
                        <div class = "row row_style">
                            <div>
                                <p>{{__('words.customer_en')}} : <strong>  @{{customer.name}} </strong> </p>
                            </div>
                        </div>

                        <div class = "row row_style">
                            <div>
                                <p>{{__('words.phone_en')}} : <strong>  @{{customer.phone}} </strong> </p>
                            </div>
                        </div>

                        <div class = "row row_style">
                            <div>
                                <p>{{__('words.address_en')}} : <strong>  @{{customer.address}} </strong> </p>
                            </div>
                        </div>
                    </div> 

                    <div class = "col-sm-1">
                    </div>


                    <div class = "col-sm-4 bordering">
                        <table class = "table table-bordered">
                            <thead>
                                <th>{{__('words.code_en')}}</th>
                                <th>{{__('words.size_en')}}</th>
                                <th>{{__('words.qunatity_en')}}</th> 
                            </thead>

                            <tbody>
                                <tr role="row" v-for="(product,index) in data.products" class="odd">
                                    <td>@{{product.mq_r_code}}</td>
                                    <td>@{{product.product_size}}</td>
                                    <td>@{{product.company_qty + product.factory_qty }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                

                </div>
                
                <br>

                <div class = "row" dir = "ltr">
                    <div>
                        <p>{{__('words.description_en')}} : <strong>  @{{data.order.description}} </strong> </p>
                    </div>
                </div>
                <div class = "row" dir = "ltr">
                    <div>
                        <p>{{__('words.cash_en')}} : <strong>  @{{data.order.price}} </strong> </p>
                    </div>
                </div>
            
                <!-- logo -->
                <div> 
                    <img src = "{{asset('logo2.jpeg')}}" style = "width:150px;">
                </div>

                <div class="col-md-12 no-print">
                    <button @click="updateData()" class="mr-4 float-right btn btn-primary noprint" {{ Laratrust::isAbleTo('edit-buy-order') ? '' : 'disabled' }} >
                        {{__('words.edit')}}
                    </button>
                </div>

                
                <div id="example2_wrapper" class="dataTables_wrapper dt-bootstrap4">
                    <div class="row">
                        <div class="col-sm-12 col-md-6"></div>
                        <div class="col-sm-12 col-md-6"></div>
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
    .bordering 
    {
        border: solid 1px #4d4e50;
        /*margin-left: 5px;*/
    }
    .row_style
    {
        margin: 3px 5px;
    }

    .second_col
    {
        /*border: solid 1px #2359a5;*/
        padding: 0 ;
        font-size: 1.2em;
    }

    .first_col
    {
        color: #2359a5;
        font-size: 1.2em;
    }

    /* Screen Only */
    @media screen {
        .noprint {display:block !important;}
        .noshow {display:none !important;}
    }

    /* Print Only */
    @media print {
        .noprint {display:none !important;}
        .noshow {display:block !important;}
    }
</style>
@endpush

@push('scripts')
<script>
    function printing(){
        window.print();
    }
</script>
@endpush