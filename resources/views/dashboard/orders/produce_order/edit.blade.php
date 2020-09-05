@extends('index')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">تعديل في إذن التصنيع</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <ul>
                @foreach($errors as $error)
                <li>{{$error}}</li>
                @endforeach
            </ul>
            <form role="form" action="{{Route('produce.order.update')}}" method="POST">
                @csrf
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="factory">المصنع</label>
                                <select class="form-control" name="factory_id" id="factory" class="@error('factory_id') is-danger @enderror" value="{{old('factory_id')}}">
                                    <option value="" disabled selected>حدد المصنع</option>
                                    @foreach($data['factories'] as $factory)
                                    <option value="{{$factory->id}}" {{$data['records']->factory_id == $factory->id?'selected':''}}>
                                        {{$factory->name}}</option>
                                    @endforeach
                                </select>
                                @error('factory_id')
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
                                <label for="mq_r_code">إذن القص</label>
                                <select class="form-control" name="cutting_order_id" id="user" class="@error('cutting_order_id') is-danger @enderror" value="{{old('cutting_order_id')}}">
                                    <option value="" disabled selected>حدد إذن القص</option>
                                    @foreach($data['cutting_orders'] as $order)
                                    <option value="{{$order->id}}" {{$data['records']->cutting_order_id == $order->id?'selected':''}}>
                                        {{$order->id}}</option>
                                    @endforeach
                                </select>
                                @error('cutting_order_id')
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
                                <label for="weight">تاريخ الإستلام</label>
                                <input type="date" class="form-control" name="receiving_date" value="{{$data['records']->receiving_date}}" id="weight" placeholder="تاريخ الإستلام" class="@error('receiving_date') is-danger @enderror" value="{{old('receiving_date')}}">
                                @error('receiving_date')
                                <p class="help is-danger">
                                    {{$message}}
                                </p>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="produce_id" value="{{$data['records']->id}}">
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">تعديل</button>
                    <a href="{{url()->previous()}}" class="btn btn-info">رجوع</a>
                </div>
            </form>
        </div>
    </div>
</div>
</div>
@endsection