@extends('index')
@section('content')
<div id="app" class="row">
    <div class="col-md-12">
        <div class="form-group">
            <label for="">Choose orders</label>
            <span if="have_error" style="color:red;font-weight:700">@{{errors.value}}</span>
            <multiselect v-model="value" :options="options" :multiple="true" :close-on-select="false" :clear-on-select="false" :custom-label="dateWithAddress" :preserve-search="true" placeholder="Choose Orders" label="name" track-by="id" :preselect-first="true"></multiselect>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="">Shipping Companies</label>
            <span if="have_error" style="color:red;font-weight:700">@{{errors.company}}</span>
            <select class="form-control" v-model="shipping_company_id" id="">
                <option value="" disabled selected>Choose factory</option>
                <option :value="company.id" v-for="company in shipping_companies">@{{company.name}}</option>
            </select>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="">Shipping Date</label>
            <span if="have_error" style="color:red;font-weight:700">@{{errors.shipping_date}}</span>
            <input type="date" v-model="shipping_date" class="form-control">
        </div>
    </div>
    <div class="col-md-12">
        <a href="{{url()->previous()}}" class="btn btn-dark float-right mt-5 mr-2">Back</a>
        <button @click="saveOrder" class="btn btn-success float-right mt-5 mr-2">Save</button>
    </div>
    @include('dashboard.orders.shipping_order.vue-scripts.v-create')
</div>
@endsection