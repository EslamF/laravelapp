@extends('index')
@section('content')
<div id="app" class="row">
    <div class="col-md-12">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">شحن المنتج الي الشركة </h3>
            </div>
            @include('includes.loading')
            <!-- /.card-header -->
            <!-- form start -->
            <!-- <form role="form" onSubmit="return false" name="myform2" action="{{Route('send.end_product.store')}}" method="POST"> -->
            <!-- @csrf -->
            <div class="card-body">
                <div class="row">
                    
                    <div class="col-md-12">
                        <span v-if="error != ''" style="color:red;font-weight:700">@{{error}}</span>
                        <div class="form-group">
                            <label for="name">البار كود</label>
                            <span v-if="have_error" style="color:red;font-weight:700">@{{errors.bar_code}}</span>
                            <input type = "text" v-model="bar_code" class = "form-control">
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="name">موظف الشحن</label>
                            <span v-if="have_error" style="color:red;font-weight:700">@{{errors.user}}</span>
                            <select class="form-control" v-model="user_id"> 
                                <option value="" disabled selected>اختر موظف</option>
                                <option :value="employee.id" v-for="employee in employees"   >@{{employee.name}}</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="name">المنتجات</label>
                            <span v-if="have_error" style="color:red;font-weight:700">@{{errors.exists}}</span>
                            <input type="text" class="form-control" v-model="product_code" @keyup.enter="checkIfSorted">
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.card-body -->

            <div class="card-footer">
                <button type="button" id = "btnSubmit" @click="send" class="btn btn-primary">تعديل</button>
                <a href="{{url()->previous()}}" class="btn btn-info">رجوع</a>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <table class="table" v-if="codes.length > 0">
                    <thead>
                        <tr>
                            <th class="col-md-7">كود المنتجات</th>
                            <th class="col-md-3">حذف</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(code,index) in codes">
                            <td class="col-md-7">@{{code}}</td>
                            <td class="col-md-3"><button type="button" @click="removeCode(index)" class="btn btn-danger">حذف</button></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @include('dashboard.orders.send_end_product.v-script.vue-edit')
</div>

@endsection