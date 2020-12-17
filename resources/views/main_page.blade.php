

@extends('index')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class = "row">
            
            <div class="col-lg-4 col-6">
                <!-- small box -->
                <div class="small-box bg-danger">
                    <div class="inner">
                        <h3>{{$about_to_run_products_count}}</h3>
        
                        <p>{{__('words.about_to_run_products')}}</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-stats-bars"></i>
                    </div>
                    <a href="{{Route('alarms.about_to_run_products')}}" class="small-box-footer">{{__('words.more_info')}} <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>

            <div class="col-lg-4 col-6">
                <!-- small box -->
                <div class="small-box bg-primary">
                    <div class="inner">
                        <h3>{{$low_sale_products_count}}</h3>
        
                        <p>{{__('words.low_sale_products')}}</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-stats-bars"></i>
                    </div>
                    <a href="{{Route('alarms.low_sale_products')}}" class="small-box-footer">{{__('words.more_info')}} <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>

            <div class="col-lg-4 col-6">
                <!-- small box -->
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3>{{$best_selling_products_count}}</h3>
        
                        <p>{{__('words.best_selling_products')}}</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-stats-bars"></i>
                    </div>
                    <a href="{{Route('alarms.best_selling_products')}}" class="small-box-footer">{{__('words.more_info')}} <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>

        </div>
        <!-- /.card -->
    </div>
</div>
@endsection
@section('footer-script')

@endsection