@extends('index')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">{{__('words.done_orders')}}</h3>
                <a href="{{Route('process.get_list')}}" class="btn btn-dark float-right">{{__('words.back')}}</a>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                @if($orders->count())
                    <table class="table">
                        <thead>
                            <tr>
                                <th>{{__('words.order_number')}}</th>
                                <th>{{__('words.shipping_company')}}</th>
                                <th>{{__('words.delivery_date')}}</th>
                                <th>{{__('words.order_status')}}</th>
                                <th>{{__('words.actions')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($orders as $order)
                            <tr>
                                <td>{{$order->bar_code}}</td>
                                <td>{{$order->shippingOrders->last()->shippingCompany->name}}</td>
                                <td>{{$order->delivery_date}}</td>
                                <td><span class = "{{$order->status_color}}" style = "padding:5px; border-radius:5px;">{{ $order->translate_status }}</span></td>
                                <td>
                                    <a href="{{Route('process.done_order_page', $order->id)}}" class="btn btn-primary">{{__('words.show')}}</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <p class="text-center">لا يوجد بيانات</p>
                @endif
            </div>
            <!-- /.card-body -->
            <div class="card-footer clearfix">
                {{$orders->links()}}
            </div>
        </div>
        <!-- /.card -->
    </div>
</div>
@endsection