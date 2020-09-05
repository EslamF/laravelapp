@extends('index')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Cutting Order Product Table</h3>
                @if($cutting_order->factory)
                <a href="{{Route('cutting_order.add_page', $cutting_order->id)}}" class="btn btn-success mr-2 float-right">اضافة</a>
                @endif
                <a href="{{Route('cutting.outer_list')}}" class="btn btn-dark float-right">رجوع</a>
            </div>
            <h4 class="ml-3 mt-2">{{$cutting_order->factory ?'Company '. $cutting_order->factory->name: 'Employee '.$cutting_order->user->name}}</h3>
                <!-- /.card-header -->
                <div class="card-body">
                    <table class="table ">
                        <thead>
                            <tr class="row">
                                <div class="col-md-12">
                                    <th class="col-md-5">Product Name</th>
                                    <th class="col-md-4">Prodcut Size</th>
                                    <th class="col-md-3">Qty</th>
                                </div>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($orders as $value)
                            <tr class="row">
                                <div class="col-md-12">
                                    <td class="col-md-5">{{$value['product_type']}}</td>
                                    <td class="col-md-4">{{$value['size']}}</td>
                                    <td class="col-md-3">{{$value['qty']}}</td>

                                </div>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
                <div class="card-footer clearfix">
                </div>
        </div>
        <!-- /.card -->
    </div>
</div>
@endsection