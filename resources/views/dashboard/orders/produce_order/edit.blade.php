@extends('index')
@section('content')
<div id="app" class="row">
    <div class="col-md-12">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">التعديل على إذن التصنيع </h3>
            </div>

            @include('includes.loading')
            <!-- /.card-header -->
            <!-- form start -->

            <form role="form" action="{{Route('produce.order.update')}}" method="POST">
                @csrf
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="mq_r_code">نوع المصنع</label>
                                <span style="color:red" v-if="error.factory_id">*@{{error.factory_type_id}}</span>
                                <select class="form-control" v-model="factory_type_id" @change="getFactory()" id="user">
                                    <option value="" disabled selected>حدد نوع المصنع</option>
                                    <option :value="factory.id" v-for="factory in factory_types">@{{factory.name}}</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="mq_r_code">المصنع</label>
                                <span style="color:red" v-if="error.factory_id">*@{{error.factory_id}}</span>
                                <select class="form-control" v-model="factory_id" id="user">
                                    <option value="" disabled selected>حدد اسم المصنع</option>
                                    <option :value="factory.id" v-for="factory in factories" :selected="factory_id == factory.id">@{{factory.name}}</option>

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
                                <label for="weight">تاريخ الإستلام</label>
                                <span style="color:red" v-if="error.receiving_date">*@{{error.receiving_date}}</span>
                                <input type="date" class="form-control" v-model="receiving_date" id="weight" placeholder="تاريخ الإستلام">
                            </div>
                        </div>
                    </div>

                    <table class="table" v-show="available_products.length > 0">
                        <p v-if = "!have_value"  v-show="available_products.length > 0" style = "color:red">يجب إدخال منتجات</p>
                        <thead>
                            <tr>
                                <th>المنتج</th>
                                <th>المقاس</th>
                                <th>الكمية المتاحة</th>
                                <th>الكمية المطلوبة</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                            <tr v-for="(product,index) in available_products" :key="index">

                                    <td>@{{product.name}}</td>
                                    <td>@{{product.size}}</td>
                                    <td>@{{product.quantity}}</td>
                                    <td>
                                        <span v-if="have_error" style="color:red">@{{product.err}}</span>
                                        {{--<span v-if="have_error" style="color:red">@{{available_products[index].error_qty}}</span>--}}
                                        <input type="number" min="0" :max = "product.quantity" style="width:60%" class="form-control" v-model="product.required_quantity" v-bind:id="'product' + index">
                                    </td>
                            </tr>
                        </tbody>
                    </table>

                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                    <button type="button" id = "btnSubmit" @click="store" class="btn btn-primary">تعديل</button>
                    <a href="{{url()->previous()}}" class="btn btn-info">رجوع</a>
                </div>
            </form>
        </div>
    </div>
</div>
@include('dashboard.orders.produce_order.v-script.edit-script')
</div>
@endsection