@extends('index')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">ادخل نوع الخامة</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form role="form" action="{{Route('material.type.store')}}" method="POST">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label for="name">اسم النوع</label>
                        <input type="text" class="form-control" name="name" id="name" 
                        class="@error('name') is-danger @enderror"
                            value="{{old('name')}}">
                            @error('name')
                                <p class="help is-danger">
                                    {{$message}}
                                </p>
                                @enderror
                    </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                    <button type="submit" id="reg" onclick="test()" class="btn btn-primary">تسجيل</button>
                    <a href="{{url()->previous()}}" class="btn btn-info">رجوع</a>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    var count = 0;
    function test(){
        count++;
        if(count == 2){
            var button = document.getElementById('reg');
            button.disabled = true;
        }
    }
</script>
@endsection