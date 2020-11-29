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
            <form role="form" id="myform" action="{{Route('shippingcompany.store')}}" method="POST">
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
                    <button type="submit" id="reg" onclick="test()" onclick="submitForm()" class="btn btn-primary">إضافة</button>
                    <a href="{{route('shippingcompany.list')}}" class="btn btn-info">رجوع</a>
                </div>
            </form>
        </div>
    </div>
</div>
</div>

<script>
    var count = 0;

    function test() {
        count++;
        if (count == 2) {
            var button = document.getElementById('reg');
            button.disabled = true;
        }
    }
</script>
@endsection