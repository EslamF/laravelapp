@extends('index')
@section('content')
<div class="row">
    <div class="col-lg-4 col-6">
        <!-- small box -->
        <div class="small-box bg-danger">
            <div class="inner">
                <h3>{{$buy_orders_count}}</h3>

                <p>{{__('words.buy_orders_reports')}}</p>
            </div>
            <div class="icon">
                <i class="ion ion-stats-bars"></i>
            </div>
            <a href="{{Route('reports.buy_orders')}}" class="small-box-footer">{{__('words.more_info')}} <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>


    <div class="col-lg-4 col-6">
        <!-- small box -->
        <div class="small-box bg-success">
            <div class="inner">
                <h3>{{$done_buy_orders_count}}</h3>

                <p>{{__('words.sales_reports')}}</p>
            </div>
            <div class="icon">
                <i class="ion ion-stats-bars"></i>
            </div>
            <a href="{{Route('reports.sales')}}" class="small-box-footer">{{__('words.more_info')}} <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>

    <div class="col-lg-4 col-6">
        <!-- small box -->
        <div class="small-box bg-primary">
            <div class="inner">
                <h3>{{$customers_count}}</h3>

                <p>{{__('words.customers_reports')}}</p>
            </div>
            <div class="icon">
                <i class="ion ion-stats-bars"></i>
            </div>
            <a href="{{Route('reports.customers')}}" class="small-box-footer">{{__('words.more_info')}} <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>


    <div class="col-lg-4 col-6">
        <!-- small box -->
        <div class="small-box bg-warning">
            <div class="inner">
                <h3>{{$spreading_orders_count}}</h3>

                <p>{{__('words.spreading_orders_reports')}}</p>
            </div>
            <div class="icon">
                <i class="ion ion-stats-bars"></i>
            </div>
            <a href="{{Route('reports.spreading_orders')}}" class="small-box-footer">{{__('words.more_info')}} <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>

    <div class="col-lg-4 col-6">
        <!-- small box -->
        <div class="small-box bg-danger">
            <div class="inner">
                <h3>{{$cutting_orders_count}}</h3>

                <p>{{__('words.cutting_orders_reports')}}</p>
            </div>
            <div class="icon">
                <i class="ion ion-stats-bars"></i>
            </div>
            <a href="{{Route('reports.cutting_orders')}}" class="small-box-footer">{{__('words.more_info')}} <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>

    <div class="col-lg-4 col-6">
        <!-- small box -->
        <div class="small-box bg-success">
            <div class="inner">
                <h3>{{$produce_orders_count}}</h3>

                <p>{{__('words.produce_orders_reports')}}</p>
            </div>
            <div class="icon">
                <i class="ion ion-stats-bars"></i>
            </div>
            <a href="{{Route('reports.produce_orders')}}" class="small-box-footer">{{__('words.more_info')}} <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>

    <div class="col-lg-4 col-6">
        <!-- small box -->
        <div class="small-box bg-primary">
            <div class="inner">
                <h3>{{$receiving_products_orders_count}}</h3>

                <p>{{__('words.receiving_products_orders_reports')}}</p>
            </div>
            <div class="icon">
                <i class="ion ion-stats-bars"></i>
            </div>
            <a href="{{Route('reports.receiving_products_orders')}}" class="small-box-footer">{{__('words.more_info')}} <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>

    <div class="col-lg-4 col-6">
        <!-- small box -->
        <div class="small-box bg-warning">
            <div class="inner">
                <h3>{{$sorting_orders_count}}</h3>

                <p>{{__('words.sorting_orders_reports')}}</p>
            </div>
            <div class="icon">
                <i class="ion ion-stats-bars"></i>
            </div>
            <a href="{{Route('reports.sorting_orders')}}" class="small-box-footer">{{__('words.more_info')}} <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>

    <div class="col-lg-4 col-6">
        <!-- small box -->
        <div class="small-box bg-danger">
            <div class="inner">
                <h3>{{$save_orders_count}}</h3>

                <p>{{__('words.save_orders_reports')}}</p>
            </div>
            <div class="icon">
                <i class="ion ion-stats-bars"></i>
            </div>
            <a href="{{Route('reports.save_orders')}}" class="small-box-footer">{{__('words.more_info')}} <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>

    <div class="col-lg-4 col-6">
        <!-- small box -->
        <div class="small-box bg-success">
            <div class="inner">
                <h3>{{$store_orders_count}}</h3>

                <p>{{__('words.store_orders_reports')}}</p>
            </div>
            <div class="icon">
                <i class="ion ion-stats-bars"></i>
            </div>
            <a href="{{Route('reports.store_orders')}}" class="small-box-footer">{{__('words.more_info')}} <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>

    <div class="col-lg-4 col-6">
        <!-- small box -->
        <div class="small-box bg-primary">
            <div class="inner">
                <h3>{{$receiving_materials_orders_count}}</h3>

                <p>{{__('words.receiving_materials_orders_reports')}}</p>
            </div>
            <div class="icon">
                <i class="ion ion-stats-bars"></i>
            </div>
            <a href="{{Route('reports.receiving_materials_orders')}}" class="small-box-footer">{{__('words.more_info')}} <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>


</div>
@endsection