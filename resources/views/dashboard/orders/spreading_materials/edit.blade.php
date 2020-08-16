@extends('index')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Edit Spreading Material Order</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form role="form" action="{{Route('spreading.material.update')}}" method="POST">
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
                                        {{$data['spreading']->user_id == $user->id ? 'selected':'' }}>{{$user->name}}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="mq_r_code">Material MQ_R_Code</label>
                                <select class="form-control" name="material_id" id="user">
                                    <option value="" disabled selected>Select Material code</option>
                                    @foreach($data['material'] as $material)
                                    <option value="{{$material->id}}"
                                        {{$data['spreading']->material_id == $material->id ? 'selected':'' }}>
                                        {{$material->mq_r_code}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="weight">Weight</label>
                                <input type="number" class="form-control" value="{{$data['spreading']->weight}}"
                                    name="weight" id="weight" placeholder="Add Weight">
                                <input type="hidden" name="spreading_id" value="{{$data['spreading']->id}}">
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