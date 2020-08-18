@extends('index')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Edit Customers</h3>
            </div>
            <!-- /.card-header          id	name	phone	address	source	link	type	 -->
            <!-- form start -->
            <form role="form" action="{{Route('customer.update')}}" method="POST">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label for="name">Customer Name</label>
                        <input type="text" class="form-control" value="{{$customer->name}}" name="name" id="name" placeholder="Add customer Name">
                    </div>
            <div class="row ">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="phone">Customer Phone</label>
                        <input type="text" class="form-control" value="{{$customer->phone}}" name="phone" id="phone" placeholder="Add customer phone">
                    </div>
                </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="source">Customer Source</label>
                            <input type="text" class="form-control" value="{{$customer->phone}}" name="source" id="source" placeholder="Add customer source">
                        </div>
                    </div>
                </div>
                    <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="link">Customer  Link</label>
                            <input type="text" class="form-control" value="{{$customer->link}}" name="link" id="link" placeholder="Add customer link">
                        </div>
                    </div>
                <div class="col-md-6">
                    <div class="form-group ">
                        <label for="type">Customer Type</label>
                        <select class="form-control" value="{{$customer->type}}" name="type" id="type">
                            <option value="" disabled selected>Select customer Type</option>
                            <option value="individual" {{$customer->type== "individual" ? "selected":''}} >Individual</option>
                            <option value="wholesaler" {{$customer->type== "wholesaler" ? "selected":''}}>Wholesaler</option>
                            <option value="retailer" {{$customer->type== "retailer" ? "selected":''}}>Retailer</option>
                        </select>
                    </div>
                </div>
            </div>
                    <div class="form-group">
                        <label for="address">customer Address</label>
                        <input type="text" class="form-control" value="{{$customer->address}}" name="address" id="address" placeholder="Add customer Address">
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