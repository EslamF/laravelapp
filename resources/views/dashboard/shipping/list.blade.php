@extends('index')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">شركات الشحن </h3>
                <a href="{{Route('shipping.create_page')}}" class="btn btn-success float-right">اضافه</a>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table class="table ">
                    <thead>
                        <tr class="row">
                            <div class="col-md-12">
                                <th class="col-md-1"> الرقم المرجعي</th>
                                <th class="col-md-8">اسم الشركه</th>
                                <th class="col-md-3">الخيارات</th>
                            </div>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($types as $shipping)
                        <tr class="row">
                            <div class="col-md-12">
                                <td class="col-md-1">{{$shipping->id}}</td>
                                <td class="col-md-8">{{$shipping->name}}</td>
                                <td class="col-md-2">
                                    <a href="{{Route('shipping.edit_page', $shipping->id)}}" class="btn btn-primary">تعديل</a>
                                    <form style="display:inline" action="{{Route('shipping.delete')}}" method="POST">
                                        @csrf
                                        <input type="hidden" name="type_id" value="{{$shipping->id}}">
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
                {{$types->links()}}
            </div>
        </div>
        <!-- /.card -->
    </div>
</div>
@endsection