@extends('index')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Sort Order Table</h3>
                <a href="{{Route('sort.order.create_page')}}" class="btn btn-success float-right">Add</a>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table class="table ">
                    <thead>
                        <tr class="row">
                            <div class="col-md-12">
                                <th class="col-md-1">id</th>
                                <th class="col-md-2">Code</th>
                                <th class="col-md-2">Empolyee</th>
                                <th class="col-md-4">Date</th>
                                <th class="col-md-3">Action</th>
                            </div>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $order)
                        <tr class="row">
                            <div class="col-md-12">
                                <td class="col-md-1">{{$order->id}}</td>
                                <td class="col-md-2">{{$order->code}}</td>
                                <td class="col-md-2">{{$order->user->name}}</td>
                                <td class="col-md-4">{{$order->created_at}}</td>
                                <td class="col-md-3">
                                    <a href="{{Route('sort.product.list', $order->id)}}"
                                            class="btn btn-info">Show</a>
                                    <a href="{{Route('sort.order.edit_page', $order->id)}}"
                                        class="btn btn-primary">Edit</a>
                                    <form style="display:inline" action="{{Route('sort.order.delete')}}"
                                        method="POST">
                                        @csrf
                                        <input type="hidden" name="sort_id" value="{{$order->id}}">
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