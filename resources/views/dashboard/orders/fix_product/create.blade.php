@extends('index')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">إذن خروج منتجات تالفة</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form role="form" action="{{Route('fix.product.store')}}" method="POST">
                @csrf
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group">
                                <label for="weight"> الرقم المرجعي المنتج</label>
                                <input type="text" class="form-control @error('prod_code') is-danger @enderror "
                                 name="prod_code" id="weight" placeholder="ادخل  الرقم المرجعي المنتج"
                                
                                value="{{old('prod_code')}}">
                            @error('prod_code')
                            <p class="help is-danger">
                                {{$message}}
                            </p>
                            @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="name">المصنع</label>
                                <select class="form-control" name="factory_id" id=""
                                class="@error('factory_id') is-danger @enderror"
                                value="{{old('factory_id')}}">
                                    <option value="" disabled selected>حدد المصنع</option>
                                    @foreach($factories as $factory)
                                    <option value="{{$factory->id}}">{{$factory->name}}</option>
                                    @endforeach
                                </select>
                                
                            @error('factory_id')
                            <p class="help is-danger">
                                {{$message}}
                            </p>
                            @enderror
                            </div>
                        </div>
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