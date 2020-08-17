@extends('index')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Receiving Product Table</h3>
                <a href="{{Route('receiving.product.create')}}" class="btn btn-success float-right">Add</a>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table class="table ">
                    <thead>
                        <tr class="row">
                            <div class="col-md-12">
                                <th class="col-md-1">id</th>
                                <th class="col-md-1">Produce Order</th>
                                <th class="col-md-2">Product</th>
                                <th class="col-md-1">Size</th>
                                <th class="col-md-1">Qty</th>
                                <th class="col-md-3">Receiving Date</th>
                                <th class="col-md-1">Status</th>
                                <th class="col-md-2">Action</th>
                            </div>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data as $value)
                        <tr class="row">
                            <div class="col-md-12">
                                <td class="col-md-1">{{$value->id}}</td>
                                <td class="col-md-1">{{$value->produce_order_id}}</td>
                                <td class="col-md-2">{{$value->productType->name}}</td>
                                <td class="col-md-1">{{$value->size->name}}</td>
                                <td class="col-md-1">{{$value->qty}}</td>
                                <td class="col-md-3">{{$value->receiving_date}}</td>
                                <td class="col-md-1">{{$value->status == 1 ? "Approved":"Not Approved"}}</td>
                                <td class="col-md-2">
                                    <a href="{{Route('receiving.product.edit_page', $value->id)}}"
                                        class="btn btn-primary">Edit</a>
                                    <form style="display:inline" action="{{Route('receiving.product.delete')}}"
                                        method="POST">
                                        @csrf
                                        <input type="hidden" name="receiving_id" value="{{$value->id}}">
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