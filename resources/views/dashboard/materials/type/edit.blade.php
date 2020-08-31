@extends('index')
@section('content')
<div class="row" >
    <div class="col-md-12 " >
        <div class="card card-primary">
            <div class="card-header" >
                <h3 class="card-title" >تعديل نوع الخامة</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form role="form" action="{{Route('material.type.update')}}" method="POST" >
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label for="name">النوع</label>
                        <input type="text" class="form-control" name="name" value="{{$type->name}}" id="name"
                            placeholder="ادخل نوع الخامة"
                            class="@error('name') is-danger @enderror"
                            value="{{old('name')}}">
                            @error('name')
                                <p class="help is-danger">
                                    {{$message}}
                                </p>
                                @enderror
                        <input type="hidden" name="type_id" value="{{$type->id}}">
                    </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary" >تأكيد التعديل</button>
                    <a href="{{url()->previous()}}" class="btn btn-info">رجوع</a>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection