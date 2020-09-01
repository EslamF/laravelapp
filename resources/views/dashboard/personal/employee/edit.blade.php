@extends('index')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">تعديل في بيانات الموظف </h3>
            </div>
            <!-- form start -->
            <form role="form" action="{{Route('employee.update')}}" method="POST">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label for="name"> اسم الموظف</label>
                        <input type="name" class="form-control" value="{{$data['user']->name}}" name="name" id="name" placeholder="ادخل اسم الموظف">
                        <input type="hidden" name="type_id" value="{{$data['user']->id}}">

                    </div>
                    <div class="form-group">
                        <label for="email"> البريد الالكتروني</label>
                        <input type="email" class="form-control" value="{{$data['user']->email}}" name="email" id="email" placeholder="ادخل البريد الالكتروني الخاص بلموظف">
                    </div>
                    <div class="form-group">
                        <label for="password"> كلمه المرور</label>
                        <input type="password" class="form-control" value="{{$data['user']->password}}" name="password" id="password" placeholder="ادخل كلمه المرور">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1"> تأكيد كلمه المرور</label>
                        <input type="password" class="form-control" value="{{$data['user']->password}}" name="password_confirmation" id="exampleInputPassword1" placeholder="تأكيد كلمه المرور">
                    </div>

                    <div class="form-group ">

                        {{-- {{dd($data['user']->roles)}} --}}
                        <label for="type">نوع الوظيفة</label>
                        <select class="form-control" name="role_id" id="role_id" class="@error('role_id') is-danger @enderror" value="{{old('role_id')}}">

                            <option value="" disabled selected>
                                اختر نوع الوظيية</option>
                            @foreach($data['roles'] as $role)
                            <option value="{{$role->id}}" {{ isset($data['user']->roles) ??  $data['user']->roles == $role->id  ? 'selected' : '' }}>{{$role->label}}</option>
                            @endforeach
                        </select>
                        {{--
                    @error('role_id')
                    <p class="help is-danger">
                        {{$message}}
                        </p>
                        @enderror
                    </div> --}}
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">تأكيد </button>
                    <a href="{{url()->previous()}}" class="btn btn-info">رجوع</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection