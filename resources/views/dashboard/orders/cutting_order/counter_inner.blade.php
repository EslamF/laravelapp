@extends('index')
@section('content')
<div class="row">
    <div class="col-lg-6 col-6">
        <!-- small box -->
        <div class="small-box bg-primary" style="padding-top:10px">
            <div class="hold" style="margin-right:30px">
                <h3>{{$current ?? 0}}<sup style="font-size: 20px"></sup></h3>
                <h4>أذونات القص الداخلية الحالية</h4>
            </div>
            <div class="icon">
                <i class="ion ion-stats-bars"></i>
            </div>
            <a href="{{Route('cutting.material.hold_list')}}" class="small-box-footer"><h6 style="display: inline-block ">عرض </h6><i class="fas fa-arrow-circle-right" style="margin: 5px"></i></a>
        </div>
    </div>
    <div class="col-lg-6 col-6">
        <!-- small box -->
        <div class="small-box bg-success" style="padding-top:10px">
            <div class="used" style="margin-right:30px">
                <h3>{{$previous ?? 0}}<sup style="font-size: 20px"></sup></h3>
                <h4>أذونات القص الداخلية السابقة</h4>
            </div>
            <div class="icon">
                <i class="ion ion-stats-bars"></i>
            </div> 
            <a href="{{Route('cutting.material.used_list')}}" class="small-box-footer"><h6 style="display: inline-block ">عرض </h6>  <i class="fas fa-arrow-circle-right" style="margin: 5px"></i></a>
        </div>
    </div>
</div>
@endsection