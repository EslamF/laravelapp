@extends('index')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card ">
            <div class="card-header">
                <h3 class="card-title">  اذونات الإستلام</h3>
                <a href="{{Route('receiving.product.create')}}" class="btn btn-success float-right">انشاء اذن إستلام</a>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table class="table ">
                    <thead>
                        <tr>
                            <th> الرقم المرجعي</th>
                            <th>إذن اتصنيع</th>
                            <th>تاريخ الإستلام</th>
                            <th>حالة الإذن</th>
                            <th>الالخيارات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data as $value)
                        <tr>
                            <td>{{$value->id}}</td>
                            <td>{{$value->produce_order_id}}</td>
                            <td>{{substr($value->created_at,0,10)}}</td>
                            <td>{{$value->status == 1 ? "Approved":"Not Approved"}}</td>
                            <td>
                                <form style="display:inline" action="{{Route('receiving.product.delete')}}" method="POST">
                                    @csrf
                                    <input type="hidden" name="receiving_id" value="{{$value->id}}">
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