@extends('index')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Create employee</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start  -->

            {{-- id	name	phone	address	source	link	type --}}
            <form role="form" action="{{Route('employee.store')}}" method="POST">
                @csrf
                <div class="card-body">

                    <div class="form-group">
                        <label for="name"> Name</label>
                        <input type="name" class="form-control" name="name" id="name" placeholder="Add employee Name">
                    </div>
                    <div class="form-group">
                            <label for="email"> email</label>
                            <input type="email" class="form-control" name="email" id="email" placeholder="Add employee email">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1"> Password</label>
                        <input type="password" class="form-control" name="password" id="exampleInputPassword1" placeholder="Add employee Password">
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">confirme Password</label>
                    <input type="password" class="form-control" name="password_confirmation" id="exampleInputPassword1" placeholder="Add employee Password">
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