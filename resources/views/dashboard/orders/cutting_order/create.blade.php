@extends('index')
@section('content')
<div id="app" class="row">
    <div class="col-md-12">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">انشاء اذن القص</h3>
            </div>
            @include('includes.loading')
            <!-- /.card-header -->
            <!-- form start --> 
            <form role="form">
                
                @csrf
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="">جهة</label>
                                <select v-model="type" @change="getOrderBy()" class="form-control" id="" required>
                                    <option value="" disabled seelcted>اختر النوع</option>
                                    <option value="company">شركة</option>
                                    <option value="employee">موظف</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="form-group">
                                <label for="">اذن الفرش</label>
                                
                                <select v-model="spreading_out_material_order_id" class="form-control" id="" required>
                                    <option value="" disabled seelcted>حدد اذن الفرش</option>
                                    <option :value="order.id" v-for="order in spreading_orders">@{{order.id + ' - ' +  order.spreadinguser.name + ' - ' + order.created_at}}</option>
                                </select>
                                <span style="color:red" v-if="spreading_order_error">@{{spreading_order_error}}</span>
                            </div>
                        </div>
                       
                        <div class="col-md-3" v-if="type == 'employee'">
                            <div class="form-group">
                                <label for="emp">اسم الموظف</label>
                                <span style="color:red" v-if="employee_error">@{{employee_error}}</span>
                                <select v-model="employee_id" class="form-control" id="emp" required>
                                    <option value="" disabled seelcted>حدد اسم الموظف</option>
                                    <option :value="user.id" v-for="user in users">@{{user.name}}</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3" v-if="type == 'company'">
                            <div class="form-group">
                                <label for="company"> نوع الشركة</label>
                                <select v-model="factory_type_id" @change="getFactory(factory_type_id)" class="form-control" id="company" required>
                                    <option value="" disabled seelcted>حدد نوع الشركة</option>
                                    <option :value="type.id" v-for="type in factoryTypes">@{{type.name}}</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3" v-if="type == 'company'">
                            <div class="form-group">
                                <label for="">اسم المصنع</label>
                                <span style="color:red" v-if="factory_error">@{{factory_error}}</span>
                                <select v-model="factory_id" class="form-control" id="" required>
                                    <option value="" disabled seelcted>حدداسم المصنع</option>
                                    <option :value="factory.id" v-for="factory in factories">@{{factory.name}}</option>
                                </select>
                                @error('employee')
                                <p class="help is-danger">
                                    {{$message}}
                                </p>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div v-if="type == 'employee'">
                        <div class="row" v-for="(item,index) in items">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">نوع المنتج</label>
                                    <span style="color:red" v-if="errors[index].product_type_id">*@{{errors[index].product_type_id}}</span>
                                    <select v-model="item.product_type_id" class="form-control" id="" required>
                                        <option value="" disabled seelcted>حدد نوع المنتج</option>
                                        <option :value="type.id" v-for="type in productTypes">@{{type.name}}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">المقاس</label>
                                    <span style="color:red" v-if="errors[index].size_id">*@{{errors[index].size_id}}</span>
                                    <select v-model="item.size_id" class="form-control" id="" required>
                                        <option value="" disabled seelcted>المقاس</option>
                                        <option :value="size.id" v-for="size in sizes">@{{size.name}}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">الكمية</label>
                                    <span style="color:red" v-if="errors[index].qty">*@{{errors[index].qty}}</span>
                                    <input class="form-control" v-model="item.qty" type="number" required>
                                </div>
                            </div>
                            <div class="form-group mt-2">
                                <button type="button" style="margin-right:10px " @click="addRow" class='btn btn-success mt-4'>
                                    إضافة
                                </button>
                                <button type="button" @click="deleteRow(index)" class='btn btn-danger mt-4'>
                                    حذف
                                </button>
                            </div>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="layer">عدد الراقات</label>
                            <span style="color:red" id="layer" v-if="layer_error">*@{{layer_error}}</span>
                            <input class="form-control" v-model="layers" type="number" required>
                        </div>
                        <div class="form-group col-md-12">
                            <label for=""> الزيادة المرتجعة</label>
                            <input class="form-control" v-model="extra_returns_weight" type="number">
                        </div>
                    </div>

                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    <button type="button" id = "btnSubmit" @click="createOrder" class="btn btn-primary">إنشاء</button>
                    <a href="{{url()->previous()}}" class="btn btn-info">رجوع</a>
                </div>
            </form>
        </div>
    </div>
</div>
@include('dashboard.orders.cutting_order.vue-script.create-script')
</div>
@endsection