@extends('index')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Done Orders Table</h3>
                <a href="{{Route('process.get_list')}}" class="btn btn-dark float-right">Back</a>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table class="table ">
                    <thead>
                        <tr class="row">
                            <div class="col-md-12">
                                <th class="col-md-4">Bar Code</th>
                                <th class="col-md-6">Delivery Date</th>
                                <th class="col-md-2">Action</th>
                            </div>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $order)
                        <tr class="row">
                            <div class="col-md-12">
                                <td class="col-md-4">{{$order->bar_code}}</td>
                                <td class="col-md-6">{{$order->delivery_date}}</td>
                                <td class="col-md-2">
                                    <a href="{{Route('process.done_order_page', $order->id)}}" class="btn btn-primary">Show</a>
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