@extends('index')
@section('content')
<div id="app" class="row">
    <div id="loader" style="display: none;" class="col-md-12">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">تعديل في إذن القص</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form role="form">
                @csrf
                <div class="card-body">
                    <div class="row" v-for="(item,index) in items">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="">Product Type</label>
                                <span style="color:red" v-if="errors[index].product_type_id">*@{{errors[index].product_type_id}}</span>
                                <select v-model="item.product_type_id" class="form-control" id="">
                                    <option value="" disabled seelcted>Choose Type</option>
                                    <option :value="type.id" v-for="type in productTypes">@{{type.name}}</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="">Size</label>
                                <span style="color:red" v-if="errors[index].size_id">*@{{errors[index].size_id}}</span>
                                <select v-model="item.size_id" class="form-control" id="">
                                    <option value="" disabled seelcted>Choose Type</option>
                                    <option :value="size.id" v-for="size in sizes">@{{size.name}}</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="">Qty</label>
                                <span style="color:red" v-if="errors[index].qty">*@{{errors[index].qty}}</span>
                                <input class="form-control" v-model="item.qty" type="number">
                            </div>
                        </div>
                        <div class="form-group mt-2">
                            <button type="button" @click="addRow" class='btn btn-success mt-4'>
                                Add
                            </button>
                            <button type="button" @click="deleteRow(index)" class='btn btn-danger mt-4'>
                                remove
                            </button>
                        </div>
                    </div>
                    <div class="form-group col-md-12">
                        <label for="">Layers</label>
                        <input class="form-control" v-model="layers" type="number">
                    </div>
                    <div class="form-group col-md-12">
                        <label for="">Extra Return</label>
                        <input class="form-control" v-model="extra_returns_weight" type="number">
                    </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    <button type="button" @click="addToOrder" class="btn btn-primary">تأكيد التعديل</button>
                    <a href="{{url()->previous()}}" class="btn btn-info">رجوع</a>
                </div>
            </form>
        </div>
    </div>
</div>
@include('dashboard.orders.cutting_order.vue-script.add-to-order-script')
</div>
@endsection