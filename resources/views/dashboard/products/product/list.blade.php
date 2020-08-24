@extends('index')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">جدول المنتجات</h3>
                <a href="{{Route('product.create_page')}}" class="btn btn-success float-right">انشاء</a>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table class="table ">
                    <thead>
                        <tr class="row">
                            <div class="col-md-12">
                                <th class="col-md-1">رقم </th>
                                <th class="col-md-2">كود المنتج</th>
                                <th class="col-md-2">كود المنتج</th>
                                <th class="col-md-2">حاله المنتج</th>
                                <th class="col-md-1">حاله الفرز</th>
                                <th class="col-md-2">الحاله البيعيه</th>
                                <th class="col-md-2">امكانيه</th>
                            </div>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($products as $value)
                        <tr class="row">
                            <div class="col-md-12">
                                <td class="col-md-1">{{$value->id}}</td>
                                <td class="col-md-2">{{$value->prod_code}}</td>
                                <td class="col-md-2">{{$value->receiving_order_id}}</td>
                                <td class="col-md-2">{{$value->damaged == 1 ? 'True': 'False'}}</td>
                                <td class="col-md-1">{{$value->sorted == 1 ? 'True' : 'False'}}</td>
                                <td class="col-md-2">{{$value->status}}</td>
                                <td class="col-md-2">
                                    <a href="{{Route('product.edit_page', $value->id)}}"
                                        class="btn btn-primary">تعديل</a>
                                    <form style="display:inline" action="{{Route('product.delete')}}"
                                        method="POST">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{$value->id}}">
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
                {{$products->links()}}
            </div>
        </div>
        <!-- /.card -->
    </div>
</div>
@endsection