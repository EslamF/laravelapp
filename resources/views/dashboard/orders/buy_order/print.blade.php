@extends('index')
@section('content')
<div class="row">
    <div class="col-12">
        @foreach($orders as $order)
        <div class="card page" style="page-break-after: always;margin:0;" >
            <div class="card-body">

                <div class = "row">
                    <div class="col-sm-12 text-center">
                        <img src = "{{asset(DNS1D::getBarcodePNGPath($order->bar_code, 'C39' , 2 , 100 , array(0 , 0 , 0) , true))}}">
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <div class = "row row_style">
                            <div class = "col-md-3 first_col">  {{__('words.customer')}} </div>
                            <div class = "col-md-6 second_col">{{$order->customer->name}} - {{$order->customer->phone}}  </div>
                        </div>

                        <div class = "row row_style">
                            <div class = "col-md-3 first_col">  {{__('words.address')}} </div>
                            <div class = "col-md-6 second_col">{{$order->customer->address}}  </div>
                        </div>
    
                        <div class = "row row_style">
                            <div class = "col-md-3 first_col">  {{__('words.bar_code')}} </div>
                            <div class = "col-md-6 second_col">{{$order->bar_code}}  </div>
                        </div>
    
                        <div class = "row row_style">
                            <div class = "col-md-3 first_col">  {{__('words.delivery_date')}} </div>
                            <div class = "col-md-6 second_col">{{$order->delivery_date}} </div>
                        </div>

                        <div class = "row row_style">
                            <div class = "col-md-3 first_col">  {{__('words.shipping_company')}} </div>
                            <div class = "col-md-6 second_col">{{$order->shippingCompany ? $order->shippingCompany->name : ''}} </div>
                        </div>

                        <div class = "row row_style">
                            <div class = "col-md-3 first_col">  {{__('words.order_reference')}} </div>
                            <div class = "col-md-6 second_col">{{$order->order_number}} </div>
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
                                
                                    @foreach($order->buyProducts as $product)
                                        <tr role="row" class="odd">
                                            <td tabindex="0" class="sorting_1">{{$product['mq_r_code']}}</td>
                                            <td>{{$product['product_type']}}</td>
                                            <td>{{$product['product_size']}}</td>
                                            <td>{{$product['company_qty']}}</td>
                                            <td>{{$product['factory_qty']}}</td>
                                            <td>
                                                {{$product['price']}}
                                            </td>
                                            <td>{{$product['price'] * ($product['company_qty'] + $product['factory_qty'])}}</td>
                                        </tr>
                                    @endforeach
                                    
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th rowspan="1" colspan="1"></th>
                                        <th rowspan="1" colspan="1"></th>
                                        <th rowspan="1" colspan="1"></th>
                                        <th rowspan="1" colspan="1"></th>
                                        <th rowspan="1" colspan="1"></th>
                                        <th rowspan="1" colspan="1">{{__('words.grand_total')}}</th>
                                        <th rowspan="1" colspan="1">{{$order->price}}</th>
                                        <!-- <th rowspan="1" colspan="1"></th> -->
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                     
                    </div>
                </div>
            </div>
            <!-- /.card-body -->
        </div>
        @endforeach
    </div>
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
    window.print();
</script>
@endpush