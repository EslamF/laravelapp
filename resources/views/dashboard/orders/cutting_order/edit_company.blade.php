@extends('index')
@section('content')
<div id="app" class="row">
    <div id="loader" style="display: none;" class="col-md-12">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">انشاء إذن القص</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form role="form">
                @csrf
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Spreading Order</label>
                                <span style="color:red" v-if="spreading_order_error">@{{spreading_order_error}}</span>
                                <select v-model="cutting_order.spreading_out_material_order_id" class="form-control" id="" required>
                                    <option :value="cutting_order.spreading_out_material_order_id" selected>@{{cutting_order.spreading_out_material_order_id}}</option>
                                    <option :value="order.id" v-for="order in spreading_orders">@{{order.id}}</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">اسم الموظف</label>
                                <span style="color:red" v-if="employee_error">@{{employee_error}}</span>
                                <select v-model="cutting_order.user_id" class="form-control" id="" required>
                                    <option value="" disabled seelcted>Choose Employee</option>
                                    <option :value="user.id" v-for="user in users" :selected="cutting_order.user_id == user.id">@{{user.name}}</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div>
                        <div class="row" v-for="(item,index) in products">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">Product Type</label>
                                    <span style="color:red" v-if="errors[index].product_id">*@{{errors[index].product_id}}</span>
                                    <select v-model="item.type" class="form-control" id="" required>
                                        <option value="" disabled seelcted>Choose Type</option>
                                        <option :value="type.id" v-for="type in productTypes" :selected="type.id == item.type">@{{type.name}}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">Size</label>
                                    <span style="color:red" v-if="errors[index].size_id">*@{{errors[index].size_id}}</span>
                                    <select v-model="item.size" class="form-control" id="" required>
                                        <option value="" disabled seelcted>Choose Type</option>
                                        <option :value="size.id" v-for="size in sizes" :selected="size.id == item.size">@{{size.name}}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">Qty</label>
                                    <span style="color:red" v-if="errors[index].qty">*@{{errors[index].qty}}</span>
                                    <input class="form-control" v-model="item.qty" type="number" required>
                                </div>
                            </div>
                            <div class="form-group mt-2">
                                <button type="button" @click="addRow" class='btn btn-success mt-4'>
                                    اضافة
                                </button>
                                <button type="button" @click="deleteRow(index)" class='btn btn-danger mt-4'>
                                    حذف
                                </button>
                            </div>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="">Layers</label>
                            <span style="color:red" v-if="layer_error">*@{{layer_error}}</span>
                            <input class="form-control" v-model="cutting_order.layers" type="number" required>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="">Extra Return</label>
                            <input class="form-control" v-model="cutting_order.extra_returns_weight" type="number">
                        </div>
                    </div>

                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    <button type="button" :disabled="submited" @click="createOrder" class="btn btn-primary">Submit</button>
                    <a href="{{Route('cutting.outer_list')}}" class="btn btn-info">Back</a>
                </div>
            </form>
        </div>
    </div>
</div>
@include('dashboard.orders.cutting_order.vue-script.edit-script')
</div>
@endsection