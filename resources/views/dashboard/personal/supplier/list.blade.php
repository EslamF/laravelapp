

@extends('index')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Suppliers Table</h3>
                <a href="{{Route('supplier.create_page')}}" class="btn btn-success float-right">Add</a>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table class="table ">
                    <thead>
                        <tr class="row">
                            <div class="col-md-12">
                                <th class="col-md-2">Supplire id</th>
                                <th class="col-md-4">Supplire Name</th>
                                <th class="col-md-6">Action</th>
                            </div>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($suppliers as $supplier)
                        <tr class="row">
                            <div class="col-md-12">
                                <td class="col-md-2">{{$supplier->id}}</td>
                                <td class="col-md-4">{{$supplier->name}}</td>
                                <td class="col-md-6">
                                    <a href="{{Route('supplier.edit_page', $supplier->id)}}"
                                        class="btn btn-primary">Edit</a>
                                    <form style="display:inline" action="{{Route('supplier.delete')}}" method="POST">
                                        @csrf
                                        <input type="hidden" name="supplier_id" value="{{$supplier->id}}">
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
                {{$suppliers->links()}}
            </div>
        </div>
        <!-- /.card -->
    </div>
</div>
@endsection





