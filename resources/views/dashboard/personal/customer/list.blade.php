

@extends('index')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">جدول العملاء</h3>
                <a href="{{Route('customer.create_page')}}" class="btn btn-success float-right">اضافه عميل</a>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table class="table ">
                    <thead>
                        <tr class="row">
                            <div class="col-md-12">
                                <th class="col-md-1">رقم</th>
                                <th class="col-md-2">الاسم</th>
                                <th class="col-md-1">رقم الهاتف</th>
                                <th class="col-md-2">العنوان</th>
                                <th class="col-md-1">المصدر</th>
                                <th class="col-md-1">الوصول</th>
                                <th class="col-md-1">الصفه</th>
                                <th class="col-md-3">امكانيه</th>
                            </div>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($customers as $customer)
                        <tr class="row">
                            <div class="col-md-12">
                                <td class="col-md-1">{{$customer->id}}</td>
                                <td class="col-md-2">{{$customer->name}}</td>
                                <td class="col-md-1">{{$customer->phone}}</td>
                                <td class="col-md-2">{{$customer->address}}</td>
                                <td class="col-md-1">{{$customer->source}}</td>
                                <td class="col-md-1">{{$customer->link}}</td>
                                <td class="col-md-1">{{$customer->type}}</td>
                                <td class="col-md-3">
                                    <a href="{{Route('customer.edit_page', $customer->id)}}"
                                        class="btn btn-primary">Edit</a>
                                    <form style="display:inline" action="{{Route('customer.delete')}}" method="POST">
                                        @csrf
                                        <input type="hidden" name="customer_id" value="{{$customer->id}}">
                                        <button type="submit" class="btn btn-danger">Delete</button>
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
                {{$customers->links()}}
            </div>
        </div>
        <!-- /.card -->
    </div>
</div>
@endsection





