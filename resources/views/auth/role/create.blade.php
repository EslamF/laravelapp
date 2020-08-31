@extends('index')
@section('content')
    <div class="row">
    <div class="col-md-12">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">انشاء صلاحيات</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start  -->
            <form role="form" action="{{Route('role.store')}}" method="POST">
                @csrf
                <div class="card-body " style="height: 100%">
                    <div class="form-group">
                        <label for="name">اسم الصلاحيه</label>
                        <input type="text"
                         class="form-control @error('name') is-danger @enderror"
                            name="name" id="name"  placeholder="ادخل اسم الصلاحية" value="{{old('name')}}">
                        @error('name')
                    <p class=" is-danger">{{$message}}</p>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="label">اسم الصلاحيه</label>
                        <input type="text"
                         class="form-control @error('label') is-danger @enderror"
                            name="label" id="label"  placeholder="ادخل اسم الصلاحية" value="{{old('label')}}">
                        @error('label')
                    <p class=" is-danger">{{$message}}</p>
                        @enderror
                    </div>
                    <div class="form-group ">
                        <label for="desc">التفاصيل</label>
                        {{-- @if(count($errors->toArray()))
                            @foreach($errors[peremissions]->toArray())
                            @endif
                            @endforeach --}}
                            {{-- {{dd($peremissions)}} --}}
                        <input type="text" class="form-control" name="description" id="description"  placeholder="ادخل التفاصيل">
                        @error('description')
                        <p class=" is-danger">{{$message}}</p>
                            @enderror
                    </div>
                    
                    <div class="row">
                        @foreach($peremissions as $peremission)
                    <div class="form-check col-3 ">
                    <input type="checkbox" class="form-check-input" name="peremissions[]" id="exampleCheck1" value="{{$peremission->id}}">
                    <label class="form-check-label" for="exampleCheck1"  >{{$peremission->lable}}</label>
                      </div>
                      @endforeach
                </div>
            </div>
                <!-- /.card-body -->

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">تسجيل</button>
                    <a href="{{url()->previous()}}" class="btn btn-info">رجوع</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection