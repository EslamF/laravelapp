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
                        <tr class="row">
                            <div class="col-md-12">
                                <th class="col-md-1">id</th>
                                <th class="col-md-2">Shipping Code</th>
                                <th class="col-md-3">Shipping Date</th>
                                <th class="col-md-3">Shipping Company</th>
                                <th class="col-md-3">Action</th>
                            </div>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $order)
                        <tr class="row">
                            <div class="col-md-12">
                                <td class="col-md-1">{{$order->id}}</td>
                                <td class="col-md-2">{{$order->shipping_code}}</td>
                                <td class="col-md-3">{{$order->shipping_date}}</td>
                                <td class="col-md-3">{{$order->shippingCompany->name}}</td>

                                <td class="col-md-3">
                                    <a href="{{Route('shipping.create_package_page',$order->id)}}" class="btn btn-primary">show</a>
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