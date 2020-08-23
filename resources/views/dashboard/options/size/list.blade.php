







@extends('index')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">sizes Table</h3>
                <a href="{{Route('size.create_page')}}" class="btn btn-success float-right">Add</a>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table class="table ">
                    <thead>
                        <tr class="row">
                            <div class="col-md-12">
                                <th class="col-md-1">Size id</th>
                                <th class="col-md-9">Size Name</th>
                                <th class="col-md-2">Action</th>
                            </div>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($types as $size)
                        <tr class="row">
                            <div class="col-md-12">
                                <td class="col-md-1">{{$size->id}}</td>
                                <td class="col-md-9">{{$size->name}}</td>
                                <td class="col-md-2">
                                    <a href="{{Route('size.edit_page', $size->id)}}"
                                        class="btn btn-primary">Edit</a>
                                    <form style="display:inline" action="{{Route('size.delete')}}" method="POST">
                                        @csrf
                                        <input type="hidden" name="type_id" value="{{$size->id}}">
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





