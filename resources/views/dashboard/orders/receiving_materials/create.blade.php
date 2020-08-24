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
                                <input type="text" class="form-control" name="code" id="code" >
                            </div>
                        </div>
                        <div class="col-md-6">

                            <div class="form-group">
                                <label for="mq_r_code">كود الخامه</label>
                                <input type="text" class="form-control" name="mq_r_code" id="mq_r_code"
                                    placeholder="Add MQ_R_Code">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">

                            <div class="form-group">
                                <label for="user">الموظف المستلم</label>
                                <select class="form-control" name="user_id" id="user">
                                    <option value="" disabled selected></option>
                                    @foreach($data['users'] as $user)
                                    <option value="{{$user->id}}">{{$user->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">

                            <div class="form-group">
                                <label for="supplier">المورد</label>
                                <select class="form-control" name="supplier_id" id="supplier">
                                    <option value="" disabled selected>حدد اسم المورد</option>
                                    @foreach($data['suppliers'] as $supplier)
                                    <option value="{{$supplier->id}}">{{$supplier->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">

                            <div class="form-group">
                                <label for="qty">الكميه</label>
                                <input type="number" class="form-control" name="qty" id="qty" placeholder="Add Qty">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="bill_number">رقم الفتوره</label>
                                <input type="text" class="form-control" name="bill_number" id="bill_number"
                                    placeholder="Add Bill Number">
                            </div>

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">

                            <div class="form-group">
                                <label for="weight">الوزن</label>
                                <input type="number" class="form-control" name="weight" id="weight"
                                    placeholder="Add Weight">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="material_types">نوع الخامه</label>
                                <select class="form-control" name="material_type_id" id="material_types">
                                    <option value="" disabled selected>Select Material type</option>
                                    @foreach($data['material_types'] as $type)
                                    <option value="{{$type->id}}">{{$type->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="color">اللون</label>
                        <input type="text" class="form-control" name="color" id="color" placeholder="Add Color">
                    </div>
                    <div class="form-group">
                        <label for="description">التفاصيل</label>
                        <textarea class="form-control" name="description" id="description"
                            placeholder="Add Description"></textarea>
                    </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">تسجيل</button>
                    <a href="{{url()->previous()}}" class="btn btn-info">Back</a>
                </div>
            </form>
        </div>
    </div>
</div>
</div>
@endsection