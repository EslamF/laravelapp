@extends('index')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Edit Receiving Material Order</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form role="form" action="{{Route('receiving.material.update')}}" method="POST">
                @csrf
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">

                            <div class="form-group">
                                <label for="code">Code</label>
                                <input type="text" class="form-control" name="code" value="{{$data['material']->code}}"
                                    id="code" placeholder="Add code">
                            </div>
                        </div>
                        <div class="col-md-6">

                            <div class="form-group">
                                <label for="mq_r_code">MQ_R_Code</label>
                                <input type="text" class="form-control" value="{{$data['material']->mq_r_code}}"
                                    name="mq_r_code" id="mq_r_code" placeholder="Add MQ_R_Code">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">

                            <div class="form-group">
                                <label for="user">Receivied By</label>
                                <select class="form-control" name="user_id" id="user">
                                    @foreach($data['users'] as $user)
                                    <option value="" disabled selected>Select Employee</option>
                                    <option value="{{$user->id}}"
                                        {{$data['material']->user_id == $user->id ? 'selected' : ''}}>{{$user->name}}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">

                            <div class="form-group">
                                <label for="supplier">Supplier</label>
                                <select class="form-control" name="supplier_id" id="supplier">
                                    @foreach($data['suppliers'] as $supplier)
                                    <option value="" disabled selected>Select Supplier</option>
                                    <option value="{{$supplier->id}}"
                                        {{$data['material']->supplier_id == $supplier->id ? 'selected':''}}>
                                        {{$supplier->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">

                            <div class="form-group">
                                <label for="qty">Qty</label>
                                <input type="text" value="{{$data['material']->qty}}" class="form-control" name="qty"
                                    id="qty" placeholder="Add Qty">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="bill_number">Bill Number</label>
                                <input type="text" class="form-control" value="{{$data['material']->bill_number}}"
                                    name="bill_number" id="bill_number" placeholder="Add Bill Number">
                            </div>

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">

                            <div class="form-group">
                                <label for="weight">Weight</label>
                                <input type="text" class="form-control" name="weight" id="weight"
                                    value="{{$data['material']->weight}}" placeholder="Add Weight">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="material_types">Material Type</label>
                                <select class="form-control" name="material_type_id" id="material_types">
                                    @foreach($data['material_types'] as $type)
                                    <option value="" disabled selected>Select Material type</option>
                                    <option value="{{$type->id}}"
                                        {{$data['material']->material_type_id == $type->id ? 'selected' : ''}}>
                                        {{$type->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea class="form-control" name="description" id="description"
                            placeholder="Add Description">{{$data['material']->description}}</textarea>
                        <input type="hidden" name="material_id" value="{{$data['material']->id}}">
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