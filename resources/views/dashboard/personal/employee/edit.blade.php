@extends('index')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">بيانات في بيانات الموظف </h3>
            </div>
            @include('includes.loading')
            <!-- form start -->
            <form role="form" id = "myForm" action="{{Route('employee.update')}}" method="POST">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label for="name"> اسم الموظف</label>
                        <input type="name" class="form-control" value="{{$data['user']->name}}" name="name" id="name" placeholder="ادخل اسم الموظف">
                        <input type="hidden" name="type_id" value="{{$data['user']->id}}">
                        @error('name')
                        <p class="help is-danger">
                            {{ $message }}
                        </p>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="email"> البريد الالكتروني</label>
                        <input type="email" class="form-control" value="{{$data['user']->email}}" name="email" id="email" placeholder="ادخل البريد الالكتروني الخاص بلموظف">
                        @error('email')
                        <p class="help is-danger">
                            {{ $message }}
                        </p>
                        @enderror
                    </div>
                    <div class="form-group ">
                        <label for="type">نوع الوظيفة</label>
                        <select class="form-control" name="role_id" id="role_id" class="@error('role_id') is-danger @enderror" value="{{old('role_id')}}">
                            <option value="" disabled selected>
                                اختر نوع الوظيية</option>
                            @foreach($data['roles'] as $role)
                                <option value="{{$role->id}}" {{ isset($data['user']->roles) ??  $data['user']->roles == $role->id  ? 'selected' : '' }}>{{$role->display_name}}</option>
                            @endforeach
                        </select>
                        @error('role_id')
                        <p class="help is-danger">
                            {{$message}}
                        </p>
                        @enderror
                    </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                    <button type="submit" id="btnSubmit" class="btn btn-primary">تأكيد </button>
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

