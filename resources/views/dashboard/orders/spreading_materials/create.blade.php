@extends('index')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">انشاء إذن الفرش</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form role="form" action="{{Route('spreading.material.store')}}" method="POST">
                @csrf
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="user">موظف الفرش</label>
                                <select class="form-control" name="user_id" id="user" class="@error('user_id') is-danger @enderror">
                                    <option value="" disabled selected>موظف الفرش</option>
                                    @foreach($data['users'] as $user)
                                    <option value="{{$user->id}}" {{old('user_id') == $user->id? 'selected':'' }}>{{$user->name}}</option>
                                    @endforeach
                                </select>
                                @error('user_id')
                                <p class="help text-danger">
                                    {{$message}}
                                </p>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="mq_r_code">كود الخامة</label>
                                <select class="form-control" name="material_id" id="user" class="@error('material_id') is-danger @enderror">
                                    <option value="" disabled selected>حدد كود الخامة</option>
                                    @foreach($data['material'] as $material)
                                    <option value="{{$material->id}}" {{old('material_id') == $material->id ? 'selected':'' }}>
                                        {{$material->mq_r_code}}</option>
                                    @endforeach
                                </select>
                                @error('material_id')
                                <p class="help is-danger">
                                    {{$message}}
                                </p>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="weight">الوزن</label>
                                <input type="number" class="form-control" value="{{old('weight')}}" name="weight" id="weight" placeholder="ادخل الوزن" class="@error('weight') is-danfer @enderror ">
                                @error('weight')
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
                    <a href="{{url()->previous()}}" class="btn btn-info">رحوع</a>
                </div>
            </form>
        </div>
    </div>
</div>
</div>
@endsection