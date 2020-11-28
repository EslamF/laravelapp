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
                        <tr>
                            <th> الرقم المرجعي</th>
                            <th>الإسم</th>
                            <th>البريد الالكتروني</th>
                            <th>صلاحية الموظف</th>
                            <th>الخيارات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data['user'] as $employee)
                        <tr>
                            <td>{{$employee->id}}</td>
                            <td>{{$employee->name}}</td>
                            <td>{{$employee->email}}</td>
                            <td>{{isset($employee->roles[0]->label) ? $employee->roles[0]->label: "لا يوجد لة صلاحية" }}</td>
                            <td>
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