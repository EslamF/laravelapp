@extends('index')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Edit Produce Order</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <ul>
                @foreach($errors as $error)
                <li>{{$error}}</li>
                @endforeach
            </ul>
            <form role="form" action="{{Route('produce.order.update')}}" method="POST">
                @csrf
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="factory">Factory</label>
                                <select class="form-control" name="factory_id" id="factory">
                                    <option value="" disabled selected>Select Factory</option>
                                    @foreach($data['factories'] as $factory)
                                    <option value="{{$factory->id}}"
                                        {{$data['records']->factory_id == $factory->id?'selected':''}}>
                                        {{$factory->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="mq_r_code">Cutting Order</label>
                                <select class="form-control" name="cutting_order_id" id="user">
                                    <option value="" disabled selected>Select Order id</option>
                                    @foreach($data['cutting_orders'] as $order)
                                    <option value="{{$order->id}}"
                                        {{$data['records']->cutting_order_id == $order->id?'selected':''}}>
                                        {{$order->id}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="material">Materials</label>
                                <select class="form-control" name="material_id" id="material">
                                    <option value="" disabled selected>Select Material</option>
                                    @foreach($data['materials'] as $material)
                                    <option value="{{$material->id}}"
                                        {{$data['records']->material_id == $material->id?'selected':''}}>
                                        {{$material->mq_r_code}}</option>
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
                                <label for="weight">Receiving Date</label>
                                <input type="date" class="form-control" name="receiving_date"
                                    value="{{$data['records']->receiving_date}}" id="weight"
                                    placeholder="Add Receiving Date">
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="produce_id" value="{{$data['records']->id}}">
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Edit</button>
                    <a href="{{url()->previous()}}" class="btn btn-info">Back</a>
                </div>
            </form>
        </div>
    </div>
</div>
</div>
@endsection