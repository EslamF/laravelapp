@extends('index')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">صفحه تعديل المصنع</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form role="form" action="{{Route('factory.update')}}" method="POST">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label for="name">اسم المصنع</label>
                        <input type="text" class="form-control" name="name" value="{{$data['factory']->name}}" id="Factory name"
                            placeholder="Add factory">
                        <input type="hidden" name="type_id" value="{{$data['factory']->id}}">
                    </div>
                    <div class="row ">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="phone">رقم التيليفون</label>
                                <input type="text" class="form-control" name="phone" value="{{$data['factory']->phone}}" id="phone" >
                            </div>
                            </div>
                    <div class="col-md-8">
                        <div class="form-group ">
                            <label for="type">نوع المصنع</label>
                            <select class="form-control" name="factory_type_id" id="factory_type_id">
                                <option value="" disabled selected>اختر نوع المصنع</option>
                                @foreach($data['type'] as $type)
                                
                                <option value="{{$type->id}}" {{$data['factory']->factory_type_id == $type->id ? 'selected' : '' }}>{{$type->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    </div>
                        <div class="form-group">
                            <label for="address">عنوان المصنع</label>
                            <input type="text" class="form-control" name="address" value="{{$data['factory']->address}}" id="address" >
                        </div>
                       
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">تأكيد تعديل</button>
                    <a href="{{url()->previous()}}" class="btn btn-info">رجوع</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection