@extends('index')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">بيانات  الوظيفة</h3>
            </div>
                <!-- /.card-header          id	name	phone	address	source	link	type	 -->
                <!-- form start -->
            <form role="form" action="{{Route('role.update')}}" method="POST">
                @csrf
                <div class="card-body">
                    <div class="form-group">

                        {{-- {{dd($data['peremissions'])}} --}}
                        <label for="label">اسم الوظيفة</label>
                        <input type="text" class="form-control" name="label" id="label"  value="{{$data['role']->label}}" placeholder="ادخل اسم الوظيفة">
                    </div>
                    <div class="form-group">
                        <label for="description">وصف</label>
                        <input type="text" class="form-control" name="description" id="description" value="{{$data['role']->description}}" placeholder="ادخل الوصف ">
                    </div>
                    <h5> 
                        الصلحيات
                    </h5>
                                    <div class="row ">
                    @foreach($data['peremissions'] as $peremission)
                    <div class="form-check col-3">
                        <input type="checkbox" class="form-check-input" name="peremissions[]" id="{{$peremission->id}}" value="{{$peremission->id}}"  {{in_array($peremission->id, $data['peremission_id']) ? 'checked' : ''}}>
                        <label class="form-check-label" for="{{$peremission->id}}"  >{{$peremission->lable}}</label>
                      </div>
                      @endforeach
                      <input type="hidden" name="type_id" value="{{$data['role']->id}}">
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
@endsection