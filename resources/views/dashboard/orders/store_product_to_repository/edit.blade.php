@extends('index')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">المنتجات المخزنة </h3>
            </div>
            @include('includes.loading')
            <!-- /.card-header -->
            <div class="card-body">
                <table class="table ">
                    <thead>
                        <tr class="row">
                            <div class="col-md-12">
                                <th class="col-md-1">الكود</th>
                                <th class="col-md-8">كودالمنتج</th>
                            </div>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($saved_products as $saved_product)
                        <tr class="row">
                            <div class="col-md-12">
                                <td class="col-md-1">{{$saved_product->id}}</td>
                                <td class="col-md-8">{{$saved_product->prodact_code}}</td>
                            </div>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
            <div class="card-footer clearfix">
                {{$saved_products->links()}}
            </div>
        </div>
        <!-- /.card -->
    </div>
</div>
@endsection