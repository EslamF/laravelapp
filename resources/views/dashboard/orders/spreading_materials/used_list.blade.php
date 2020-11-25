@extends('index')
@section('content')
<div id="app" class="row">
    <div class="col-md-12">
        <div class="card ">
            <div class="card-header">
                <h3 class="card-title"> أذونات الفرش السابقة</h3>
                <a href="{{Route('spreading.material.counter_list')}}" class="btn btn-info float-right" style="margin-right: 5px">رجوع</a>
                <a href="{{Route('spreading.material.create_page')}}" class="btn btn-success float-right" >إنشاء</a>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table class="table ">
                    <thead>
                        <tr class="row">
                            <div class="col-md-12">
                                <th class="col-md-1"> الرقم المرجعي</th>
                                <th class="col-md-4">موظف الفرش</th>
                                <th class="col-md-4">كود الخامة</th>
                                <th class="col-md-3">الوزن</th>
                            </div>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data as $value)
                        <tr class="row">
                            <div class="col-md-12">
                                <td class="col-md-1">{{$value->id}}</td>
                                <td class="col-md-4">{{$value->user->name}}</td>
                                <td class="col-md-4">{{$value->material->mq_r_code}}</td>
                                <td class="col-md-3">{{$value->weight}}</td>
                            </div>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
            <div class="card-footer clearfix">
                <div class="offset-5">
                    {{$data->links()}}
                </div>
            </div>
        </div>
        <!-- /.card -->
    </div>
</div>
@endsection
