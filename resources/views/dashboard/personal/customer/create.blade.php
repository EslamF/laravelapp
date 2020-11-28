@extends('index')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">إضافة عميل</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start  -->

            <form role="form" action="{{Route('customer.store')}}" method="POST">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label for="name">اسم العميل</label>
                        <input type="text" class="form-control" name="name" id="name" placeholder="انخل اسم العميل">
                    </div>
                    <div class="row ">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="phone"> رقم الهاتف</label>
                                <input type="text" class="form-control" name="phone" id="phone" placeholder="اخل  الرقم المرجعي الهاتف">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="source">المصدر </label>
                                <input type="text" class="form-control" name="source" id="source" placeholder="مصدر وصولك الينا">
                            </div>
                        </div>
                        {{-- <div class="col-md-4">
                            <div class="form-group">
                                <label for="notes">ملاحظات علي العميل </label>
                                <input type="text" class="form-control" name="notes" id="notes" placeholder="مصدر وصولك الينا">
                            </div>
                        </div> --}}
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="link">صفحة العميل الخاصة</label>
                            <input type="text" class="form-control" name="link" id="link" placeholder="من اين علمت بنا">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group ">
                            <label for="type"></label>
                            <select class="form-control" name="type" id="type">
                                <option value="" disabled selected>حدد صفة تعامل العميل</option>
                                <option value="individual">عميل عادي</option>
                                <option value="related">عميل مميز</option>
                                <option value="wholesaler">تاجر جملة</option>
                                <option value="retailer">تاجر قطاعي</option>
                            </select>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="address">العنوان</label>
                                    <input type="text" class="form-control" name="address" id="address" placeholder="ادخل العنوان">
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">إضافة</button>
                    <a href="{{url()->previous()}}" class="btn btn-info">رجوع</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection