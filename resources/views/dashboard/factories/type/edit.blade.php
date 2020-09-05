@extends('index')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">بيانات نوع المصنع</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form role="form" action="{{Route('factory.type.update')}}" method="POST">
                @csrf
                <div class="card-body">
                <div class="form-group">
                    <label for="type">النوع</label>
                    <input type="text" class="form-control" name="type" id="type" value="{{$type->name}}" placeholder=" ادخل النوع"
                    class="@error('type') is-danger @enderror" value="{{old('type')}}">
                    @error('type')
                    <p class="help is-danger">
                        {{$message}}
                    </p>
                    @enderror
                    <input type="hidden" name="type_id" value="{{$type->id}}">

                </div>
            </div>

                <!-- /.card-body -->

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">تأكيد</button>
                    <a href="{{url()->previous()}}" class="btn btn-info">رجوع</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection