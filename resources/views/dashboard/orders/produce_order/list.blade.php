@extends('index')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card ">
            <div class="card-header">
                <h3 class="card-title">جدول اذونات التصنيع</h3>
                <a href="{{Route('produce.order.create')}}" class="btn btn-success float-right">Add</a>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table class="table ">
                    <thead>
                        <tr class="row">
                            <div class="col-md-12">
                                <th class="col-md-1">رقم</th>
                                <th class="col-md-2">رقم اذن القص</th>
                                <th class="col-md-1">كود الخامه</th>
                                <th class="col-md-2">المصنع</th>
                                <th class="col-md-1">الكميه</th>
                                <th class="col-md-2">تاريخ الاستلام</th>
                                <th class="col-md-3">المكانيه</th>
                            </div>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data as $value)
                        <tr class="row">
                            <div class="col-md-12">
                                <td class="col-md-1">{{$value->id}}</td>
                                <td class="col-md-2">{{$value->cuttingOrder->id}}</td>
                                <td class="col-md-1">{{$value->material->mq_r_code}}</td>
                                <td class="col-md-2">{{$value->factory->name}}</td>
                                <td class="col-md-1">{{$value->qty}}</td>
                                <td class="col-md-2">{{$value->receiving_date}}</td>
                                <td class="col-md-3">
                                    <a href="{{Route('produce.order.edit_page', $value->id)}}"
                                        class="btn">التعديل</a>
                                    <form style="display:inline" action="{{Route('produce.order.delete')}}"
                                        method="POST">
                                        @csrf
                                        <input type="hidden" name="produce_id" value="{{$value->id}}">
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
                {{$data->links()}}
            </div>
        </div>
        <!-- /.card -->
    </div>
</div>
@endsection 