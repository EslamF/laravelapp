@extends('index')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Add Receiving Products Order</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <ul>
                @foreach($errors as $error)
                <li>{{$error}}</li>
                @endforeach
            </ul>
            <form role="form" action="{{Route('receiving.product.store')}}" method="POST">
                @csrf
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="factory">Produce Order</label>
                                <select class="form-control" name="produce_order_id" id="factory">
                                    <option value="" disabled selected>Select Produce Order</option>
                                    @foreach($data['produce_orders'] as $order)
                                    <option value="{{$order->id}}">{{$order->id}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="mq_r_code">Product</label>
                                <select class="form-control" name="product_type_id" id="user">
                                    <option value="" disabled selected>Select Product Type</option>
                                    @foreach($data['product_types'] as $type)
                                    <option value="{{$type->id}}">{{$type->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="material">Size</label>
                                <select class="form-control" name="size_id" id="material">
                                    <option value="" disabled selected>Select Size</option>
                                    @foreach($data['sizes'] as $size)
                                    <option value="{{$size->id}}">{{$size->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="weight">Qty</label>
                                <input type="number" class="form-control" name="qty" id="weight" placeholder="Add Qty">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="weight">Order Status</label>
                                <select class="form-control" name="status" id="material">
                                    <option value="" disabled selected>Chose Status</option>
                                    <option value="1">Approved</option>
                                    <option value="0">Not Approved</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="weight">Receiving Date</label>
                                <input type="date" class="form-control" name="receiving_date" id="weight" placeholder="Add Receiving Date">
                            </div>
                        </div>
                    </div>

                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <a href="{{url()->previous()}}" class="btn btn-info">Back</a>
                </div>
            </form>
        </div>
    </div>
</div>
</div>
@endsection