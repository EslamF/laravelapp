@extends('index')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card card-primary">
            <div class="card-header">
                <!-- /.card-header -->
                <h3 class="card-title">انشاءمقاس </h3>
            </div>
            <!-- form start  -->
            <form role="form" action="{{Route('size.store')}}" method="POST">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label for="name">اسم المقاس</label>
                        <input type="text" class="form-control" name="name" id="name" placeholder="ادخل المقاس">
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">تأكيد</button>
                        <a href="{{url()->previous()}}" class="btn btn-info">رجوع</a>
                    </div>
                    <!-- /.card-body -->
                </div>
            </form>
        </div>
    </div>
</div>
@endsection