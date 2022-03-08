@extends('index')
@section('content')
<div id="app" class="row">
    @include('includes.loading')

    <div class="col-md-4">
        <div class="form-group">
            <label for="">{{__('words.choose_orders')}}</label>
            <span if="have_error" style="color:red;font-weight:700">@{{errors.value}}</span>

            <select class = "select2" multiple>
                <option :value="buy_order.bar_code" :key="buy_order.bar_code" v-for="buy_order.bar_code in value">@{{buy_order}} </option>
            </select>
            {{-- <multiselect v-model="value" :options="options" :multiple="true" :close-on-select="false" :clear-on-select="false" :preserve-search="true" placeholder="{{__('words.choose_orders')}}" label="bar_code" track-by="bar_code" :preselect-first="true"></multiselect> --}}
        </div>
    </div>

    <div class="col-md-4">
        <div class="form-group">
            <label for="">{{__('words.shipping_company')}}</label>
            <span if="have_error" style="color:red;font-weight:700">@{{errors.company}}</span>
            <select class="form-control" v-model="order.shipping_company_id" id="">
                <option value="" disabled>{{__('words.choose_company')}}</option>
                <option :value="company.id" v-for="company in shipping_companies" :selected="company.id == order.shipping_company_id">@{{company.name}}</option>
            </select>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label for="">{{__('words.shipping_date')}}</label>
            <span if="have_error" style="color:red;font-weight:700">@{{errors.shipping_date}}</span>
            <input type="date" v-model="order.shipping_date" class="form-control">
        </div>
    </div>
    <div class="col-md-12">
        <a href="{{url()->previous()}}" class="btn btn-dark float-right mt-5 mr-3">{{__('words.back')}}</a>
        <button @click="update" class="btn btn-success float-right mt-5 mr-3">{{__('words.edit')}}</button>
    </div>
    @include('dashboard.orders.shipping_order.vue-scripts.v-edit')
</div>
@endsection