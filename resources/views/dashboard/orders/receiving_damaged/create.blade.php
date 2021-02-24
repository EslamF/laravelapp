@extends('index')
@section('content')
<div class="row" id = "app">
    <div class="col-md-12">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">إذن إستلام منتج تالف</h3>
            </div>
            @include('includes.loading')
            <!-- /.card-header -->
            <!-- form start -->
            <!--<form role="form" action="{{Route('receiving.damaged_product.store')}}" method="POST"> -->
                @csrf
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group">
                                <label for="weight"> كود المنتج</label>
                                <span v-if="have_error" style="color:red;font-weight:700">@{{errors.exists}}</span>
                                <input type="text" class="form-control @error('prod_code') is-danger @enderror "
                                      v-model="prod_code" placeholder="ادخل  كود المنتج" @keyup.enter="checkIfExists"
                                      value="{{old('prod_code')}}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="name">الحالة</label>
                                <span style="color:red" v-if="error.damage_type">*@{{error.damage_type}}</span>
                                <select class="form-control"  v-model="damage_type"
                                class="@error('damage_type') is-danger @enderror">
                                    <!--<option value="" disabled selected>تحديد الجودة</option>-->
                                            <option value="">صالح</option>
                                            <option value="ironing">كي</option>
                                            <option value="tailoring">خياطة</option>
                                            <option value="dyeing">صباغة</option>
                                </select>
                                @error('damage_type')
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
                    <button type="button" id = "btnSubmit" @click="send"  class="btn btn-primary">إضافة</button>
                    <a href="{{url()->previous()}}" class="btn btn-info">رجوع</a>
                </div>
            <!--</form> -->
        </div>

        <div v-if="codes.length > 0">
            <h2 class = "text-center">عدد المنتجات : @{{codes.length}}</h2>
            <table class="table table-borded">
                <thead>
                    <tr>
                        <th class = "text-center">كود المنتجات</th>
                        <th class = "text-center">المصنع</th>
                        <th class = "text-center">حذف</th>
                    </tr>
                </thead>
                <tbody>
                    <!--
                    <tr v-for="(code,index) in codes">
                        <td class = "text-center">@{{code}}</td>
                        <td class = "text-center"><button type="button" @click="removeCode(index)" class="btn btn-danger">حذف</button></td>
                    </tr>
                    -->

                    <tr v-for="(product,index) in products">
                        <td class = "text-center">@{{product.product_code}}</td>
                        <td class = "text-center">@{{product.factory}}</td>
                        <td class = "text-center"><button type="button" @click="removeCode(index)" class="btn btn-danger">حذف</button></td>
                    </tr>
                </tbody>
            </table>
        
    </div>
    </div>
</div>
@include('dashboard.orders.receiving_damaged.v-script.vue-create')

@endsection