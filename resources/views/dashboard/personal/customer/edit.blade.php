@extends('index')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Edit Customers</h3>
            </div>
            <!-- /.card-header          id	name	phone	address	source	link	type	 -->
            <!-- form start -->
            <form role="form" action="{{Route('customer.update')}}" method="POST">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label for="name">اسم العميل</label>
                        <input type="text" class="form-control" value="{{$customer->name}}" name="name" id="name" placeholder="Add customer Name">
                        <input type="hidden" name="customer_id" value="{{$customer->id}}">

                    </div>
                    <div class="row ">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="phone">رقم الهاتف</label>
                                <input type="text" class="form-control" value="{{$customer->phone}}" name="phone" id="phone">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="source">المصدر</label>
                                <input type="text" class="form-control" value="{{$customer->phone}}" name="source" id="source">
                            </div>
                        </div>
                        {{-- <div class="col-md-4">
                            <div class="form-group">
                                <label for="source">ملاحظات علي العميل</label>
                                <input type="text" class="form-control" value="{{$customer->observation}}" name="observation" id="source">
                            </div>
                        </div> --}}
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="link">صفحة العميل الخاصة</label>
                                <input type="text" class="form-control" value="{{$customer->link}}" name="link" id="link">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group ">
                                <select class="form-control" value="{{$customer->type}}" name="type" id="type">
                                    <option value="" disabled selected>حدد صفة تعامل العميل</option>
                                    <option value="individual" {{$customer->type== "individual" ? "selected":''}}>عميل عادي</option>
                                <option value="related"  {{$customer->type== "related" ? "selected":''}}>عميل مميز</option>
                                    <option value="wholesaler" {{$customer->type== "wholesaler" ? "selected":''}}>تاجر جملة</option>
                                    <option value="retailer" {{$customer->type== "retailer" ? "selected":''}}>بائع</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="address">عنوان العميل</label>
                        <input type="text" class="form-control" value="{{$customer->address}}" name="address" id="address">
                    </div>


                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <a href="{{url()->previous()}}" class="btn btn-info">Back</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection