@extends('index')
@section('content')
<div id="app" class="row">
    <div v-if="have_err" class="col-md-12 alert alert-danger">
        <ul>
            <li v-if="errors.order" class=>@{{errors.order}}</li>
            <li v-if="errors.tags">@{{errors.tags}}</li>
        </ul>
    </div>
    <div class="col-md-8">
        <div class="form-group">
            <label for="">Add Orders</label>
            <input-tag v-model="tags" @change="checkIfExist()"></input-tag>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label for="">Shipping Orders</label>
            <select name="" class="form-control" @change="getBuyOrders" v-model="order.id" id="">
                <option value="" disabled selected>Choose Order</option>
                <option :value="order.id" v-for="order in orders">@{{order.shipping_code}}</option>
            </select>
        </div>
    </div>
    <div class="col-md-12 mt-5">
        <a href="{{url()->previous()}}" class="btn btn-dark float-right ml-2">Back</a>
        <button @click="packageOrders" class="btn btn-success float-right">Save</button>
    </div>
    @include('dashboard.orders.shipping_order.ready-to-ship.vue-script.v-create')
</div>
@endsection