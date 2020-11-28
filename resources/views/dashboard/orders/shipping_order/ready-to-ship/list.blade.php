@extends('index')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Ready Order</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table class="table ">
                    <thead>
                        <tr>
                            <th>id</th>
                            <th>Shipping Code</th>
                            <th>Shipping Date</th>
                            <th>Shipping Company</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $order)
                        <tr>
                            <td>{{$order->id}}</td>
                            <td>{{$order->shipping_code}}</td>
                            <td>{{$order->shipping_date}}</td>
                            <td>{{$order->shippingCompany->name}}</td>

                            <td>
                                <a href="{{Route('shipping.create_package_page',$order->id)}}" class="btn btn-primary">show</a>
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