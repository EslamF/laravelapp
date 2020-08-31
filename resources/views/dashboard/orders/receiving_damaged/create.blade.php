@extends('index')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">اذن استلام منتج تالف</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form role="form" action="{{Route('receiving.damaged_product.store')}}" method="POST">
                @csrf
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group">
                                <label for="weight">كود المنتج</label>
                                <input type="text" class="form-control" name="prod_code" id="weight" placeholder="ادخل كود المنتج" >
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="name">الحاله</label>
                                <select class="form-control" name="damage_type" id=""
                                class="@error('damage_type') is-danger @enderror">
                                    <option value="" disabled selected>تحديد الجوده</option>
                                            <option value="">عادي</option>
                                            <option value="ironing">كي</option>
                                            <option value="tailoring">خياطه</option>
                                            <option value="dyeing">صباغه</option>
                                </select>
                                @error('damage_type')
                                <p class="help is-danger">
                                    {{$message}}
                                </p>
                                @enderror
                            </div>
                        </div>
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