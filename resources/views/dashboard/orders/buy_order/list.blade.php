@extends('index')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Buy Order Table</h3>
                <a href="{{Route('buy.create_page')}}" class="btn btn-success float-right">Add</a>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table class="table ">
                    <thead>
                        <tr class="row">
                            <div class="col-md-12">
                                <th class="col-md-1">id</th>
                                <th class="col-md-2">Order Number</th>
                                <th class="col-md-1">order status</th>
                                <th class="col-md-1">Customer Name</th>
                                <th class="col-md-2">Date to Deliver</th>
                                <th class="col-md-2">Deliver Status</th>
                                <th class="col-md-1">Price</th>
                                <th class="col-md-2">Action</th>
                            </div>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data as $value)
                        <tr class="row">
                            <div>
                                <td class="col-md-1">{{$value->id}}</td>
                                <td class="col-md-2">{{$value->bar_code}}</td>
                                <td class="col-md-1">{{$value->stauts == 0 ? 'waiting': 'Ready to '}}</td>
                                <td class="col-md-1">{{$value->customer->name}}</td>
                                <th class="col-md-2">{{$value->delivery_date}}</th>
                                <th class="col-md-2">{{$value->productStatus() ? 'Ready To Deliver' : 'Waiting for Products'}}</th>
                                <th class="col-md-1">{{$value->orderTotal()}}</th>
                                <td class="col-md-2">
                                    <a href="{{Route('buy.show_order', $value->id)}}" class="btn btn-primary">Show</a>
                                    <form style="display:inline" action="{{Route('buy.delete_order')}}" method="POST">
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
                {{$data->links()}}
            </div>
        </div>
        <!-- /.card -->
    </div>
</div>
@endsection