

@extends('index')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Factories Table</h3>
                <a href="{{Route('factory.create_page')}}" class="btn btn-success float-right">Add</a>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table class="table ">
                    <thead>
                        <tr class="row">
                            <div class="col-md-12">
                                <th class="col-md-1">id</th>
                                <th class="col-md-3">Name</th>
                                <th class="col-md-2">Phone</th>
                                <th class="col-md-2">Address</th>
                                <th class="col-md-2">FactoryType</th>
                                <th class="col-md-2">Action</th>
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
                                        class="btn btn-primary">Edit</a>
                                    <form style="display:inline" action="{{Route('factory.delete')}}" method="POST">
                                        @csrf
                                        <input type="hidden" name="factory_type_id" value="{{$factory->id}}">
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
                {{$factories->links()}}
            </div>
        </div>
        <!-- /.card -->
    </div>
</div>
@endsection





