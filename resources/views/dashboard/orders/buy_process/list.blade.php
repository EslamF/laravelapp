@extends('index')
@section('content')
<div class="row">
    <div class="col-lg-6 col-6">
        <!-- small box -->
        <div class="small-box bg-danger">
            <div class="inner">
                <h3>{{$new}}</h3>

                <p>{{__('words.new_orders')}}</p>
            </div>
            <div class="icon">
                <i class="ion ion-bag"></i>
            </div>
            <a href="{{Route('process.orders_list')}}" class="small-box-footer">{{__('words.more_info')}} <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <div class="col-lg-6 col-6">
        <!-- small box -->
        <div class="small-box bg-info">
            <div class="inner">
                <h3>{{$prepared}}</h3>

                <p>{{__('words.ready_orders')}}</p>
            </div>
            <div class="icon">
                <i class="ion ion-bag"></i>
            </div>
            <a href="{{Route('process.ready_orders_page')}}" class="small-box-footer">{{__('words.more_info')}} <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <div class="col-lg-6 col-6">
        <!-- small box -->
        <div class="small-box bg-success">
            <div class="inner">
                <h3>{{$ready}}</h3>
                <p>{{__('words.ready_to_shipping_orders')}}</p>
            </div>
            <div class="icon">
                <i class="ion ion-bag"></i>
            </div>
            <a href="{{Route('shipping.list_packaged_orders')}}" class="small-box-footer">{{__('words.more_info')}} <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <div class="col-lg-6 col-6">
        <!-- small box -->
        <div class="small-box bg-success">
            <div class="inner">
                <h3>{{$done}}</h3>

                <p>{{__('words.done_orders')}}</p>
            </div>
            <div class="icon">
                <i class="ion ion-bag"></i>
            </div>
            <a href="{{Route('process.done_orders_page')}}" class="small-box-footer">{{__('words.more_info')}} <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>

    <div class="col-lg-6 col-6">
        <!-- small box -->
        <div class="small-box bg-warning">
            <div class="inner">
                <h3>{{$rejected}}</h3>

                <p>{{__('words.returns')}}</p>
            </div>
            <div class="icon">
                <i class="ion ion-bag"></i>
            </div>
            <a href="{{Route('process.rejected_orders_list')}}" class="small-box-footer">{{__('words.more_info')}} <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
</div>
@endsection