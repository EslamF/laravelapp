@extends('index')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Order To Storage</h3>
                <a href="{{url()->previous()}}" class="btn btn-info float-right">Back</a>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <h3 style="display: block;">Shipped by {{$data[0]->user->name}}</h6>
                    <table class="table ">
                        <thead>
                            <tr class="row">
                                <div class="col-md-12">
                                    <th class="col-md-12">Product code</th>
                                </div>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach($data as $order)
                            <tr class="row">
                                <div class="col-md-12">
                                    <td class="col-md-12">{{$order->prod_code}}</td>
                                </div>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
            </div>
            <!-- /.card-body -->
            <div class="card-footer clearfix">
                {{$data->links()}}
            </div>
        </div>
        <!-- /.card -->
    </div>
</div>
@endsection