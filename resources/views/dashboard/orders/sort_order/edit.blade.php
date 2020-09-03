@extends('index')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">تعديل في إذن الفرز</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form role="form" action="{{Route('sort.order.update')}}" method="POST">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label for="name">موظف الفرز</label>
                        <select class="form-control" name="user_id" id="">
                            <option value="" disabled selected>حدد اسم موظف الفرز</option>
                            @foreach($data['users'] as $user)
                            <option value="{{$user->id}}" {{$data['sort']->user_id == $user->id ? "selected": ""}}>{{$user->name}}</option>
                            @endforeach
                        </select>
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