@extends('index')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Cutting Order Product Table</h3>
                <a href="{{Route('cutting_order.add_page', $cutting_order->id)}}" class="btn btn-success float-right">Add</a>
            </div>
            <h4 class="ml-3 mt-2">{{$cutting_order->factory ?'Company '. $cutting_order->factory->name: 'Employee '.$cutting_order->user->name}}</h3>
                <!-- /.card-header -->
                <div class="card-body">
                    <table class="table ">
                        <thead>
                            <tr class="row">
                                <div class="col-md-12">
                                    <th class="col-md-2">id</th>
                                    <th class="col-md-4">Product Name</th>
                                    <th class="col-md-3">Prodcut Size</th>
                                    <th class="col-md-1">Qty</th>
                                    <th class="col-md-2">Action</th>
                                </div>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($orders as $value)
                            <tr class="row">
                                <div class="col-md-12">
                                    <td class="col-md-2">{{$value->id}}</td>
                                    <td class="col-md-4">{{$value->productType->name}}</td>
                                    <td class="col-md-3">{{$value->size->name}}</td>
                                    <td class="col-md-1">{{$value->qty}}</td>
                                    <td class="col-md-2">
                                        <form style="display:inline" action="{{Route('cutting.delete_product')}}" method="POST">
                                            @csrf
                                            <input type="hidden" name="id" value="{{$value->id}}">
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
                    {{$orders->links()}}
                </div>
        </div>
        <!-- /.card -->
    </div>
</div>
@endsection