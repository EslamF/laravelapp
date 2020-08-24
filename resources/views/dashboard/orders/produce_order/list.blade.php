@extends('index')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Produce Order Table</h3>
                <a href="{{Route('produce.order.create')}}" class="btn btn-success float-right">Add</a>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table class="table ">
                    <thead>
                        <tr class="row">
                            <div class="col-md-12">
                                <th class="col-md-1">id</th>
                                <th class="col-md-2">Cutting Order ID</th>
                                <th class="col-md-3">Factory</th>
                                <th class="col-md-3">Receiving Date</th>
                                <th class="col-md-3">Action</th>
                            </div>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data as $value)
                        <tr class="row">
                            <div class="col-md-12">
                                <td class="col-md-1">{{$value->id}}</td>
                                <td class="col-md-2">{{$value->cuttingOrder->id}}</td>
                                <td class="col-md-3">{{$value->factory->name}}</td>
                                <td class="col-md-3">{{$value->receiving_date}}</td>
                                <td class="col-md-3">
                                    <a href="{{Route('produce.order.edit_page', $value->id)}}" class="btn btn-primary">Edit</a>
                                    <form style="display:inline" action="{{Route('produce.order.delete')}}" method="POST">
                                        @csrf
                                        <input type="hidden" name="produce_id" value="{{$value->id}}">
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