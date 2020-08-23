

@extends('index')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">جدول المصانع المسجله</h3>
                <a href="{{Route('factory.create_page')}}" class="btn btn-success float-right">انشاء مصنع جديد</a>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table class="table ">
                    <thead>
                        <tr class="row">
                            <div class="col-md-12">
                                <th class="col-md-1">رقم</th>
                                <th class="col-md-3">اسم</th>
                                <th class="col-md-2">تيليفون</th>
                                <th class="col-md-2">عنوان</th>
                                <th class="col-md-2">نوع</th>
                                <th class="col-md-2">امكانيه</th>
                            </div>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($factories as $factory)
                        <tr class="row">
                            <div class="col-md-12">
                                <td class="col-md-1">{{$factory->id}}</td>
                                <td class="col-md-3">{{$factory->name}}</td>
                                <td class="col-md-2">{{$factory->phone}}</td>
                                <td class="col-md-2">{{$factory->address}}</td>
                                <td class="col-md-2">{{$factory->factory_type_id}}</td>
                                <td class="col-md-2">
                                    <a href="{{Route('factory.edit_page', $factory->id)}}"
                                        class="btn btn-primary">تعديل</a>
                                    <form style="display:inline" action="{{Route('factory.delete')}}" method="POST">
                                        @csrf
                                        <input type="hidden" name="factory_type_id" value="{{$factory->id}}">
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
                {{$factories->links()}}
            </div>
        </div>
        <!-- /.card -->
    </div>
</div>
@endsection





