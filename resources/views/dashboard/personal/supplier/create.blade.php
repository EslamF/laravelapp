@extends('index')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Create Suppliers</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start  -->

            {{-- id	name	phone	address	source	link	type --}}
            <form role="form" action="{{Route('supplier.store')}}" method="POST">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label for="name">Supplier Name</label>
                        <input type="text" class="form-control" name="name" id="name" placeholder="Add supplier Name">
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