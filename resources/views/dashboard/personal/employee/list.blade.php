@extends('index')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">  الموظفين</h3>
                @can('add-employee')
                <a href="{{Route('employee.create_page')}}" class="btn btn-success float-right">انشاء</a>
                @endcan
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table class="table ">
                    <thead>
                        <tr class="row">
                            <div class="col-md-12">
                                <th class="col-md-1"> الرقم المرجعي</th>
                                <th class="col-md-3">اسم</th>
                                <th class="col-md-3">البريد الالكتروني</th>
                                <th class="col-md-2">صلحية الموظف</th>
                                <th class="col-md-3">إجراءات</th>
                            </div>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data['user'] as $employee)
                        <tr class="row">
                            <div class="col-md-12">
                                <td class="col-md-1">{{$employee->id}}</td>
                                <td class="col-md-2">{{$employee->name}}</td>
                                <td class="col-md-3">{{$employee->email}}</td>
                                <td class="col-md-3">{{isset($employee->roles[0]->label) ? $employee->roles[0]->label: "لا يوجد لة صلاحية" }}</td>
                                <td class="col-md-3">
                                    @can('edit-employee')
                                    <a href="{{Route('employee.edit_page', $employee->id)}}" class="btn btn-primary">تعديل</a>
                                    @endcan
                                    @can('delete-employee')
                                    <form style="display:inline" action="{{Route('employee.delete')}}" method="POST">
                                        @csrf
                                        <input type="hidden" name="type_id" value="{{$employee->id}}">
                                        <button type="submit" class="btn btn-danger">حذف</button>
                                    </form>
                                    @endcan
                                </td>
                            </div>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
            <div class="card-footer clearfix">
                {{$data['user']->links()}}
            </div>
        </div>
        <!-- /.card -->
    </div>
</div>
@endsection