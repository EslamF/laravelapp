@extends('index')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">انشاء اذن تصنيع </h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <ul>
                @foreach($errors as $error)
                <li>{{$error}}</li>
                @endforeach
            </ul>
            <form role="form" action="{{Route('produce.order.store')}}" method="POST">
                @csrf
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="factory">المصنع</label>
                                <select class="form-control" name="factory_id" id="factory">
                                    <option value="" disabled selected>حدداسم المصنع</option>
                                    @foreach($data['factories'] as $factory)
                                    <option value="{{$factory->id}}">{{$factory->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="mq_r_code">اذن القص</label>
                                <select class="form-control" name="cutting_order_id" id="user">
                                    <option value="" disabled selected>حدد رقم اذن القص</option>
                                    @foreach($data['cutting_orders'] as $order)
                                    <option value="{{$order->id}}">{{$order->id}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="material">الخامه</label>
                                <select class="form-control" name="material_id" id="material">
                                    <option value="" disabled selected>حدد اذن الخامة</option>
                                    @foreach($data['materials'] as $material)
                                    <option value="{{$material->id}}">{{$material->mq_r_code}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="qty">الكمية</label>
                                <input type="number" class="form-control" name="qty" id="qty" placeholder="الكمية">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="receiving_date">تاريخ الاستلام</label>
                                <input type="date" class="form-control" name="receiving_date" id="receiving_date" placeholder="تاريخ الاستلام">
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