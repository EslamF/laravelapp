@extends('index')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">انشاء اذن الفرش</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form role="form" action="{{Route('spreading.material.store')}}" method="POST">
                @csrf
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="user">موظف الفرش</label>
                                <select class="form-control" name="user_id" id="user">
                                    <option value="" disabled selected>موظف الفرش</option>
                                    @foreach($data['users'] as $user)
                                    <option value="{{$user->id}}">{{$user->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="mq_r_code">كود الخامه</label>
                                <select class="form-control" name="material_id" id="user">
                                    <option value="" disabled selected>حدد كود الخامه</option>
                                    @foreach($data['material'] as $material)
                                    <option value="{{$material->id}}">{{$material->mq_r_code}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="weight">الوزن</label>
                                <input type="number" class="form-control" name="weight" id="weight"
                                    placeholder="ادخل الوزن">
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">تسجيل</button>
                    <a href="{{url()->previous()}}" class="btn btn-info">رحوع</a>
                </div>
            </form>
        </div>
    </div>
</div>
</div>
@endsection