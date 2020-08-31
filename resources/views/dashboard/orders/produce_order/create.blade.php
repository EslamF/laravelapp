@extends('index')
@section('content')
<div id="app" class="row">
    <div class="col-md-12">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">انشاء اذن تصنيع </h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->

            <form role="form" action="{{Route('produce.order.store')}}" method="POST">
                @csrf
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="mq_r_code">اذن القص</label>
                                <span style="color:red" v-if="error.cutting_order_id">*@{{error.cutting_order_id}}</span>
                                <select class="form-control" @change="getFactoryByCuttingId(cutting_order_id)" v-model="cutting_order_id" id="user">
                                    <option value="" disabled selected>Select Order id</option>
                                    <option :value="order.id" v-for="order in cutting_orders">@{{order.id}}</option>
                                </select>
                                @error('cutting_order_id')
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
                                <label for="mq_r_code">المصنع</label>
                                <span style="color:red" v-if="error.factory_id">*@{{error.factory_id}}</span>
                                <select class="form-control" v-model="factory_id" id="user">
                                    <option value="" disabled selected>حدداسم المصنع</option>
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
                                <label for="weight">تاريخ الاستلام</label>
                                <span style="color:red" v-if="error.receiving_date">*@{{error.receiving_date}}</span>
                                <input type="date" class="form-control" v-model="receiving_date" id="weight" placeholder="تاريخ الاستلام">
                            </div>
                        </div>
                    </div>

                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                    <button type="button" @click="store" class="btn btn-primary">تسجيل</button>
                    <a href="{{url()->previous()}}" class="btn btn-info">رجوع</a>
                </div>
            </form>
        </div>
    </div>
</div>
@include('dashboard.orders.produce_order.v-script.create-script')
</div>
@endsection