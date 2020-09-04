@extends('index')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">اضافة موظف</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start  -->

            {{-- id name phone address source link type --}}
            <form role="form" action="{{ Route('employee.store') }}" method="POST">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label for="name"> الاسم</label>
                        <input type="name" class="form-control" name="name" id="name" placeholder="ادخل الاسم">
                        @error('email')
                        <p class="help is-danger">
                            {{ $message }}
                        </p>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="email"> البريد الالكتروني</label>
                        <input type="email" class="form-control " name="email" id="email" placeholder="ادخل البريد الالكتروني">
                        @error('email')
                        <p class="help is-danger">
                            {{ $message }}
                        </p>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1"> كلمة المرور</label>
                        <input type="password" class="form-control" name="password" id="exampleInputPassword1" placeholder="ادخل كلمة المرور ">
                        @error('password_confirmation')
                        <p class="help is-danger">
                            {{ $message }}
                        </p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="exampleInputPassword1"> تأكيد كلمة المرور</label>
                        <input type="password" class="form-control" name="password_confirmation" id="exampleInputPassword1" placeholder="تأكيد كلمة المرور">
                        @error('password_confirmation')
                        <p class="help is-danger">
                            {{ $message }}
                        </p>
                        @enderror
                    </div>
                    <div class="form-group ">
                        <label for="type">نوع الوظيفة</label>
                        <select class="form-control" name="role_id" id="role_id">
                            <option value="" disabled selected class="@error('role_id') is-danger @enderror" value="{{ old('role_id') }}">اختر نوع الوظيفة </option>
                            @foreach ($roles as $role)
                            <option value="{{ $role->id }}">{{ $role->label }}</option>
                            @endforeach
                        </select>
                        @error('role_id')
                        <p class="help is-danger">
                            {{ $message }}
                        </p>
                        @enderror
                    </div>

                </div>

                <!-- /.card-body -->

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">إضافة</button>
                    <a href="{{ url()->previous() }}" class="btn btn-info">رجوع</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection