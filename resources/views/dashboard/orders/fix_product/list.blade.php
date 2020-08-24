@extends('index')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card ">
            <div class="card-header">
                <h3 class="card-title">جدول اذونات المنتجات التالفه</h3>
                <a href="{{Route('fix.product.create_page')}}" class="btn btn-success float-right">انشاء</a>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table class="table ">
                    <thead>
                        <tr class="row">
                            <div class="col-md-12">
                                <th class="col-md-1">رقم</th>
                                <th class="col-md-5">كود المنتج</th>
                                <th class="col-md-5">المصنع</th>
                                <th class="col-md-1">الامكانيه</th>
                            </div>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data as $order)
                        <tr class="row">
                            <div class="col-md-12">
                                <td class="col-md-1">{{$order->id}}</td>
                                <td class="col-md-5">{{$order->product->prod_code}}</td>
                                <td class="col-md-5">{{$order->factory->name}}</td>
                                <td class="col-md-1">
                                    <form style="display:inline" action="{{Route('fix.product.delete')}}"
                                        method="POST">
                                        @csrf
                                        <input type="hidden" name="id" value="{{$order->id}}">
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