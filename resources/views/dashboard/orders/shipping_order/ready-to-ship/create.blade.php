@extends('index')
@section('content')
<div id="app" style="display: none;" class="row loader">
    <div v-if="have_err" class="col-md-12 alert alert-danger">
        <ul>
            <li v-if="errors.order" class=>@{{errors.order}}</li>
            <li v-if="errors.tags">@{{errors.tags}}</li>
        </ul>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="">{{__('words.add_orders')}}</label>
            {{-- <input-tag v-model="tags" @change="checkIfExist()"></input-tag> --}}
            <select class = "select2" id = "tags_selected" multiple>

                <option :value="buy_order" :key="buy_order" v-for="buy_order in buy_orders">@{{buy_order}} </option>
             
            </select>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="">{{__('words.shipping_number')}}</label>
            <input type="text" :value="order.company_name + ' --- ' + order.shipping_date" class="form-control" id="" disabled>
            <!-- <select name="" class="form-control" @change="getBuyOrders" v-model="order.id" id="">
                <option value="" disabled selected>Choose Order</option>
                <option :value="order.id" v-for="order in orders">Company: @{{order.company_name}} --- Date: @{{order.shipping_date}} </option>
            </select> -->
        </div>
    </div>
    <div class="col-md-12 mt-5">
        <a href="{{url()->previous()}}" class="btn btn-dark float-right ml-2">{{__('words.back')}}</a>
        <button @click="packageOrders" class="btn btn-success float-right">{{__('words.save')}}</button>
    </div>
    @include('dashboard.orders.shipping_order.ready-to-ship.vue-script.v-create')
</div>
@endsection