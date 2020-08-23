@extends('index')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">تعديل في اذن استلام الخامات</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <ul>
                @foreach($errors as $error)
                <li>{{$error}}</li>
                @endforeach
            </ul>
            <form role="form" action="{{Route('receiving.product.update')}}" method="POST">
                @csrf
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="factory">اذن التصنيع</label>
                                <select class="form-control" name="produce_order_id" id="factory">
                                    <option value="" disabled selected> حدد رقم اذن التصنيع</option>
                                    @foreach($data['produce_orders'] as $order)
                                    <option value="{{$order->id}}"
                                        {{$data['records']->produce_order_id == $order->id ? "selected":''}}>
                                        {{$order->id}}</option>
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
                                    <option value="{{$type->id}}"
                                        {{$data['records']->product_type_id == $type->id ? "selected":''}}>{{$type->id}}
                                    </option>
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
                                    <option value="{{$size->id}}"
                                        {{$data['records']->size_id == $size->id ? "selected":''}}>{{$size->name}}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="weight">الكميه</label>
                                <input type="number" class="form-control" value="{{$data['records']->qty}}" name="qty"
                                    id="weight" >
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="status">حاله الاذن</label>
                                <select class="form-control" name="status" id="status">
                                    <option value="" disabled selected>حدد حاله المنتج</option>
                                    <option value="1" {{$data['records']->status == 1 ? "selected":''}}>تم 
                                    </option>
                                    <option value="0" {{$data['records']->status == 0 ? "selected":''}}>لم يتم بعد
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="weight">تاريخ الاستلام</label>
                                <input type="date" class="form-control" value="{{$data['records']->receiving_date}}"
                                    name="receiving_date" id="weight" >
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="receiving_id" value="{{$data['records']->id}}">
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