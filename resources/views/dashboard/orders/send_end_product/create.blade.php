@extends('index')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">شحن المنتج الي الشركة </h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form role="form" onSubmit="return false" name="myform2" action="{{Route('send.end_product.store')}}" method="POST">
                @csrf
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="name">موظف الشحن</label>
                                <select class="form-control" name="user_id" id="">
                                    @foreach($employees as $employee)
                                    <option value="{{$employee->id}}">{{$employee->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="name">شركات الشحن</label>
                                <input type="text" class="form-control" id="tags" class="form-control" name="products" placeholder="Add Product Code" data-role="tagsinput" />
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                    <button type="button" value="GO" onClick="document.myform2.submit()" class="btn btn-primary">تسجيل</button>
                    <a href="{{url()->previous()}}" class="btn btn-info">رجوع</a>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection