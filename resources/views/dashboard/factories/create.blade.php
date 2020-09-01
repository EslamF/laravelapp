@extends('index')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Create Factory</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form role="form" action="{{Route('factory.store')}}" method="POST">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label for="name">Factory Name</label>
                        <input type="text" class="form-control" name="name" id="name" placeholder="Add Factory Name">
                    </div>
                    
            <div class="row ">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="phone">Factory Phone</label>
                        <input type="text" class="form-control" name="phone" id="phone" placeholder="Add Factory phone">
                    </div>
                    </div>
                <div class="col-md-8">
                    <div class="form-group ">
                        <label for="type">Factory Type</label>
                        <select class="form-control" name="factory_type_id" id="factory_type_id">
                            <option value="" disabled selected>Select Factory Type</option>
                            @foreach($types as $type)
                            <option value="{{$type->id}}">{{$type->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

                    <div class="form-group">
                        <label for="address">Factory Address</label>
                        <input type="text" class="form-control" name="address" id="address" placeholder="Add Factory Address">
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
@endsection