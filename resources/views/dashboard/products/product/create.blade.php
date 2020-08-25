@extends('index')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">انشاء منتج</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <ul>
                @foreach($errors as $error)
                <li>{{$error}}</li>
                @endforeach
            </ul>
            <form role="form" action="{{Route('product.store')}}" method="POST">
                @csrf
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="factory">اذن التصنيع</label>
                                <select class="form-control" name="receiving_order_id" id="factory">
                                    <option value="" disabled selected>حدد اذن التصنيع</option>
                                    @foreach($receiving_orders as $order)
                                    <option value="{{$order->id}}">{{$order->id}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="weight">كود المنتج</label>
                                <input type="text" class="form-control" name="prod_code" id="weight" >
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="weight">الفرز</label>
                                <select class="form-control" name="sorted" id="material">
                                    <option value="" disabled selected>حاله الفرز</option>
                                    <option value="1">تم</option>
                                    <option value="0">لم يتم بعد</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="weight">الجوده</label>
                                <select class="form-control" name="damaged" id="material">
                                    <option value="" disabled selected>حدد جوده المنتج</option>
                                    <option value="1">صالح</option>
                                    <option value="0">تالف</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="weight">حاله المنتج</label>
                                <select class="form-control" name="status" id="material">
                                    <option value="" disabled selected>حدد حاله المنتج</option>
                                    <option value="available">متاح</option>
                                    <option value="pending">انتظار</option>
                                    <option value="sold">مباع</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="description">التفاصيل</label>
                                <textarea class="form-control" name="description" id="description"
                                    placeholder="ادخل التفاصيل"></textarea>
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
</div>
@endsection