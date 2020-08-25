@extends('index')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">صفحه تعديل النوع</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form role="form" action="{{Route('factory.type.update')}}" method="POST">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label for="name">النوع</label>
                        <input type="text" class="form-control" name="name" value="{{$type->name}}" id="name">
                        <input type="hidden" name="type_id" value="{{$type->id}}"
                        class="@error('name') is_danger @enderror"
                        value="{{old('name')}}">
                    @error('name')
                    <small class="help is_danger">
                        {{$errors->first('name')}}
                    </small>
                    @enderror
                    </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">تأكيد التعديل</button>
                    <a href="{{url()->previous()}}" class="btn btn-info">رجوع</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection