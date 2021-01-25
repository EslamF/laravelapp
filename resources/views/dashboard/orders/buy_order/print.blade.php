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
                                <td>{{$order->order_number}}</td>
                                <td>{{$order->delivery_date}}</td>
                                <td>{{$order->shipping_company ? $order->shipping_company->name : ''}}</td>
                            </tbody>
                        </table>
                    </div>

                </div>


                <div class="row " dir = "ltr">
                    <div class="col-sm-7 bordering">
                        <div class = "row row_style">
                            <div>
                                <p>{{__('words.customer_en')}} : <strong>  {{$order->customer->name}} </strong> </p>
                            </div>
                        </div>

                        <div class = "row row_style">
                            <div>
                                <p>{{__('words.phone_en')}} : <strong>  {{$order->customer->phone}} </strong> </p>
                            </div>
                        </div>

                        <div class = "row row_style">
                            <div>
                                <p>{{__('words.address_en')}} : <strong>  {{$order->customer->address}} </strong> </p>
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
                                @foreach($order->buyProducts as $product)
                                    <tr role="row" class="odd">
                                        <td>{{$product['mq_r_code']}}</td>
                                        <td>{{$product['product_size']}}</td>
                                        <td>{{($product['company_qty'] + $product['factory_qty'])}}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <br>

                <div class = "row" dir = "ltr">
                    <div>
                        <p>{{__('words.description_en')}} : <strong>  {{$order->description}} </strong> </p>
                    </div>
                </div>
                <div class = "row" dir = "ltr">
                    <div>
                        <p>{{__('words.cash_en')}} : <strong>  {{$order->price}} </strong> </p>
                    </div>
                </div>
                <!-- logo -->
                <div> 
                    <img src = "{{asset('logo2.jpeg')}}" style = "width:150px;">
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
    window.print();
</script>
@endpush