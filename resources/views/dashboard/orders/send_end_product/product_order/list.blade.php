@extends('index')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">إذن تخزين</h3>
                <a href="{{url()->previous()}}" class="btn btn-info float-right">رجوع</a>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <h3 style="display: block;">Shipped by <span> {{$order->user ? $order->user->name : ''}} </span></h3>
                    <h3 style="display: block;">Code <span> {{$order->code}}</span></h3>
                    <table class="table ">
                        <thead>
                            <tr>
                                <th>كود المنتج</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach($products as $product)
                            <tr>
                                <td>{{$product->prod_code}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
            </div>
            <!-- /.card-body -->
            <div class="card-footer clearfix">
                {{$products->links()}}
            </div>
        </div>
        <!-- /.card -->
    </div>
</div>
@endsection