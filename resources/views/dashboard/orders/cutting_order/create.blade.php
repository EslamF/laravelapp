@extends('index')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Add Cutting Material Order</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form role="form" action="{{Route('cutting.material.store')}}" method="POST">
                @csrf
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="user">Employee</label>
                                <select class="form-control" name="user_id" id="user">
                                    <option value="" disabled selected>Select Employee</option>
                                    @foreach($data['users'] as $user)
                                    <option value="{{$user->id}}">{{$user->name}}</option>
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
                                    <option value="{{$type->id}}">{{$type->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="mq_r_code">Spreading Code</label>
                                <select class="form-control" name="spreading_out_material_order_id" id="user">
                                    <option value="" disabled selected>Select Spreading Code</option>
                                    @foreach($data['spreading_codes'] as $spreading)
                                    <option value="{{$spreading->id}}">{{$spreading->spreading_code}}</option>
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
                                <label for="weight">Layers</label>
                                <input type="number" class="form-control" name="layers" id="weight"
                                    placeholder="Add Layers Count">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="weight">Extra Returns</label>
                                <input type="number" class="form-control" name="extra_returns_weight" id="weight"
                                    placeholder="Add Returns Weight">
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