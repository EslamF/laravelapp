@extends('index')
@section('content')
<div id="app" class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">عرض بيانات العميل</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <div id="example2_wrapper" class="dataTables_wrapper dt-bootstrap4">
                    <div class="row">
                        <div class="col-sm-12 col-md-6"></div>
                        <div class="col-sm-12 col-md-6"></div>
                    </div>

                    <h3 class = "text-center bg-primary" style = "padding: 5px 0;">{{__('words.customer_data')}}</h3>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class = "row row_style">
                                <div class = "col-md-3 first_col">  {{__('words.name')}} </div>
                                <div class = "col-md-6 second_col"> {{$customer->name}} </div>
                            </div>

                            <div class = "row row_style">
                                <div class = "col-md-3 first_col">  {{__('words.phone')}} </div>
                                <div class = "col-md-6 second_col"> {{$customer->phone}} </div>
                            </div>

                            <div class = "row row_style">
                                <div class = "col-md-3 first_col">  {{__('words.address')}} </div>
                                <div class = "col-md-6 second_col"> {{$customer->address}} </div>
                            </div>

                            <div class = "row row_style">
                                <div class = "col-md-3 first_col">  {{__('words.source')}} </div>
                                <div class = "col-md-6 second_col"> {{$customer->source}} </div>
                            </div>

                            <div class = "row row_style">
                                <div class = "col-md-3 first_col">  {{__('words.link')}} </div>
                                <div class = "col-md-6 second_col"> {{$customer->link}} </div>
                            </div>

                            <div class = "row row_style">
                                <div class = "col-md-3 first_col">  {{__('words.notes')}} </div>
                                <div class = "col-md-6 second_col"> {{$customer->notes}} </div>
                            </div>

                            <div class = "row row_style">
                                <div class = "col-md-3 first_col">  {{__('words.type')}} </div>
                                <div class = "col-md-6 second_col"> {{__('words.' . $customer->type)}} </div>
                            </div>
                        </div> 
                    </div>
                    <br><br>
                    <h3 class = "text-center bg-primary" style = "padding: 5px 0;">{{__('words.previous_orders')}}  ( {{count($customer->buyOrders)}} )  </h3>
                    <div class="row">
                        <div class="col-sm-12">
                            @if(count($customer->buyOrders) > 0)
                                <table id="example2" class="table table-bordered table-hover dataTable dtr-inline" role="grid" aria-describedby="example2_info">
                                    <thead>
                                        <tr role="row">
                                            {{--<th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending">{{__('words.product')}}</th>--}}
                                            <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending">{{__('words.order_number')}}</th>
                                            <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending">{{__('words.order_preparation')}}</th>
                                            <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending">{{__('words.delivery_date')}}</th>
                                            <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Platform(s): activate to sort column ascending">{{__('words.confirmation')}}</th>
                                            <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Platform(s): activate to sort column ascending">{{__('words.order_status')}}</th>
                                            <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Engine version: activate to sort column ascending">{{__('words.price')}}</th>
                                            <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Engine version: activate to sort column ascending">{{__('words.actions')}}</th>
                                            <!-- <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="CSS grade: activate to sort column ascending">Remove</th> -->
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($customer->buyOrders as $order)
                                            <tr role="row" class="odd">
                                                {{--<td tabindex="0" class="sorting_1">@{{product.product_type}}</td>--}}
                                                <td tabindex="0" class="sorting_1">{{$order->bar_code}}</td>
                                                <td>{{ __('words.' . $order->preparation)}}</td>
                                                <td>{{$order->delivery_date}}</td>
                                                <td><span class = "{{$order->confirmation_color}}" style = "padding:5px; border-radius:5px;">{{ __('words.' . $order->confirmation)}}</span></td>
                                                <td><span class = "{{$order->status_color}}" style = "padding:5px; border-radius:5px;">{{ $order->translate_status }}</span></td>
                                                <td>{{$order->orderTotal()}} ج </td>
                                                <td><a href = "{{route('buy.show_order' , $order->id)}}" class = "btn btn-info">{{__('words.show')}}</a></td>
                                                
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
                                            <th rowspan="1" colspan="1"></th>
                                            <th rowspan="1" colspan="1"></th>
                                        </tr>
                                    </tfoot>
                                </table>
                            @else 
                                <p class = "text-center">لا يوجد طلبات سابقة للعميل</p>
                            @endif
                        </div>
                      
                    </div>
                </div>
            </div>
            <!-- /.card-body -->
        </div>
    </div>
    {{--@include('dashboard.orders.buy_order.v-scripts.vue-show')--}}
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