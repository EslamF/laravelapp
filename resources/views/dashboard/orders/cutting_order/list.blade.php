@extends('index')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Cutting Order Table</h3>
                <a href="{{Route('cutting.material.create_page')}}" class="btn btn-success float-right">Add</a>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table class="table ">
                    <thead>
                        <tr class="row">
                            <div class="col-md-12">
                                <th class="col-md-1">id</th>
                                <th class="col-md-2">Spreading_code</th>
                                <th class="col-md-1">Employee</th>
                                <th class="col-md-1">Layers</th>
                                <th class="col-md-2">Product Type</th>
                                <th class="col-md-1">Qty</th>
                                <th class="col-md-1">Size</th>
                                <th class="col-md-1">Returns</th>
                                <th class="col-md-2">Action</th>
                            </div>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data as $value)
                        <tr class="row">
                            <div class="col-md-12">
                                <td class="col-md-1">{{$value->id}}</td>
                                <td class="col-md-2">{{$value->spreadingOutMaterialOrder->spreading_code}}</td>
                                <td class="col-md-1">{{$value->user->name}}</td>
                                <td class="col-md-1">{{$value->layers}}</td>
                                <td class="col-md-2">{{$value->productType->name}}</td>
                                <td class="col-md-1">{{$value->qty}}</td>
                                <td class="col-md-1">{{$value->size->name}}</td>
                                <td class="col-md-1">{{$value->extra_returns_weight}}</td>
                                <td class="col-md-2">
                                    <a href="{{Route('cutting.material.edit_page', $value->id)}}"
                                        class="btn btn-primary">Edit</a>
                                    <form style="display:inline" action="{{Route('cutting.material.delete')}}"
                                        method="POST">
                                        @csrf
                                        <input type="hidden" name="cutting_order_id" value="{{$value->id}}">
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
                {{$data->links()}}
            </div>
        </div>
        <!-- /.card -->
    </div>
</div>
@endsection