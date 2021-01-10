@extends('index')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">{{__('words.ready_orders')}}</h3>
                <a href="{{Route('process.get_list')}}" class="btn btn-dark float-right">{{__('words.back')}}</a>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                @if($orders->count())
                <table class="table">
                    <thead>
                        <tr>
                            <th>{{__('words.id')}}</th>
                            <th>{{__('words.code')}}</th>
                            <th>{{__('words.delivery_date')}}</th>
                            <th>{{__('words.shipping_company')}}</th>
                            <th>{{__('words.actions')}}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $order)
                        <tr>
                            <td>{{$order->id}}</td>
                            <td>{{$order->bar_code}}</td>
                            <td>{{$order->delivery_date}}</td>
                            <td>{{$order->shippingCompany ? $order->shippingCompany->name : ''}}</td>

                            <td>
                                <a href="{{Route('process.ready_order_page', $order->id)}}" class="btn btn-primary">{{__('words.show')}}</a>
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