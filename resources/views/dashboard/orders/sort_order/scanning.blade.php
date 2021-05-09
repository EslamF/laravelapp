@extends('index')
@section('content')
<div class="row" id = "app">
    <div class="col-md-12">
        <div class="card ">
            <div class="card-header">
                    <div class="row">
                        <div class="col-md-3">
                            <h3 class="card-title">  فرز المنتجات</h3>
                        </div>

                        @include('includes.loading')
                        
                        <div class="col-md-4">
                            <input type="text" @keyup.enter="checkIfCanSorted" v-model="prod_code" class="form-control" placeholder="كود المنتج">
                            <span style="color:red" v-if="errors.code">*@{{errors.code}}</span>
                        </div>
                        <div class="col-md-3">
                            <select v-model="status"  class="form-control" id="">
                                <option value="" disabled selected>حدد حالة المنتج</option>
                                <option value="fine">صالح</option>
                                <option value="ironing">كي</option>
                                <option value="tailoring">خياطة </option>
                                <option value="dyeing">صباغة</option>
                            </select>
                            <span style="color:red" v-if="errors.status">*@{{errors.status}}</span>
                        </div>
                        <!--<input type="hidden" name="sort_id" value="{{$sort_order_id}}" id=""> -->
                        <div class="col-md-1">
                            <button id = "btnSubmit" @click="send" class="btn btn-success float-right">إضافة</button>
                        </div>
                    </div>
                
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <h5>عدد المنتجات : @{{products.length}}</h5>
                <table class="table ">
                    <thead>
                        <tr>
                            <th>كود المنتج</th>
                            <!--<th>حالة المنتج</th>-->
                            <th>إجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(product,index) in products">
                            <td>@{{product.code}}</td>
                           
                            <!--<td>@{{status}}</td> -->
                            <td>
                                <button type="button" @click="removeProduct(index)" class="btn btn-danger">حذف</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
            <div class="card-footer clearfix">
                
            </div>
        </div>
        <!-- /.card -->
    </div>
</div>
@include('dashboard.orders.sort_order.v-script.vue-scanning')

@endsection