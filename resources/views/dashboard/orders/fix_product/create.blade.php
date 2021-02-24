@extends('index')
@section('content')
<div class="row" id = "app">
    <div class="col-md-12">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">إذن خروج منتجات تالفة</h3>
            </div>
            @include('includes.loading')
            <!-- /.card-header -->
            <!-- form start -->
            {{-- <form role="form" action="{{Route('fix.product.store')}}" method="POST"> --}}
                @csrf
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group">
                                <label for="weight"> كود المنتج</label>
                                <span v-if="have_error" style="color:red;font-weight:700">@{{errors.exists}}</span>
                                <input type="text" class="form-control @error('prod_code') is-danger @enderror "
                                      v-model="prod_code" placeholder="ادخل  كود المنتج" @keyup.enter="checkIfSortedAndDamaged"
                                      value="{{old('prod_code')}}">
                            @error('prod_code')
                            <p class="help is-danger">
                                {{$message}}
                            </p>
                            @enderror
                            </div>
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="mq_r_code">نوع المصنع</label>
                                <span style="color:red" v-if="error.factory_id">*@{{error.factory_type_id}}</span>
                                <select class="form-control" v-model="factory_type_id" @change="getFactory()">
                                    <option value="" disabled selected>حدد نوع المصنع</option>
                                    <option :value="factory.id" v-for="factory in factory_types">@{{factory.name}}</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="mq_r_code">المصنع</label>
                                <span style="color:red" v-if="error.factory_id">*@{{error.factory_id}}</span>
                                <select class="form-control" v-model="factory_id" id="user">
                                    <option value="" disabled selected>حدد اسم المصنع</option>
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
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                    <button type="button" id = "btnSubmit" @click="send" class="btn btn-primary">إضافة</button>
                    <a href="{{url()->previous()}}" class="btn btn-info">رجوع</a>
                </div>
            {{--</form> --}}
        </div>


        <div v-if="codes.length > 0">
                <h2 class = "text-center">عدد المنتجات : @{{codes.length}}</h2>
                <table class="table table-borded">
                    <thead>
                        <tr>
                            <th class = "text-center">كود المنتجات</th>
                            <th class = "text-center">حذف</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(code,index) in codes">
                            <td class = "text-center">@{{code}}</td>
                            <td class = "text-center"><button type="button" @click="removeCode(index)" class="btn btn-danger">حذف</button></td>
                        </tr>
                    </tbody>
                </table>
        </div>
    
    </div>

    @include('dashboard.orders.fix_product.v-script.vue-create')
</div>

@push('scripts')
<script>
    
    /*$("#factory_type_id").change(function(){

        var id = $(this).val();
        console.log(id);
        //{{url("factory/get-by-id")}}
        if(id)
        {
            $.ajax({
                    url:"{{ url('factory/get-by-id') }}"+'/'+id,
                    method:"GET",
                    success : function(data)
                    {
                        $("#factory_id_select").empty();
                        $.each(data , function(index , factory){
                            
                            $("#factory_id_select").append('<option value = "' + factory.id + '"> ' + factory.name + ' </option>');
                        });
                        
                        //console.log(data);
                    }
                })
        }

        else 
        {
            $("#factory_id_select").empty();
        }

    });*/
</script>
@endpush

@endsection