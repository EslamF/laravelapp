@extends('index')
@section('content')
<div id="app" class="row">
    <div class="col-md-12">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">إذن إستلام الخامات</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form role="form" id="myForm" action="{{Route('receiving.material.store')}}" method="POST">
                @csrf
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="mq_r_code">كود الخامة</label>
                                <input type="text" class="form-control" name="mq_r_code" id="mq_r_code" placeholder="كود الخامة" class="@error('mq_r_code') is-danger @enderror" value="{{old('mq_r_code')}}">
                                @error('mq_r_code')
                                <p class="help is-danger">
                                    {{$message}}
                                </p>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="bill_number"> الرقم المرجعي الفتورة</label>
                                <input type="text" class="form-control" name="bill_number" id="bill_number" placeholder=" الرقم المرجعي الفتورة" class="@error('bill_number') is-danger @enderror" value="{{old('bill_number')}}">
                                @error('bill_number')
                                <p class="help is-danger">
                                    {{$message}}
                                </p>
                                @enderror
                            </div>

                        </div>
                    </div>
                    <div class="row">

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="user">المشتري</label>
                                <select class="form-control" name="buyer_id" id="user" class="@error('buyer_id') is-danger @enderror">
                                    <option disabled selected>حدد اسم المشتري</option>
                                    @foreach($data['users'] as $user)
                                    <option value="{{$user->id}}" {{old('buyer_id') == $user->id ? 'selected': '' }}>{{$user->name}}</option>
                                    @endforeach
                                </select>
                                @error('buyer_id')
                                <p class="help is-danger">
                                    {{$message}}
                                </p>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="supplier">المورد</label>
                                <select class="form-control" name="supplier_id" id="supplier" class="@error('supplier_id') is-danger @enderror">
                                    <option value="" disabled selected>حدد اسم المورد</option>
                                    @foreach($data['suppliers'] as $supplier)
                                    <option value="{{$supplier->id}}" {{old('supplier_id') == $supplier->id ? 'selected': '' }}>{{$supplier->name}}</option>
                                    @endforeach
                                </select>
                                @error('supplier_id')
                                <p class="help is-danger">
                                    {{$message}}
                                </p>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>النوع</label>
                                <select id="type" class="form-control" name="type">
                                    <option value="" disabled selected>حدد النوع</option>
                                    <option value="material" {{old('type') == 'material' ?  'selected' : ''}}>خامة</option>
                                    <option value="accessory" {{old('type') == 'accessory' ?  'selected' : ''}}>اكسسوار</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row" id="material" style="display:none">
                        <div class="col-md-4">
                            <div class="form-group">ٍ
                                <label for="weight">الوزن</label>
                                <input type="number" class="form-control" name="weight" id="weight" placeholder="ادخل الوزن" class="@error('weight') is-danger @enderror" value="{{old('weight')}}">
                                @error('weight')
                                <p class="help is-danger">
                                    {{$message}}
                                </p>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="material_types">نوع الخامة</label>
                                <select class="form-control" name="material_type_id" id="material_types" class="@error('material_type_id') is-danger @enderror">
                                    <option value="" disabled selected>اختر نوع الخامة</option>
                                    @foreach($data['material_types'] as $type)
                                    <option value="{{$type->id}}" {{old('material_type_id') == $type->id ? 'selected': '' }}>{{$type->name}}</option>
                                    @endforeach
                                </select>
                                @error('material_type_id')
                                <p class="help is-danger">
                                    {{$message}}
                                </p>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="color">اللون</label>
                                <input type="text" class="form-control" name="color" id="color" placeholder="ادخل اللون" class="@error('color') is-danger @enderror" value="{{old('color')}}">
                                @error('color')
                                <p class="help is-danger">
                                    {{$message}}
                                </p>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div id="accessory" style="display:none" class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="qty">الكمية</label>
                                <input type="number" class="form-control" name="qty" id="qty" placeholder="الكمية" class="@error('qty') is-danger @enderror" value="{{old('qty')}}">
                                @error('qty')
                                <p class="help is-danger">
                                    {{$message}}
                                </p>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="description">ملاحظات</label>
                        <textarea  class="form-control" name="description" id="description" class="@error('description') is-danger @enderror" >{{old('description')}}</textarea>
                        @error('description')
                        <p class="help is-danger">
                            {{$message}}
                        </p>
                        @enderror
                    </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                    <button type="submit" id="btnSubmit" onclick="submitForm()" class="btn btn-primary">إضافة</button>
                    <a href="{{Route('order.receiving.material')}}" class="btn btn-info">رجوع</a>
                </div>
            </form>
        </div>
    </div>
</div>
@section('footer-script')
<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous">
</script>
<script>
    $(document).ready(function() {
        if ($('select#type').children("option:selected").val() == 'material') {
            document.getElementById('material').style.display = 'flex';
        } else if ($('select#type').children("option:selected").val() == 'accessory') {
            document.getElementById('accessory').style.display = 'flex';
        }
        $('select#type').on('change', function() {
            document.getElementById('accessory').style.display = 'none';
            document.getElementById('material').style.display = 'none';

            var selected = $(this).children("option:selected").val();
            if (selected == 'material') {
                document.getElementById('material').style.display = 'flex';
            }

            if (selected == 'accessory') {
                document.getElementById('accessory').style.display = 'flex';
            }
        });

        $("#btnSubmit").click(function(e) {

            //stop submitting the form to see the disabled button effect
            e.preventDefault();
            var form = document.getElementById('myForm');
            form.submit();
            //disable the submit button
            $("#btnSubmit").attr("disabled", true);

        });
    })
</script>
@endsection
</div>
@endsection