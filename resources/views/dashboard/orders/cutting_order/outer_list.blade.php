@extends('index')
@section('content')
<div class="row">
    <div class="col-lg-6 col-6">
        <!-- small box -->
        <div class="small-box bg-primary">
            <div class="inner">
                <h3>{{$inner ?? 0}}<sup style="font-size: 20px"></sup></h3>
                <h4>أذونات القص داخلي</h4>
            </div>
            <div class="icon">
                <i class="ion ion-stats-bars"></i>
            </div>
            <a href="{{Route('cutting.material.counter_inner_list')}}" class="small-box-footer">
                <h6 style="display: inline-block ">عرض </h6>  <i class="fas fa-arrow-circle-right" style="margin: 5px"></i></a>
        </div>
    </div>
    <div class="col-lg-6 col-6">
        <!-- small box -->
        <div class="small-box bg-success">
            <div class="inner">
                <h3>{{$outer ?? 0}}<sup style="font-size: 20px"></sup></h3>
                <h4>أذونات القص الخارجية</h4>
            </div>
            <div class="icon">
                <i class="ion ion-stats-bars"></i>
            </div>
            <a href="{{Route('cutting.factory_list')}}" class="small-box-footer"> 
                <h6 style="display: inline-block ">عرض </h6>  <i class="fas fa-arrow-circle-right" style="margin: 5px"></i></a>
        </div>
    </div>
</div>
@endsection