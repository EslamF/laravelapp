@extends('index')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">{{__('words.store_order')}}</h3>
                <a href="{{url()->previous()}}" class="btn btn-info float-right">{{__('words.back')}}</a>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <h3 style="display: block;">{{__('words.shipping_employee')}} : <span> {{$order->shippinguser ? $order->shippinguser->name : ''}} </span></h3>
                    <h3 style="display: block;">{{__('words.order_code')}} : <span> {{$order->code}}</span></h3>
                    <table class="table ">
                        <thead>
                            <tr>
                                <th>{{__('words.product_code')}}</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach($products as $product)
                            <tr>
                                <td>{{$product->prod_code}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
            </div>
            <!-- /.card-body -->
            <div class="card-footer clearfix">
                {{$products->links()}}
            </div>
        </div>
        <!-- /.card -->
    </div>
</div>
@endsection