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
            <form role="form" action="{{Route('receiving.product.store')}}" method="POST">
                @csrf
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="factory">اذن التصنيع</label>
                                <select class="form-control" name="produce_order_id" id="factory"
                                class="@error('produce_order_id') is-danger @enderror">
                                    <option value="" disabled selected>حدد اذن التصنيع</option>
                                    @foreach($data['produce_orders'] as $order)
                                    <option value="{{$order->id}}">{{$order->id}}</option>
                                    <option value="{{$order->id}}" {{old('produce_order_id') == $order->id ? 'selected':'' }}>
                                        {{$order->id}}</option>
                                    @endforeach
                                </select>
                                @error('produce_order_id')
                                <p class="help is-danger">
                                    {{$message}}
                                </p>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="mq_r_code">المنتج</label>
                                <select class="form-control" name="product_type_id" id="user"
                                class="@error('product_type_id') is-danger @enderror">
                                    <option value="" disabled selected>حدد نوع المنتج</option>
                                    @foreach($data['product_types'] as $type)
                                    <option value="{{$type->id}}">{{$type->name}}</option>
                                    <option value="{{$type->id}}" {{old('product_type_id') == $type->id ? 'selected':'' }}>
                                        {{$type->name}}</option>
                                    @endforeach
                                </select>
                                @error('product_type_id')
                                <p class="help is-danger">
                                    {{$message}}
                                </p>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="material">المقاس</label>
                                <select class="form-control" name="size_id" id="material"
                                class="@error('product_type_id') is-danger @enderror">
                                    <option value="" disabled selected>حدد مقاس المنتج</option>
                                    @foreach($data['sizes'] as $size)
                                    <option value="{{$size->id}}">{{$size->name}}</option>
                                    <option value="{{$size->id}}" {{old('size_id') == $size->id ? 'selected':'' }}>{{$size->name}}</option>
                                    @endforeach
                                </select>
                                @error('size_id')
                                <p class="help is-danger">
                                    {{$message}}
                                </p>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="weight">الكميه</label>
                                <input type="number" class="form-control" name="qty" id="weight" 
                                class="@error('qty') is-danger @enderror"
                                value="{{old('qty')}}">
                                    @error('qty')
                                    <p class="help is-danger">
                                        {{$message}}
                                    </p>
                                    @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="weight">الحاله</label>
                                <select class="form-control" name="status" id="material" 
                                class="@error('status') is-danger @enderror">
                                    <option value="" disabled selected>حدد حاله الاذن</option>
                                    <option value="1"  {{ old('status') == 1 ? 'selected' : '' }}>
                                        تم  
                                    </option>
                                    <option value="0" {{ old('status') == 0 ? 'selected' : '' }}>
                                        لم يتم بعد
                                    </option>
                                </select>
                                @error('status')
                                    <p class="help is-danger">
                                        {{$message}}
                                    </p>
                                    @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="weight">تاريخ الاستلام</label>
                                <input type="date" class="form-control" name="receiving_date" id="weight" placeholder="ادخل تاريخ الاستلام"
                                class="@error('receiving_date') is-danger @enderror"
                                value="{{old('receiving_date')}}">
                                    @error('receiving_date')
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
                    <button type="submit" class="btn btn-primary">تأكيد التعديل</button>
                    <a href="{{url()->previous()}}" class="btn btn-info">رجوع</a>
                </div>
            </form>
        </div>
    </div>
</div>
</div>
@endsection