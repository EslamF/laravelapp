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
                        <input type="name" class="form-control" value="{{$type->name}}" name="name" id="name" placeholder="ادخل اسم الموظف">
                        <input type="hidden" name="type_id" value="{{$type->id}}">

                    </div>
                    <div class="form-group">
                        <label for="email"> Email</label>
                        <input type="email" class="form-control" value="{{$type->email}}" name="email" id="email" placeholder="ادخل البريد الالكتروني الخاص بلموظف">
                    </div>
                    <div class="form-group">
                        <label for="password"> password</label>
                        <input type="password" class="form-control" value="{{$type->password}}" name="password" id="password" placeholder="ادخل كلمه المرور">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1"> comfirme Password</label>
                        <input type="password" class="form-control" value="{{$type->password}}" name="password_confirmation"  id="exampleInputPassword1" placeholder="تأكيد كلمه المرور">
                </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">تأكيد كلمه المرور</button>
                    <a href="{{url()->previous()}}" class="btn btn-info">رجوع</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection