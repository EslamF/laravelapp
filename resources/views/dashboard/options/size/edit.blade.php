@extends('index')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Edit Sizes</h3>
                <!-- /.card-header  -->
            </div>
                <!-- form start -->
            <form role="form" action="{{Route('size.update')}}" method="POST">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label for="name">Size Name</label>
                        <input type="text" class="form-control" value="{{$type->name}}" name="name" id="name" placeholder="Add size Name">
                        <input type="hidden" name="type_id" value="{{$type->id}}">
                    
                    </div> 
                    <!-- /.card-body -->
                    
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <a href="{{url()->previous()}}" class="btn btn-info">Back</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection