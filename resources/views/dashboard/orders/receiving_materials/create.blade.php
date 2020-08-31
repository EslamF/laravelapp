@extends('index')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">انشاءاذن استلام الخامات</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form role="form" action="{{Route('receiving.material.store')}}" method="POST">
                @csrf
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">

                            <div class="form-group">
                                <label for="code">كود</label>
                                <input type="text" class="form-control" name="code" id="code"  placeholder="كود"
                                class="@error('code') is-danger @enderror"
                                value="{{old('code')}}">
                                @error('code')
                                <p class="helsp is-danger">
                                    {{$message}}
                                </p>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="mq_r_code">كود الخامه</label>
                                <input type="text" class="form-control" name="mq_r_code" id="mq_r_code"
                                    placeholder="كود الخامة"
                                    class="@error('mq_r_code') is-danger @enderror"
                                value="{{old('mq_r_code')}}">
                                    @error('mq_r_code')
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
                                <label for="user">الموظف المستلم</label>
                                <select class="form-control" name="user_id" id="user"
                                class="@error('user_id') is-danger @enderror">
                                    <option  disabled selected>حدد اسم الموظف المستلم</option>
                                    @foreach($data['users'] as $user)
                                    <option value="{{$user->id}}">{{$user->name}}</option>
                                    @endforeach
                                </select>
                                @error('user_id')
                                <p class="help is-danger">
                                    {{$message}}
                                </p>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="supplier">المورد</label>
                                <select class="form-control" name="supplier_id" id="supplier"
                                class="@error('supplier_id') is-danger @enderror">
                                    <option value="" disabled selected>حدد اسم المورد</option>
                                    @foreach($data['suppliers'] as $supplier)
                                    <option value="{{$supplier->id}}">{{$supplier->name}}</option>
                                    @endforeach
                                </select>
                                @error('supplier_id')
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
                                <label for="qty">الكميه</label>
                                <input type="number" class="form-control" name="qty" id="qty" placeholder="الكميه"
                                class="@error('qty') is-danger @enderror"
                                value="{{old('qty')}}">
                                @error('qty')
                                <p class="help is-danger">
                                    {{$message}}
                                </p>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="bill_number">رقم الفتوره</label>
                                <input type="text" class="form-control" name="bill_number" id="bill_number"
                                    placeholder="رقم الفتوره"
                                    class="@error('bill_number') is-danger @enderror"
                                value="{{old('bill_number')}}">
                                    @error('bill_number')
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
                                <label for="weight">الوزن</label>
                                <input type="number" class="form-control" name="weight" id="weight"
                                    placeholder="ادخل الوزن" 
                                    class="@error('weight') is-danger @enderror"
                                value="{{old('weight')}}">
                                    @error('weight')    
                                    <p class="help is-danger">
                                        {{$message}}
                                    </p>
                                    @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="material_types">نوع الخامه</label>
                                <select class="form-control" name="material_type_id" id="material_types"class="@error('material_type_id') is-danger @enderror">
                                    <option value="" disabled selected>اختر نوع الخامه</option>
                                    @foreach($data['material_types'] as $type)
                                    <option value="{{$type->id}}">{{$type->name}}</option>
                                    @endforeach
                                </select>
                                   
                                @error('material_type_id')
                                <p class="help is-danger">
                                    {{$message}}
                                </p>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="color">اللون</label>
                        <input type="text" class="form-control" name="color" id="color" placeholder="ادخل اللون"
                        class="@error('color') is-danger @enderror"
                                value="{{old('color')}}">
                        @error('color')
                        <p class="help is-danger">
                            {{$message}}
                        </p>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="description">التفاصيل</label>
                        <textarea class="form-control" name="description" id="description"
                            class="@error('description') is-danger @enderror"
                                value="{{old('description')}}"  >س
                        </textarea>
                        @error('description')
                        <p class="help is-danger">
                            {{$message}}
                        </p>
                        @enderror
                    </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">تسجيل</button>
                    <a href="{{url()->previous()}}" class="btn btn-info">رجوع</a>
                </div>
            </form>
        </div>
    </div>
</div>
</div>
@endsection