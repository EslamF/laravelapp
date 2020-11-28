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
                        <tr>
                            <th> الرقم المرجعي</th>
                            <th>موظف الفرش</th>
                            <th>كود الخامة</th>
                            <th>الوزن</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data as $value)
                        <tr>
                            <td>{{$value->id}}</td>
                            <td>{{$value->user->name}}</td>
                            <td>{{$value->material->mq_r_code}}</td>
                            <td>{{$value->weight}}</td>
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
