

@extends('index')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">جدول الموظفين</h3>
                <a href="{{Route('employee.create_page')}}" class="btn btn-success float-right">انشاء</a>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table class="table ">
                    <thead>
                        <tr class="row">
                            <div class="col-md-12">
                                <th class="col-md-1">رقم</th>
                                <th class="col-md-4">اسم</th>
                                <th class="col-md-4">البريد الالكتروني</th>
                                <th class="col-md-3">امكانيه</th>
                            </div>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($types as $employee)
                        <tr class="row">
                            <div class="col-md-12">
                                <td class="col-md-1">{{$employee->id}}</td>
                                <td class="col-md-4">{{$employee->name}}</td>
                                <td class="col-md-4">{{$employee->email}}</td>
                                <td class="col-md-3">
                                    <a href="{{Route('employee.edit_page', $employee->id)}}"
                                        class="btn btn-primary">تعديل</a>
                                    <form style="display:inline" action="{{Route('employee.delete')}}" method="POST">
                                        @csrf
                                        <input type="hidden" name="type_id" value="{{$employee->id}}">
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





