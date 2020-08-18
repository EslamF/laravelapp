@extends('index')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Product Table</h3>
                <a href="{{Route('product.create_page')}}" class="btn btn-success float-right">Add</a>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table class="table ">
                    <thead>
                        <tr class="row">
                            <div class="col-md-12">
                                <th class="col-md-1">id</th>
                                <th class="col-md-2">Product Code</th>
                                <th class="col-md-2">Receiving Order id</th>
                                <th class="col-md-2">Damaged</th>
                                <th class="col-md-1">Sorted</th>
                                <th class="col-md-2">Status</th>
                                <th class="col-md-2">Action</th>
                            </div>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($products as $value)
                        <tr class="row">
                            <div class="col-md-12">
                                <td class="col-md-1">{{$value->id}}</td>
                                <td class="col-md-2">{{$value->prod_code}}</td>
                                <td class="col-md-2">{{$value->receiving_order_id}}</td>
                                <td class="col-md-2">{{$value->damaged == 1 ? 'True': 'False'}}</td>
                                <td class="col-md-1">{{$value->sorted == 1 ? 'True' : 'False'}}</td>
                                <td class="col-md-2">{{$value->status}}</td>
                                <td class="col-md-2">
                                    <a href="{{Route('product.edit_page', $value->id)}}"
                                        class="btn btn-primary">Edit</a>
                                    <form style="display:inline" action="{{Route('product.delete')}}"
                                        method="POST">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{$value->id}}">
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
                {{$products->links()}}
            </div>
        </div>
        <!-- /.card -->
    </div>
</div>
@endsection