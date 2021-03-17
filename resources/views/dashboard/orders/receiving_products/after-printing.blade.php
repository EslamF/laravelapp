@extends('index')
@section('content')
<div class="row" id = "app">
    <div class="col-md-12">
        <div class="card ">
            <div class="card-header">
                    <div class="row">
                        <div class="col-md-3">
                            <h3 class="card-title"> إستلام المنتجات</h3>
                        </div>

                        @include('includes.loading')
                        
                        <div class="col-md-4">
                            <input type="text" @keyup.enter="checkIfCanReceived" v-model="prod_code" class="form-control" placeholder="كود المنتج">
                            <span style="color:red" v-if="errors.code">*@{{errors.code}}</span>
                        </div>

                        <div class="col-md-1">
                            <button id = "btnSubmit" @click="send" class="btn btn-success float-right">إستلام</button>
                        </div>
                    </div>
                
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <p style = "color:rgb(158, 40, 40);">عدد المنتجات التي يجب إضافتها : @{{number_of_products}}</p>
                <span style="color:red" v-if="errors.number_of_products">*@{{errors.number_of_products}}</span>
                <table class="table ">
                    <thead>
                        <tr>
                            <th>كود المنتج</th>
                            <th>كود الخامة</th>
                            <th>المنتج</th>
                            <th>إجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(product,index) in products">
                            <td>@{{product.prod_code}}</td>
                            <td>@{{product.material.mq_r_code}}</td>
                            <td>@{{product.product_type.name + ' ' + product.size.name }}</td>
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
@include('dashboard.orders.receiving_products.v-script.after-printing-script')

@endsection