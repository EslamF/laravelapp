@extends('index')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">{{__('words.rejected_orders')}}</h3>
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
                                <th>{{__('words.shipping_date')}}</th>
                                <th>{{__('words.actions')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($orders as $order)
                            <tr>
                                <td>{{$order->bar_code}}</td>
                                <td>{{$order->shippingOrders->last()->shippingCompany->name}}</td>
                                <td>{{$order->shippingOrders->last()->shipping_date}}</td>
                                <td>
                                    <a href="{{Route('process.receive_rejected_orders_page', $order->id)}}" class="btn btn-primary  {{ Laratrust::isAbleTo('returned_orders') ? '' : 'disabled' }}" >{{__('words.receive_order')}}</a>
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
                <div class="offset-5">

                    {{$orders->links()}}
                </div>
            </div>
        </div>
        <!-- /.card -->
    </div>
</div>
@endsection