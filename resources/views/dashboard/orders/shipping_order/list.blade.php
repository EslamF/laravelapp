@extends('index')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="row mb-3">
                    <h3 class="card-title">Shipping List</h3>
                </div>
                <a href="{{Route('shipping.create_page')}}" class="btn btn-success float-right">Add</a>
                <form action="{{Route('shipping.import_excel')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="file" name="file" value="fileupload" class="hidden" id="fileupload">
                </form>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table class="table ">
                    <thead>
                        <tr class="row">
                            <div class="col-md-12">
                                <th class="col-md-3">id</th>
                                <th class="col-md-3">Shipping Code</th>
                                <th class="col-md-3">Shipping Date</th>
                                <th class="col-md-3">Action</th>
                            </div>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $order)
                        <tr class="row">
                            <div class="col-md-12">
                                <td class="col-md-3">{{$order->id}}</td>
                                <td class="col-md-3">{{$order->shipping_code}}</td>
                                <td class="col-md-3">{{$order->shipping_date}}</td>

                                <td class="col-md-3">
                                    <a href="{{Route('shipping.get', $order->id)}}" class="btn btn-primary">Show</a>
                                    <form style="display:inline" action="{{Route('delete_shipping_order')}}" method="POST">
                                        @csrf
                                        <input type="hidden" name="id" value="{{$order->id}}">
                                        <button type="submit" class="btn btn-danger">Delete</button>
                                    </form>
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