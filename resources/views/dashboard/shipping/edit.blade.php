@extends('index')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">بيانات شركة الشحن</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form role="form" action="{{Route('shippingcompany.update')}}" method="POST">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label for="name">اسم الشركة</label>
                        <input type="text" class="form-control" value="{{$type->name}}" name="name" id="name" placeholder="ادخل اسم الشركة">
                        <input type="hidden" name="type_id" value="{{$type->id}}">
                    </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                    <button type="submit" id="reg" onclick="test()" class="btn btn-primary">تأكيد</button>
                    <a href="{{route('shippingcompany.list')}}" class="btn btn-info">رجوع</a>
                </div>
            </form>
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