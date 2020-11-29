@extends('index')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"></h3>
                <a href="{{Route('send.end_product.create_page')}}" class="btn btn-success float-right">إضافة</a>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table class="table ">
                    <thead>
                        <tr>
                            <th>الكود </th>
                            <th>كود الإذن</th>
                            <th>تاريخ الانشاء</th>
                            <th>الخيارات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $order)
                        <tr>
                            <td>{{$order->id}}</td>
                            <td>{{$order->code}}</td>
                            <td>{{$order->created_at}}</td>
                            <td>
                                <a href="{{Route('send.end_product.get_order', $order->id)}}" class="btn btn-info">إظهار</a>
                                <form style="display:inline" action="{{Route('send.end_product.delete')}}" method="POST">
                                    @csrf
                                    <input type="hidden" name="save_order_id" value="{{$order->id}}">
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
                {{$orders->links()}}
            </div>
        </div>
        <!-- /.card -->
    </div>
</div>
@endsection