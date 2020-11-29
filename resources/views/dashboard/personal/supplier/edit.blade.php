@extends('index')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">بيانات في بيانات المورد</h3>
            </div>
            <!-- /.card-header          id	name	phone	address	source	link	type	 -->
            <!-- form start -->
            <form role="form" id="myForm" action="{{Route('supplier.update')}}" method="POST">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label for="name">اسم المورد</label>
                        <input type="text" class="form-control" value="{{$supplier->name}}" name="name" id="name" placceholder="ادخل اسم المورد">
                        <input type="hidden" name="supplier_id" value="{{$supplier->id}}">

                    </div> 
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                    <button type="submit" id="reg" onclick="test()" class="btn btn-primary">تأكيد</button>
                    <a href="{{route('supplier.list')}}" class="btn btn-info">رجوع</a>
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