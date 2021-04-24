@extends('index')
@section('content')
<div id="app" class="row">
    <div class="col-md-12">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">انشاء إذن الفرش</h3>
            </div>
            @include('includes.loading')
            <!-- /.card-header -->
            <!-- form start -->
            <form role="form" id="myForm" action="{{Route('spreading.material.update' , )}}" method="POST">
                @csrf
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12" v-if="type == 'employee'">
                            <div class="form-group">
                                <label for="user">موظف الفرش</label>
                                <select class="form-control" name="user_id" id="user">
                                    <option value="" disabled selected>حدد موظف الفرش</option>
                                    @foreach($data['users'] as $user)
                                    <option value="{{$user->id}}" {{$data['spreading']->user_id == $user->id ? 'selected':'' }}>{{$user->name}}
                                    </option>
                                    @endforeach
                                </select>
                                @error('user_id')
                                <p class="help is-danger">
                                    {{$message}}
                                </p>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-12" v-if="type == 'factory'"> 
                            <div class="form-group">
                                <label for="factory_id">المصنع</label>
                                <select class="form-control" name="factory_id" class="@error('factory_id') is-danger @enderror">
                                    <option value="" disabled selected>المصنع</option>
                                    @foreach($data['factories'] as $factory)
                                        <option value="{{$factory->id}}" {{old('factory_id') == $factory->id? 'selected':'' }}>{{$factory->name}}</option>
                                    @endforeach
                                </select>
                                @error('factory_id')
                                <p class="help text-danger">
                                    {{$message}}
                                </p>
                                @enderror
                            </div>
                        </div>

                    </div>

                    
                    {{-- <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for = "material_barcode">باركود الخامة</label> 
                                <span style="color:red">@{{material_barcode_error}}</span>
                                <input class = "form-control" @keyup.enter="findMaterial" type = "text" v-model = "material_barcode" placeholder="الباركود">
                                @error('material_barcode')
                                <p class="help is-danger">
                                    {{$message}}
                                </p>
                                @enderror
                            </div>
                        </div>
                    </div> --}}
                   

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="mq_r_code">كود الخامة</label>
                                <input type = "hidden" v-model = "material_id" name = "material_id">
                                <input disabled class="form-control" v-model="material_code" class="@error('material_id') is-danger @enderror">
                                {{--
                                <select class="form-control" @change="checkWeight()" name="material_id" ref="material_code" class="@error('material_id') is-danger @enderror">
                                    <option value="" disabled selected>حدد كود الخامة</option>
                                    @foreach($data['material'] as $material)
                                    <option value="{{$material->id}}">
                                        {{$material->mq_r_code}}</option> 
                                    @endforeach
                                </select>
                                --}}
                                @error('material_id')
                                <p class="help is-danger">
                                    {{$message}}
                                </p>
                                @enderror
                            </div>
                            <span style="color:red" v-if="errors.material_code">*@{{errors.material_code}}</span>
                        </div>
                        <div class="col-md-6">
                            <label for="weight">الوزن المتاح</label>
                            <input type="number" class="form-control" v-model="material_weight" placeholder="حدد كود الخامة لرؤية الكمية المتاحة" disabled>

                        </div>
                    </div>
                  
                    <div class = "row">

                        <div class="col-md-4">
                            <label for="vestment_barcode">بار كود التوب</label>
                            <input type="text" @keyup.enter="checkIfCanScanned" v-model="vestment_barcode" class="form-control" placeholder="بار كود التوب">
                            <span style="color:red" v-if="errors.code">*@{{errors.code}}</span>
                        </div>
                    </div>
                </div>
                <!-- /.card-body -->
                <input type="hidden" name="spreading_id" value="{{  $data['spreading']->id }}">

                <div class="card-footer">
                    <button type="button" id = "btnSubmit" @click="submitForm" class="btn btn-primary">تأكيد</button>
                    <a href="{{ url()->previous() }}" class="btn btn-info">رجوع</a>
                </div>


                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>التوب</th>
                                <th>كود التوب</th>
                                <th>الوزن</th>
                                <!--<th>حالة المنتج</th>-->
                                <th>إجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(vestment,index) in vestments">
                                <td>@{{vestment.name}}</td>
                                <td>@{{vestment.barcode}}</td>
                                <td>@{{vestment.weight}}</td>
                               
                                <!--<td>@{{status}}</td> -->
                                <td>
                                    <button type="button" @click="removeVestment(index)" class="btn btn-danger">حذف</button>
                                </td>
                                <input type = "hidden" name = "vestments[]" v-model = "vestment.id">
                            </tr>
                        </tbody>
                    </table>
                </div>

            </form>
        </div>
    </div>
</div>
</div>
@endsection
@section('footer-script')
<script src="https://cdn.jsdelivr.net/npm/vue"></script>
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<script>
    var app = new Vue({
        el: '#app',
        data: {
            type: '{{$data["spreading"]->type == "inner" ? "employee" : "factory"}}',
            material_weight: '{{$data["spreading"]->material->total_weight}}',
            button: false,
            material_code: '{{$data["spreading"]->material->mq_r_code}}', 
            material_id: '{{$data["spreading"]->material_id}}',
            error: '',
            have_error: false,
            have_value: false,
            material_barcode: '',
            material_barcode_error: '',
            codes: [],
            vestments: [],
            vestment_barcode: '',
            errors: {},
            spreading_out_order_id: '{{$data["spreading"]->id}}',

        },
        mounted() {
            //this.loader();
            this.getVestments();
        },
        methods: {
            /*loader() {
                document.getElementById('loader').style.display = 'block' 
            },*/
            getOrderBy() {
                if (this.type == 'employee') {

                    
                } else {
                    
                }
            },

            getVestments() {
                var data = {};
                data.spreading_out_order_id = this.spreading_out_order_id;
                axios.post('{{Route("spreading.material.getVestments")}}', data)
                    .then(res => {
                        this.have_error = false;
                        if (res.data != 'error') {
                            this.vestments = res.data;
                            for(var i = 0; i<this.vestments.length; i++)
                            {
                                this.codes.push(this.vestments[i].barcode.trim())
                            }
                            
                        } 

                        this.vestment_barcode = '';
                    })
                    .catch(err => {

                    })

            },
            

            checkWeight() {
                this.material_code = this.$refs['material_code'].value;
                axios.get('{{url("orders/receiving-material/check-weight")}}' + '/' + this.material_code)
                    .then(res => {
                        this.material_weight = res.data.weight;
                    })
                    .catch(err => {

                    });
            },
            findMaterial() { 

                axios.get('{{url("orders/receiving-material/getMaterialData")}}' + '/' + this.material_barcode)
                    .then(res => {
                        if(res.data != 'error')
                        {
                            console.log(res.data);
                            //this.material_code = res.data.id;
                            //$("input[name='material_id']").val(res.data.id);
                            //$("input[name='material_code']").val(res.data.mq_r_code);
                            //this.checkWeight();
                            this.material_code = res.data.mq_r_code;
                            this.material_id   = res.data.id;
                            this.material_weight = res.data.total_weight;
                            this.material_barcode = '';
                            this.material_barcode_error = '';
                        }
                        else 
                        {
                            this.material_barcode_error = 'الخامة غير موجودة';
                        }
                        //this.material_code = res.data.weight;
                    })
                    .catch(err => {

                    });
            }, 

            checkIfCanScanned() {
                console.log(this.vestments);

                this.errors.code = '';

                if (!this.material_code) {
                    console.log('errors.material_code');
                    this.errors.material_code = "*  يجب إدخال كود الخامة";
                    this.have_error = true;
                    this.vestment_barcode = '';
                }

                else 
                {
                    this.errors.material_code = "";
                    
                    var data = {};
                    data.vestment_barcode = this.vestment_barcode.trim();
                    data.material_id = this.material_id;
                    data.spreading_out_order_id = this.spreading_out_order_id;

                    
                    axios.post('{{Route("spreading.material.checkVestment")}}', data)
                        .then(res => {
                            this.have_error = false;
                            if (res.data != 'error') {
                                console.log(res.data);
                                if (!this.codes.includes(this.vestment_barcode.trim())) {
                                    this.codes.push(this.vestment_barcode.trim());
                                    this.vestments.push(res.data);
                                    
                                } else {
                                    this.have_error = true;
                                    this.errors.code = '* لا يمكن إضافة هذا التوب مره اخري'
                                }
                            } else {
                                this.have_error = true;
                                this.errors.code = '* لا يمكن إضافة هذا التوب'
                            }

                            this.vestment_barcode = '';
                        })
                        .catch(err => {

                        })
                }


            },

            removeVestment(i) {
                this.codes.splice(i, 1)
                this.vestments.splice(i, 1)
            },

            submitForm() {
                this.button = true;
                this.have_error = false;
                this.error = '';
                //var weight = document.getElementById('weight').value;
                this.validateAll();

                console.log('error : ' + this.have_error);

                if (this.codes.length > 0 && !this.have_error) 
                {
                    $("#btnSubmit").attr("disabled", true);
                    $("#loader").css("display" , "block");

                    var form = document.getElementById('myForm');
                    form.submit();
                } 
            },
            validateAll() {

                this.have_error = false;

               

                if (!this.material_code) {
                    this.errors.material_code = "*  يجب إدخال كود الخامة";
                    this.have_error = true;
                    this.vestment_barcode = '';
                }

                if (!this.vestments[0]) {
                    this.errors.code = '* يجب إضافة أتواب الفرش'
                    this.have_error = true;
                    this.have_value = false;
                }
            }
        }

    })
</script>
@endsection