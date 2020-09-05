@extends('index')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card card-primary">
            <div class="card-header">
                <!-- /.card-header -->
                <h3 class="card-title">إضافة شركة شحن</h3>
            </div>
            <!-- form start  -->
            <form role="form" action="{{Route('shippingcompany.store')}}" method="POST">
                <h3 class="card-title"></h3>
                @csrf
                <div class="card-body">

                    <div class="form-group">
                        <label for="name">اسم الشركة</label>
                        <input type="text" class="form-control" name="name" id="name" placeholder="ادخل اسم الشركة">
                    </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                    <button type="submit" id="reg" onclick="test()" class="btn btn-primary">إضافة</button>
                    <a href="{{url()->previous()}}" class="btn btn-info">رجوع</a>
                </div>
            </form>
        </div>
    </div>
</div>
</div>

@endsection