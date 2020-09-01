@extends('index')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card ">
            <div class="card-header">
                <h3 class="card-title">جدول اذونات الفرش</h3>
                <a href="{{Route('spreading.material.create_page')}}" class="btn btn-success float-right">إضافة</a>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table class="table ">
                    <thead>
                        <tr class="row">
                            <div class="col-md-12">
                                <th class="col-md-1"> الرقم المرجعي</th>
                                <th class="col-md-3">كود الخامه</th>
                                <th class="col-md-3">موظف الفرش</th>
                                <th class="col-md-3">الوزن</th>
                                <th class="col-md-2">الخيارات</th>
                            </div>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data as $value)
                        <tr class="row">
                            <div class="col-md-12">
                                <td class="col-md-1">{{$value->id}}</td>
                                <td class="col-md-3">{{$value->material->mq_r_code}}</td>
                                <td class="col-md-3">{{$value->user->name}}</td>
                                <td class="col-md-3">{{$value->weight}}</td>
                                <td class="col-md-2">
                                    <a href="{{Route('spreading.material.edit_page', $value->id)}}"
                                        class="btn btn-primary">تعديل</a>
                                    <form style="display:inline" action="{{Route('spreading.material.delete')}}"
                                        method="POST">
                                        @csrf
                                        <input type="hidden" name="spreading_id" value="{{$value->id}}">
                                        <button type="submit" class="btn btn-danger">حذف</button>
                                    </form>
                                </td>
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