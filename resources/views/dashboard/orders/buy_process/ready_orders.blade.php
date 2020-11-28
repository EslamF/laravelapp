@extends('index')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Prepared orders</h3>
                <a href="{{Route('process.get_list')}}" class="btn btn-dark float-right">Back</a>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table class="table ">
                    <thead>
                        <tr>
                            <th>id</th>
                            <th>Order Code</th>
                            <th>Delivery Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $order)
                        <tr>
                            <td>{{$order->id}}</td>
                            <td>{{$order->bar_code}}</td>
                            <td>{{$order->delivery_date}}</td>

                            <td>
                                <a href="{{Route('process.ready_order_page', $order->id)}}" class="btn btn-primary">Show</a>
                            </td>
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