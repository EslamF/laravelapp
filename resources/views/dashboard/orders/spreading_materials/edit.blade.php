@extends('index')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">تعديل اذن الفرش</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form role="form" action="{{Route('spreading.material.update')}}" method="POST">
                @csrf
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="user">موظف الفرش</label>
                                <select class="form-control" name ="user_id" id="user">
                                    <option value="" disabled selected>حدد موظف الفرش</option>
                                    @foreach($data['users'] as $user)
                                    <option value="{{$user->id}}"
                                        {{$data['spreading']->user_id == $user->id ? 'selected':'' }}>{{$user->name}}
                                    </option>
                                    @endforeach
                                </select>
                                 @error('user_id')
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
                                <label for="mq_r_code">كود الخامه</label>
                                <select class="form-control" name="material_id" id="user"
                                class="@error('material_id') is-danger @enderror">
                                    <option value="" disabled selected>حدد كود الخامه</option>
                                    @foreach($data['material'] as $material)
                                    <option value="{{$material->id}}"
                                        {{$data['spreading']->material_id == $material->id ? 'selected':'' }}>
                                        {{$material->mq_r_code}}</option>
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
                                <input type="number" class="form-control" value="{{old('weight') ??  $data['spreading']->weight}}"
                                    name="weight" id="weight" placeholder="ادخل الوزن"
                                    class="@error('weight') is-danfer @enderror " >
                                    @error('weight')
                                <p class="help is-danger">
                                    {{$message}}
                                </p>
                                @enderror
                                <input type="hidden" name="spreading_id" value="{{  $data['spreading']->id }}">
                                
                            </div>
                        </div>
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
</div>
@endsection