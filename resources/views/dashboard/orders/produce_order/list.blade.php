@extends('index')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card ">
            <div class="card-header">
                <h3 class="card-title">  اذونات التصنيع</h3>
                <a href="{{Route('produce.order.create')}}" class="btn btn-success float-right">إضافة</a>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table class="table ">
                    <thead>
                        <tr>
                            <th> الرقم المرجعي</th>
                            <th> الرقم المرجعي إذن القص</th>
                            <th>المصنع</th>
                            <th>تاريخ الإستلام</th>
                            <th>الخيارات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data as $value)
                        <tr>
                            <td>{{$value->id}}</td>
                            <td>{{$value->cuttingOrder->id}}</td>
                            <td>{{$value->factory->name}}</td>
                            <td>{{$value->receiving_date}}</td>
                            <td>
                                <a href="{{Route('produce.order.edit_page', $value->id)}}" class="btn btn-primary">تعديل</a>
                                <form style="display:inline" action="{{Route('produce.order.delete')}}" method="POST">
                                    @csrf
                                    <input type="hidden" name="produce_id" value="{{$value->id}}">
                                    <button type="submit" class="btn btn-danger">حذف</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
            <div class="card-footer clearfix">
                {{$data->links()}}
            </div>
        </div>
        <!-- /.card -->
    </div>
</div>
@endsection