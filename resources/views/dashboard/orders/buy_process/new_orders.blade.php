@extends('index')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">New Orders Table</h3>
                <a href="{{Route('process.get_list')}}" class="btn btn-dark float-right">Back</a>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table class="table ">
                    <thead>
                        <tr>
                            <th>id</th>
                            <th>Order Code</th>
                            <th>Confimation</th>
                            <th>Delivery date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $value)
                        <tr>
                            <td>{{$value->id}}</td>
                            <td>{{$value->bar_code}}</td>
                            <td>{{$value->confirmation}}</td>
                            <td>{{$value->delivery_date}}</td>
                            <td>
                                <a href="{{Route('process.prepare_order_page', $value->id)}}" class="btn btn-primary">Preparation</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
            <div class="card-footer clearfix">
                <div class="offset-5">

                    {{$orders->links()}}
                </div>
            </div>
        </div>
        <!-- /.card -->
    </div>
</div>
@endsection