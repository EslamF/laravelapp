@extends('index')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">{{__('words.new_orders')}}</h3>
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
                                <th>{{__('words.confirmation')}}</th>
                                <th>{{__('words.delivery_date')}}</th>
                                <th>{{__('words.shipping_company')}}</th>
                                <th>{{__('words.actions')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($orders as $value)
                            <tr>
                                <td>{{$value->id}}</td>
                                <td>{{$value->bar_code}}</td>
                                <td><span class = "{{$value->confirmation_color}}" style = "padding:5px; border-radius:5px;">{{__('words.' . $value->confirmation)}}</span></td>
                                <td>{{$value->delivery_date}}</td>
                                <td>{{$value->shippingCompany ? $value->shippingCompany->name : ''}}</td>
                                <td>
                                    <a href="{{Route('process.prepare_order_page', $value->id)}}" class="btn btn-primary  {{ Laratrust::isAbleTo('prepare-orders') ? '' : 'disabled' }}" >{{__('words.prepare_order')}}</a>
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