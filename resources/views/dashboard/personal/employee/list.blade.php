

@extends('index')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Customers Table</h3>
                <a href="{{Route('employee.create_page')}}" class="btn btn-success float-right">Add</a>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table class="table ">
                    <thead>
                        <tr class="row">
                            <div class="col-md-12">
                                <th class="col-md-1">id</th>
                                <th class="col-md-4">Name</th>
                                <th class="col-md-4">email</th>
                                <th class="col-md-3">Action</th>
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
                                        class="btn btn-primary">Edit</a>
                                    <form style="display:inline" action="{{Route('employee.delete')}}" method="POST">
                                        @csrf
                                        <input type="hidden" name="type_id" value="{{$employee->id}}">
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
                {{$types->links()}}
            </div>
        </div>
        <!-- /.card -->
    </div>
</div>
@endsection





