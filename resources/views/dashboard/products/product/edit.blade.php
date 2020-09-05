@extends('index')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">بيانات في بيانات المنتج</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <ul>
                @foreach($errors as $error)
                <li>{{$error}}</li>
                @endforeach
            </ul>
            <form role="form" action="{{Route('product.update')}}" method="POST">
                @csrf
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="weight">كود المنتج</label>
                                <select name="material_id" id="">
                                    @foreach($materials as $material)
                                    <option value="{{}}" {{$material->id  == $material- }}>{{$material->mq_r_code}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="weight"> حالة المنتج الفرز</label>
                                <select class="form-control" name="damaged" id="material">
                                    <option value="" disabled selected>حاجة المنتج</option>
                                    <option value="1" {{$data['product']->damaged == 1? 'selected' : ''}}>صالح</option>
                                    <option value="0" {{$data['product']->damaged == 0? 'selected' : ''}}>تالف</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="weight">الحالة</label>
                                <select class="form-control" name="status" id="material">
                                    <option value="" disabled selected>جدد حالة المنتج</option>
                                    <option value="available" {{$data['product']->status == 'available'? 'selected' : ''}}>متاح</option>
                                    <option value="pending" {{$data['product']->status == 'pending'? 'selected' : ''}}>انتظار</option>
                                    <option value="sold" {{$data['product']->status == 'sold'? 'selected' : ''}}>مباع</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="description">الوصف</label>
                                <textarea class="form-control" name="description" id="description" placeholder="ادخل الوصف">{{$data['product']->description}}</textarea>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="product_id" value="{{$data['product']->id}}">
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">إضافة</button>
                    <a href="{{url()->previous()}}" class="btn btn-info">رجوع</a>
                </div>
            </form>
        </div>
    </div>
</div>
</div>
@endsection