@extends('index')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">إضافةالمورد</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start  -->

            {{-- id	name	phone	address	source	link	type --}}
            <form role="form" id="myForm" action="{{Route('supplier.store')}}" method="POST">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label for="name">اسم المورد</label>
                        <input type="text" class="form-control" name="name" id="name" placeholder="ادخل اسم المورد">
                    </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                    <button type="submit"id="reg" onclick="test()"  class="btn btn-primary">إضافة</button>
                    <a href="{{ route('supplier.list') }}" class="btn btn-info">رجوع</a>
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