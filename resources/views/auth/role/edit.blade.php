@extends('index')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">تعديل  الصلاحيه</h3>
            </div>
                <!-- /.card-header          id	name	phone	address	source	link	type	 -->
                <!-- form start -->
            <form role="form" action="{{Route('role.update')}}" method="POST">
                @csrf
                <div class="card-body">
                    <div class="form-group">

                        {{-- {{dd($data['peremissions'])}} --}}
                        <label for="name">اسم الصلاحيه</label>
                        <input type="text" class="form-control" name="name" id="name"  value="{{$data['role']->name}}" placeholder="ادخل اسم الصلاحية">
                    </div>
                    <div class="form-group">
                        <label for="description">التفاصيل</label>
                        <input type="text" class="form-control" name="description" id="description" value="{{$data['role']->description}}" placeholder="ادخل التفاصيل">
                    </div>
                    <div class="row">
                    @foreach($data['peremissions'] as $peremission)
                    <div class="form-check col-3">
                        <input type="checkbox" class="form-check-input" name="peremissions[]" id="exampleCheck1" value="{{$peremission->id}}"  {{in_array($peremission->id, $data['peremission_id']) ? 'checked' : ''}}>
                        <label class="form-check-label" for="exampleCheck1"  >{{$peremission->lable}}</label>
                      </div>
                      @endforeach
                      <input type="hidden" name="type_id" value="{{$data['role']->id}}">
                </div>
                </div>
                <!-- /.card-body -->
                
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">تأكيد التعديل</button>
                    <a href="{{url()->previous()}}" class="btn btn-info">رجوع</a>
                </div>
            </form>
    </div>
</div>
</div>
@endsection