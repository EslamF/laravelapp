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
                        <tr>
                            <th>id</th>
                            <th>Order Number</th>
                            <th>order status</th>
                            <th>Customer Name</th>
                            <th>Date to Deliver</th>
                            <th>Deliver Status</th>
                            <th>Price</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data as $value)
                        <tr>
                                <td>{{$value->id}}</td>
                                <td>{{$value->bar_code}}</td>
                                <td>{{$value->stauts == 0 ? 'waiting': 'Ready to '}}</td>
                                <td>{{$value->customer->name}}</td>
                                <th>{{$value->delivery_date}}</th>
                                <th>{{$value->productStatus() ? 'Ready To Deliver' : 'Waiting for Products'}}</th>
                                <th>{{$value->orderTotal()}}</th>
                                <td>
                                    <a href="{{Route('buy.show_order', $value->id)}}" class="btn btn-primary">Show</a>
                                    <form style="display:inline" action="{{Route('buy.delete_order')}}" method="POST">
                                        @csrf
                                        <input type="hidden" name="id" value="{{$value->id}}">
                                        <button type="submit" class="btn btn-danger">Delete</button>
                                    </form>
                                </td>
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