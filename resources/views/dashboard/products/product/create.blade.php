@extends('index')
@section('content')
<div id="app" class="row">
    <div class="col-md-12">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">انشاء منتج</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form role="form" action="{{Route('product.store')}}" method="POST">
                @csrf
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="factory">Receiving Order</label>
                                <select class="form-control" @change="getCuttingOrderProduct()" v-model="receiving_order_id" id="factory">
                                    <option value="" disabled selected>Select Receiving Order Number</option>
                                    <option value="{{$order->id}}">{{$order->id}}</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="description">الوصف</label>
                                <textarea class="form-control" name="description" id="description" placeholder="ادخل الوصف"></textarea>
                            </div>
                        </div>
                    </div>
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
@incluce('dashboard.products.product.v-script.vue-create')
</div>
@endsection