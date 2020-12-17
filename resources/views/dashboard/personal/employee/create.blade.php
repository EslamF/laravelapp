@extends('index')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">إضافة موظف</h3>
            </div>
            @include('includes.loading')
            <!-- /.card-header -->
            <!-- form start  -->

            {{-- id name phone address source link type --}}
            <form role="form" id = "myForm" action="{{ Route('employee.store') }}" method="POST">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label for="name"> الاسم</label>
                        <input type="name" value = "{{old('name')}}" class="form-control" name="name" id="name" placeholder="ادخل الاسم">
                        @error('name')
                        <p class="help is-danger">
                            {{ $message }}
                        </p>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="email"> البريد الالكتروني</label>
                        <input type="email" value = "{{old('email')}}"  class="form-control " name="email" id="email" placeholder="ادخل البريد الالكتروني">
                        @error('email')
                        <p class="help is-danger">
                            {{ $message }}
                        </p>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1"> كلمة المرور</label>
                        <input type="password" class="form-control" name="password" id="exampleInputPassword1" placeholder="ادخل كلمة المرور ">
                        @error('password')
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
                            <option value="" disabled {{ old('role_id') ?  '' : 'selected'  }} class="@error('role_id') is-danger @enderror">اختر نوع الوظيفة </option>
                            @foreach ($roles as $role)
                                <option value="{{ $role->id }}  {{ $role->id == old('role_id') ? 'selected' : '' }} ">{{ $role->display_name }}</option>
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
                    <button type="submit"  id="btnSubmit" class="btn btn-primary">إضافة</button>
                    <a href="{{route('employee.list')}}" class="btn btn-info">رجوع</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('footer-script')
<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous">
</script>
<script>
    $(document).ready(function() {
        $("#btnSubmit").click(function(e) {
            //stop submitting the form to see the disabled button effect
            e.preventDefault();
            var form = document.getElementById('myForm');
            form.submit();
            //disable the submit button
            $("#btnSubmit").attr("disabled", true);
            document.getElementById('loader').style.display = 'block';

            return true;

        });
    })
</script>
@endsection