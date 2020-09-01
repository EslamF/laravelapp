@extends('index')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">تعديل إذن إستلام الخامه</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form role="form" action="{{Route('receiving.material.update')}}" method="POST">
                @csrf
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">

                            <div class="form-group">
                                <label for="code">Code</label>
                                <input type="text" class="form-control" name="code" value="{{$data['material']->code}}"
                                    id="code" class="@error('color') is-danger @enderror"
                                    value="{{old('color')}}">
                            @error('color')
                            <p class="help is-danger">
                                {{$message}}
                            </p>
                            @enderror
                            </div>
                        </div>
                        <div class="col-md-6">

                            <div class="form-group">
                                <label for="mq_r_code">كود الخامه</label>
                                <input type="text" class="form-control" value="{{$data['material']->mq_r_code}}"
                                    name="mq_r_code" id="mq_r_code"
                                    class="@error('mq_r_code') is-danger @enderror">
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
                                    @foreach($data['users'] as $user)
                                    <option value="" disabled selected>حدد الموظف المستلم</option>
                                    <option value="{{$user->id}}"
                                        {{$data['material']->user_id == $user->id ? 'selected' : ''}}>{{$user->name}}
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
                        <div class="col-md-6">

                            <div class="form-group">
                                <label for="supplier">المورد</label>
                                <select class="form-control" name="supplier_id" id="supplier">
                                    @foreach($data['suppliers'] as $supplier)
                                    <option value="" disabled selected>حدد اسم المورد</option>
                                    <option value="{{$supplier->id}}"
                                        {{$data['material']->supplier_id == $supplier->id ? 'selected':''}}>
                                        {{$supplier->name}}</option>
                                    @endforeach
                                </select>
                                class="@error('supplier_id') is-danger @enderror"
                                value="{{old('supplier_id')}}">
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
                                <input type="text" value="{{$data['material']->qty}}" class="form-control" name="qty"
                                    id="qty"
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
                                <label for="bill_number"> الرقم المرجعي الفتوره</label>
                                <input type="text" class="form-control" value="{{$data['material']->bill_number}}"
                                    name="bill_number" id="bill_number" class="@error('bill_number') is-danger @enderror"
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
                                <input type="text" class="form-control" name="weight" id="weight"
                                    value="{{$data['material']->weight}}" 
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
                                <select class="form-control" name="material_type_id" id="material_types"
                                    class="@error('material_type_id') is-danger @enderror">
                                    @foreach($data['material_types'] as $type)
                                    <option value="" disabled selected>حدد نوع الخامه</option>
                                    <option value="{{$type->id}}"
                                        {{$data['material']->material_type_id == $type->id ? 'selected' : ''}}>
                                        {{$type->name}}</option>
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
                        <input type="text" class="form-control" name="color" value="{{$data['material']->color}}"
                            id="color"
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
                        
                        class="@error('description') is-danger @enderror">
                            {{$data['material']->description}}</textarea>
                                
                        @error('description')
                        <p class="help is-danger">
                            {{$message}}
                        </p>
                        @enderror
                        <input type="hidden" name="material_id" value="{{$data['material']->id}}">
                    </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">تأكيد التعديل</button>
                    <a href="{{url()->previous()}}" class="btn btn-info">رجوع</a>
                </div>
            </form>
        </div>
    </div>
</div>
</div>
@endsection