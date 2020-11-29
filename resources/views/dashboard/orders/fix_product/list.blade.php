@extends('index')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card ">
            <div class="card-header">
                <h3 class="card-title">أذونات خروج المنتجات التالفة</h3>
                <a href="{{Route('fix.product.create_page')}}" class="btn btn-success float-right">انشاء</a>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table class="table ">
                    <thead>
                        <tr>
                            <th> الرقم المرجعي</th>
                            <th>كود المنتج</th>
                            <th>المصنع</th>
                            <th>الخيارات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data as $order)
                        <tr>
                            <td>{{$order->id}}</td>
                            <td>{{$order->product->prod_code}}</td>
                            <td>{{$order->factory->name}}</td>
                            <td>
                                <form style="display:inline" action="{{Route('fix.product.delete')}}"
                                    method="POST">
                                    @csrf
                                    <input type="hidden" name="id" value="{{$order->id}}">
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