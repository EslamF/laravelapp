@extends('index')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card ">
            <div class="card-header">
                <h3 class="card-title"> اذونات القص</h3>
                <a href="{{Route('cutting.outer_list')}}" class="btn btn-dark mr-2 float-right"> رجوع</a>
                <a href="{{Route('cutting.material.create_page')}}" class="btn btn-success float-right"> انشاء</a>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table class="table ">
                    <thead>
                        <tr class="row">
                            <div class="col-md-12">
                                <th class="col-md-2"> الرقم المرجعي</th>
                                <th class="col-md-2">الشركة</th>
                                <th class="col-md-3">كود الخامة</th>
                                <th class="col-md-2">موظف الفرش</th>
                                <th class="col-md-3">إجراءات</th>
                            </div>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data as $value)
                        <tr class="row">
                            <div class="col-md-12">
                                <td class="col-md-2">{{$value->id}}</td>
                                <td class="col-md-2">{{$value->factory ? $value->factory->name: 'غير متاح'}}</td>
                                <td class="col-md-3">{{$value->spreadingOutMaterialOrder->material->mq_r_code}}</td>
                                <td class="col-md-2">{{$value->spreadingOutMaterialOrder->user->name}}</td>
                                <td class="col-md-3">
                                    <a href="{{Route('cutting_order.show_products', $value->id)}}" class="btn btn-primary">Show</a>
                                    <form style="display:inline" action="{{Route('cutting.material.delete')}}" method="POST">
                                        @csrf
                                        <input type="hidden" name="cutting_order_id" value="{{$value->id}}">
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