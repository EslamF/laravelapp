@extends('index')
@section('content')
<div id="app" class="row">
    <div class="col-md-12">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">انشاء اذن القص</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form role="form">
                @csrf
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">Order By</label>
                                <select v-model="type" name="type-ce" @change="" class="form-control" id=""
                                class="@error('type-ce') is-danger @enderror"
                            value="{{old('type-ce')}}">
                            
                                    <option value="" disabled seelcted>اختر النوع</option>
                                    <option value="company">شركة</option>
                                    <option value="employee">موظف</option>
                                </select>
                                @error('type-ce')
                                <p class="help is-danger">
                                    {{$message}}
                                </p>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4" v-if="type == 'employee'">
                            <div class="form-group">
                                <label for="employee">اسم الموظف
                                </label>
                                <select v-model="employee" class="form-control" id="employee"
                                class="@error('employee') is-danger @enderror"
                                value="{{old('employee')}}">
                                    <option value="" disabled seelcted>اختر اسم الموظف</option>
                                    <option value="company">شركة</option>
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
                                    <label for=""></label>
                                    <select v-model="type" class="form-control" @change="getOrderBy()"
                                    class="@error('employee') is-danger @enderror"
                                    value="{{old('employee')}}">    
                                        <option value="" disabled seelcted>اختر النوع</option>
                                        <option value="company">شركة</option>
                                        <option value="employee">موظف</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">المقاسات</label>
                                    <select v-model="type" class="form-control" @change="getOrderBy()" id=""
                                    class="@error('type-ce') is-danger @enderror"
                                    value="{{old('type-ce')}}">
                                        <option value="" disabled seelcted>اختر النوع</option>
                                        <option value="company">شركة</option>
                                        <option value="employee">موظف</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">الكميه</label>
                                    <input class="form-control" type="number">
                                </div>
                            </div>
                            <div class="form-group mt-2">
                                <button type="button" @click="addRow" class='btn btn-success mt-4'>
                                    اضافه
                                </button>
                                <button type="button" @click="deleteRow(index)" class='btn btn-danger mt-4'>
                                    حذف
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="row" v-if="type == 'company'">
                        <div class="col-md-6">
                            testt
                        </div>
                    </div>
                </div>
                
            </form>
        </div>
    </div>
</div>
@include('dashboard.orders.cutting_order.vue-script.create-script')
</div>
@endsection