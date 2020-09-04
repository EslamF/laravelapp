@extends('index')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">اضافةالمورد</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start  -->

            {{-- id	name	phone	address	source	link	type --}}
            <form role="form" action="{{Route('supplier.store')}}" method="POST">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label for="name">اسم المورد</label>
                        <input type="text" class="form-control" name="name" id="name" placeholder="ادخل اسم المورد">
                    </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">إضافة</button>
                    <a href="{{url()->previous()}}" class="btn btn-info">رجوع</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection