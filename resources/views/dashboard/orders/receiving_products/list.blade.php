@extends('index')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card ">
            <div class="card-header">
                <h3 class="card-title">جدول اذونات الاستلام</h3>
                <a href="{{Route('receiving.product.create')}}" class="btn btn-success float-right">Add</a>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table class="table ">
                    <thead>
                        <tr class="row">
                            <div class="col-md-12">
                                <th class="col-md-1">رقم</th>
                                <th class="col-md-1">اذن اتصنيع</th>
                                <th class="col-md-2">المنتج</th>
                                <th class="col-md-1">مقاس</th>
                                <th class="col-md-1">الكميه</th>
                                <th class="col-md-3">تاريخ الاستلام</th>
                                <th class="col-md-1">حاله الاذن</th>
                                <th class="col-md-2">الامكانيه</th>
                            </div>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data as $value)
                        <tr class="row">
                            <div class="col-md-12">
                                <td class="col-md-1">{{$value->id}}</td>
                                <td class="col-md-1">{{$value->produce_order_id}}</td>
                                <td class="col-md-2">{{$value->productType->name}}</td>
                                <td class="col-md-1">{{$value->size->name}}</td>
                                <td class="col-md-1">{{$value->qty}}</td>
                                <td class="col-md-3">{{$value->receiving_date}}</td>
                                <td class="col-md-1">{{$value->status == 1 ? "Approved":"Not Approved"}}</td>
                                <td class="col-md-2">
                                    <a href="{{Route('receiving.product.edit_page', $value->id)}}"
                                        class="btn btn-primary"> تعديل</a>
                                    <form style="display:inline" action="{{Route('receiving.product.delete')}}"
                                        method="POST">
                                        @csrf
                                        <input type="hidden" name="receiving_id" value="{{$value->id}}">
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