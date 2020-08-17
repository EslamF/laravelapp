@extends('index')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Edit Cutting Material Order</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form role="form" action="{{Route('cutting.material.update')}}" method="POST">
                @csrf
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="user">Employee</label>
                                <select class="form-control" name="user_id" id="user">
                                    <option value="" disabled selected>Select Employee</option>
                                    @foreach($data['users'] as $user)
                                    <option value="{{$user->id}}"
                                        {{$data['records']->user_id == $user->id? 'selected':''}}>{{$user->name}}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="mq_r_code">Product Type</label>
                                <select class="form-control" name="product_type_id" id="user">
                                    <option value="" disabled selected>Select Product Type</option>
                                    @foreach($data['productTypes'] as $type)
                                    <option value="{{$type->id}}"
                                        {{$data['records']->product_type_id == $type->id ? 'selected' : ''}}>
                                        {{$type->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="mq_r_code">Size</label>
                                <select class="form-control" name="size_id" id="user">
                                    <option value="" disabled selected>Select Product Size</option>
                                    @foreach($data['sizes'] as $size)
                                    <option value="{{$size->id}}"
                                        {{$data['records']->size_id == $size->id? "selected":''}}>{{$size->name}}
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
                                <label for="weight">Layers</label>
                                <input type="number" class="form-control" value="{{$data['records']->layers}}"
                                    name="layers" id="weight" placeholder="Add Layers Count">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="weight">Extra Returns</label>
                                <input type="number" class="form-control"
                                    value="{{$data['records']->extra_returns_weight}}" name="extra_returns_weight"
                                    id="weight" placeholder="Add Returns Weight">
                                <input type="hidden" name="cutting_order_id" value="{{$data['records']->id}}">
                            </div>
                        </div>
                    </div>
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