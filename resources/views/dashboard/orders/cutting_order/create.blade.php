@extends('index')
@section('content')
<div id="app" class="row">
    <div class="col-md-12">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Add Cutting Material Order</h3>
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
                                <select v-model="type" @change="" class="form-control" id="">
                                    <option value="" disabled seelcted>Choose Type</option>
                                    <option value="company">Company</option>
                                    <option value="employee">Employee</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4" v-if="type == 'employee'">
                            <div class="form-group">
                                <label for="">Employee Name</label>
                                <select v-model="employee" class="form-control" id="">
                                    <option value="" disabled seelcted>Choose Employee</option>
                                    <option value="company">Company</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div v-if="type == 'employee'">
                        <div class="row" v-for="(item,index) in items">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">Product Type</label>
                                    <select v-model="type" class="form-control" @change="getOrderBy()">
                                        <option value="" disabled seelcted>Choose Type</option>
                                        <option value="company">Company</option>
                                        <option value="employee">Employee</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">Size</label>
                                    <select v-model="type" class="form-control" @change="getOrderBy()" id="">
                                        <option value="" disabled seelcted>Choose Type</option>
                                        <option value="company">Company</option>
                                        <option value="employee">Employee</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">Qty</label>
                                    <input class="form-control" type="number">
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
                    </div>
                    <div class="row" v-if="type == 'company'">
                        <div class="col-md-6">
                            testt
                        </div>
                    </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <a href="{{url()->previous()}}" class="btn btn-info">Back</a>
                </div>
            </form>
        </div>
    </div>
</div>
@include('dashboard.orders.cutting_order.vue-script.create-script')
</div>
@endsection