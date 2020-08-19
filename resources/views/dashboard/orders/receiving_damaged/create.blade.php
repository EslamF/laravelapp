@extends('index')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Create Fix Product Order</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form role="form" action="{{Route('receiving.damaged_product.store')}}" method="POST">
                @csrf
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group">
                                <label for="weight">Product Code</label>
                                <input type="text" class="form-control" name="prod_code" id="weight" placeholder="Add Product Code">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="name">Status</label>
                                <select class="form-control" name="damage_type" id="">
                                    <option value="" disabled selected>Choose status</option>
                                            <option value="">Fixed</option>
                                            <option value="ironing">Ironing</option>
                                            <option value="tailoring">Tailoring</option>
                                            <option value="dyeing">Dyeing</option>
                                </select>
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
@endsection