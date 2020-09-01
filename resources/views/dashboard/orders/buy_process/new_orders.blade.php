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
                        <tr class="row">
                            <div class="col-md-12">
                                <th class="col-md-1">id</th>
                                <th class="col-md-3">Order Code</th>
                                <th class="col-md-3">Confimation</th>
                                <th class="col-md-3">Delivery date</th>
                                <th class="col-md-2">Action</th>
                            </div>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $value)
                        <tr class="row">
                            <div class="col-md-12">
                                <td class="col-md-1">{{$value->id}}</td>
                                <td class="col-md-3">{{$value->bar_code}}</td>
                                <td class="col-md-3">{{$value->confirmation}}</td>
                                <td class="col-md-3">{{$value->delivery_date}}</td>
                                <td class="col-md-2">
                                    <a href="{{Route('process.prepare_order_page', $value->id)}}" class="btn btn-primary">Preparation</a>
                                </td>
                            </div>
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