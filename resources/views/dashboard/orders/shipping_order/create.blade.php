@extends('index')
@section('content')
<div id="app" style="display:none" class="row loader">
    @include('includes.loading')

    <div class="col-md-12">
        {{--
        <div class="form-group">
            <label for="">{{__('words.choose_orders')}}</label>
            <span if="have_error" style="color:red;font-weight:700">@{{errors.value}}</span>
            <multiselect v-model="value" :options="options" :multiple="true" :close-on-select="false" :clear-on-select="false" :custom-label="dateWithAddress" :preserve-search="true" placeholder="{{__('words.choose_orders')}}" label="name" track-by="id" :preselect-first="true"></multiselect>
        </div>
        --}}
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="">{{__('words.shipping_companies')}}</label>
            <span if="have_error" style="color:red;font-weight:700">@{{errors.company}}</span>
            <select @change="getOrders()" class="form-control" v-model="shipping_company_id" id="">
                <option value="" disabled selected>{{__('words.choose_company')}}</option>
                <option :value="company.id" v-for="company in shipping_companies">@{{company.name}}</option>
            </select>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="">{{__('words.shipping_date')}}</label>
            <span if="have_error" style="color:red;font-weight:700">@{{errors.shipping_date}}</span>
            <input type="date" v-model="shipping_date" class="form-control">
        </div>
    </div>


    <span if="have_error" style="color:red;font-weight:700">@{{errors.value}}</span>
    <table class="table" v-show="value.length > 0">
        <thead>
            <tr>
                <th>رقم الطلب</th>
                <th>العميل</th>
                <th>تاريخ التوصيل</th>
            </tr>
        </thead>
        <tbody>
            
            <tr v-for="(order,index) in value" :key="index">
                    <td>@{{order.bar_code}}</td>
                    <td>@{{order.customer.name}}</td>
                    <td>@{{order.delivery_date}}</td>
            </tr>
        </tbody>
    </table>

    <div class="col-md-12">
        <a href="{{url()->previous()}}" class="btn btn-dark float-right mt-5 mr-2">{{__('words.back')}}</a>
        <button @click="saveOrder" class="btn btn-success float-right mt-5 mr-2">{{__('words.save')}}</button>
    </div>
    @include('dashboard.orders.shipping_order.vue-scripts.v-create')
</div>
@endsection