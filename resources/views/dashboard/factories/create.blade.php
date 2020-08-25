@extends('index')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">صفحه انشاء المصنع</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form role="form" action="{{Route('factory.store')}}" method="POST">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label for="name">اسم المصنع</label>
                        <input type="text" class="form-control" name="name" id="name" 
                        class="@error('name') is-danger @enderror"
                        value="{{old('name')}}">
                    @error('name')
                    <p class="help is-danger">
                        {{$message}}
                    </p>
                    @enderror
                    </div>
                    
            <div class="row ">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="phone">رقم التيليفون</label>
                        <input type="text" class="form-control" name="phone" id="phone"
                        class="@error('phone') is-danger @enderror"
                        value="{{old('phone')}}">
                    @error('phone')
                    <p class="help is-danger">
                        {{$message}}
                    </p>
                    @enderror
                    </div>
                    </div>
                <div class="col-md-8">
                    <div class="form-group ">
                        <label for="type">نوع المصنع</label>
                        <select  class="form-control" name="factory_type_id" id="factory_type_id">
                            <option value="" disabled selected 
                            
                            class="@error('factory_type_id') is-danger @enderror"
                            value="{{old('factory_type_id')}}"                 
                            >اختر نوع المصنع </option>
                            @foreach($types as $type)
                            <option value="{{$type->id}}">{{$type->name}}</option>
                            @endforeach
                        </select>
                        @error('factory_type_id')
                        <p class="help is-danger">
                            {{$message}}
                        </p>
                        @enderror
                    </div>
                </div>
            </div>
                    <div class="form-group">
                        <label for="address">عنوان الصنع</label>
                        <input type="text" class="form-control" name="address" id="address" 
                        class="@error('address') is-danger @enderror"
                        value="{{old('address')}}">
                    @error('address')
                    <p class="help is-danger">
                        {{$message}}
                    </p>
                    @enderror
                    </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">تسجيل</button>
                    <a href="{{url()->previous()}}" class="btn btn-info">رجوع</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection