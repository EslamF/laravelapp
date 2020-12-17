@extends('index')
@section('content')
<div id="app" class="row">
    <div class="col-md-12">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">بيانات إذن الفرش</h3>
            </div>
            @include('includes.loading')
            <!-- /.card-header -->
            <!-- form start -->
            <form role="form" id="myForm" action="{{Route('spreading.material.update')}}" method="POST">
                @csrf
                <div class="card-body">
                    @include('includes.flash-message')
                    <div class="row">
                        <div class="col-md-12">
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
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="mq_r_code">كود الخامة</label>
                                <select class="form-control" name="material_id" id="material_code" ref="material_code" class="@error('material_id') is-danger @enderror">
                                    <option value="" disabled selected>حدد كود الخامة</option>
                                    @foreach($data['material'] as $material)
                                    <option value="{{$material->id}}" {{$data['spreading']->material_id == $material->id ? 'selected':'' }}>
                                        {{$material->mq_r_code}}</option>
                                    @endforeach
                                </select>
                                @error('material_id')
                                <p class="help is-danger">
                                    {{$message}}
                                </p>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="weight">الوزن المتاح</label>
                            <input type="number" class="form-control" v-model="material_weight" placeholder="حدد كود الخامة لرؤية الكمية المتاحة" disabled>

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="weight">الوزن</label>
                                <span v-if="have_error" style="color:red">@{{error}}</span>
                                <input type="number" ref="old_weight" class="form-control" value="{{old('weight') ??  $data['spreading']->weight}}" name="weight" id="weight" placeholder="ادخل الوزن" class="@error('weight') is-danfer @enderror ">
                                @error('weight')
                                <p class="help is-danger">
                                    {{$message}}
                                </p>
                                @enderror
                                <input type="hidden" name="spreading_id" value="{{  $data['spreading']->id }}">

                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                    <button type="button" id = "btnSubmit" @click="submitForm" class="btn btn-primary">تأكيد</button>
                    <a href="{{ url()->previous() }}" class="btn btn-info">رجوع</a>
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
            material_weight: '',
            button: false,
            material_code: '',
            error: '',
            have_error: false,
            old_weight: ''
        },
        mounted() {
            //this.loader();
            this.getSize();
        },
        methods: {
            /*loader() {
                document.getElementById('loader').style.display = 'block'
            },*/
            checkWeight() {
                this.material_code = this.$refs['material_code'].value;
                axios.get('{{url("orders/receiving-material/check-weight")}}' + '/' + this.material_code)
                    .then(res => {
                        this.material_weight = res.data.weight;
                    })
                    .catch(err => {
                    });
            },
            getSize() {
                this.material_code = this.$refs['material_code'].value;
                axios.get('{{url("orders/receiving-material/check-weight")}}' + '/' + this.material_code)
                    .then(res => {
                        this.material_weight = res.data.weight;
                    })
                    .catch(err => {

                    });
                this.old_weight = this.$refs['old_weight'].value;
            },
            submitForm() {
                this.button = true;
                this.have_error = false;
                this.error = '';
                var weight = document.getElementById('weight').value;

                if (weight <= this.material_weight + parseInt(this.old_weight)) {
                    var form = document.getElementById('myForm');
                    form.submit();

                    $("#btnSubmit").attr("disabled", true);
                    $("#loader").css("display" , "block");
                } else {
                    this.error = 'الكمية غير متوفرة'
                    this.have_error = true;
                    this.button = false;
                }
            }
        }

    })
</script>
@endsection