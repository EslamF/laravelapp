@extends('index')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">انشاء اذن استلام المنتجات</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <ul>
                @foreach($errors as $error)
                <li>{{$error}}</li>
                @endforeach
            </ul>
            <form role="form" action="{{Route('receiving.product.store')}}" method="POST">
                @csrf
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="factory">اذن التصنيع</label>
                                <select class="form-control" name="produce_order_id" id="factory">
                                    <option value="" disabled selected>حدد اذن التصنيع</option>
                                    @foreach($data['produce_orders'] as $order)
                                    <option value="{{$order->id}}">{{$order->id}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="mq_r_code">المنتج</label>
                                <select class="form-control" name="product_type_id" id="user">
                                    <option value="" disabled selected>حدد نوع المنتج</option>
                                    @foreach($data['product_types'] as $type)
                                    <option value="{{$type->id}}">{{$type->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="material">المقاس</label>
                                <select class="form-control" name="size_id" id="material">
                                    <option value="" disabled selected>حدد مقاس المنتج</option>
                                    @foreach($data['sizes'] as $size)
                                    <option value="{{$size->id}}">{{$size->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="weight">الكميه</label>
                                <input type="number" class="form-control" name="qty" id="weight" >
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="weight">الحاله</label>
                                <select class="form-control" name="status" id="material">
                                    <option value="" disabled selected>حدد حاله الاذن</option>
                                    <option value="1">تم </option>
                                    <option value="0">لم يتم بعد</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="weight">تاريخ الاستلام</label>
                                <input type="date" class="form-control" name="receiving_date" id="weight" placeholder="ادخل تاريخ الاستلام">
                                
                            </div>
                        </div>
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
</div>
@endsection