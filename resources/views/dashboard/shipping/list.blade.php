

@extends('index')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Shippings Table</h3>
                <a href="{{Route('shipping.create_page')}}" class="btn btn-success float-right">Add</a>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table class="table ">
                    <thead>
                        <tr class="row">
                            <div class="col-md-12">
                                <th class="col-md-2">Shipping id</th>
                                <th class="col-md-8">Shipping Name</th>
                                <th class="col-md-2">Action</th>
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
                                    <a href="{{Route('shipping.edit_page', $shipping->id)}}"
                                        class="btn btn-primary">Edit</a>
                                    <form style="display:inline" action="{{Route('shipping.delete')}}" method="POST">
                                        @csrf
                                        <input type="hidden" name="type_id" value="{{$shipping->id}}">
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





