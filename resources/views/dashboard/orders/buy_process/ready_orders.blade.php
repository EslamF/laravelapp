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
                        <tr class="row">
                            <div class="col-md-12">
                                <th class="col-md-3">id</th>
                                <th class="col-md-3">Order Code</th>
                                <th class="col-md-3">Delivery Date</th>
                                <th class="col-md-3">Action</th>
                            </div>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $order)
                        <tr class="row">
                            <div class="col-md-12">
                                <td class="col-md-3">{{$order->id}}</td>
                                <td class="col-md-3">{{$order->bar_code}}</td>
                                <td class="col-md-3">{{$order->delivery_date}}</td>

                                <td class="col-md-3">
                                    <a href="{{Route('process.ready_order_page', $order->id)}}" class="btn btn-primary">Show</a>
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