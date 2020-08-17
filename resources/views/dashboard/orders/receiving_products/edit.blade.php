@extends('index')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Edit Receiving Products Order</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <ul>
                @foreach($errors as $error)
                <li>{{$error}}</li>
                @endforeach
            </ul>
            <form role="form" action="{{Route('receiving.product.update')}}" method="POST">
                @csrf
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="factory">Produce Order</label>
                                <select class="form-control" name="produce_order_id" id="factory">
                                    <option value="" disabled selected>Select Produce Order</option>
                                    @foreach($data['produce_orders'] as $order)
                                    <option value="{{$order->id}}"
                                        {{$data['records']->produce_order_id == $order->id ? "selected":''}}>
                                        {{$order->id}}</option>
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
                                    <option value="{{$type->id}}"
                                        {{$data['records']->product_type_id == $type->id ? "selected":''}}>{{$type->id}}
                                    </option>
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
                                    <option value="{{$size->id}}"
                                        {{$data['records']->size_id == $size->id ? "selected":''}}>{{$size->name}}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="weight">Qty</label>
                                <input type="number" class="form-control" value="{{$data['records']->qty}}" name="qty"
                                    id="weight" placeholder="Add Qty">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="weight">Order Status</label>
                                <select class="form-control" name="status" id="material">
                                    <option value="" disabled selected>Chose Status</option>
                                    <option value="1" {{$data['records']->status == 1 ? "selected":''}}>Approved
                                    </option>
                                    <option value="0" {{$data['records']->status == 0 ? "selected":''}}>Not Approved
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="weight">Receiving Date</label>
                                <input type="date" class="form-control" value="{{$data['records']->receiving_date}}"
                                    name="receiving_date" id="weight" placeholder="Add Receiving Date">
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="receiving_id" value="{{$data['records']->id}}">
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