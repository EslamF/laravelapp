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
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="weight">كود خامة</label>
                                <select name="material_id" class="form-control" id="">
                                    @foreach($materials as $material)
                                    <option value="{{$material->id}}" {{$material->id  == $product->material->id }}>{{$material->mq_r_code}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="weight">كود المنتج</label>
                                <input type="text" class="form-control" name="prod_code" value="{{$product->prod_code}}" id="">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="weight"> حالة الفرز</label>
                                <select class="form-control" name="damaged" id="material">
                                    <option value="" disabled selected>حاجة المنتج</option>
                                    <option value="" {{$product->damage_type == null ? 'selected': ''}}>صالج</option>
                                    <option value="ironing" {{$product->damage_type == 'ironging' ? 'selected': ''}}>كي</option>
                                    <option value="tailoring" {{$product->damage_type == 'tailoring' ? 'selected': ''}}>خياطة</option>
                                    <option value="dyeing" {{$product->damage_type == 'dyeing' ? 'selected': ''}}>صباغة</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="weight">الحالة</label>
                                <select class="form-control" name="status" id="material">
                                    <option value="" disabled selected>جدد حالة المنتج</option>
                                    <option value="available" {{$product->status == 'available' ?  'selected' : ''}}>متاح</option>
                                    <option value="pending" {{$product->status == 'pending' ?  'selected' : ''}}>انتظار</option>
                                    <option value="sold" {{$product->status == 'sold' ?  'selected' : ''}}>تم البيع</option>
                                    <option value="damaged" {{$product->status == 'damaged' ?  'selected' : ''}}>تالف</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="weight">نوع منتج</label>
                                <select name="product_type_id" class="form-control" id="">
                                    @foreach($product_types as $type)
                                    <option value="{{$type->id}}" {{$type->id  == $product->productType->id }}>{{$type->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="weight">مقاس المنتج</label>
                                <select name="size_id" class="form-control" id="">
                                    @foreach($sizes as $size)
                                    <option value="{{$size->id}}" {{$size->id  == $product->size->id }}>{{$size->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="description">الوصف</label>
                                <textarea class="form-control" name="description" id="description" placeholder="ادخل الوصف">{{$product->description}}</textarea>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="product_id" value="{{$product->id}}">
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