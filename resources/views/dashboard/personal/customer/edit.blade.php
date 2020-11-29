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
                        <input type="text" class="form-control @error('name') is-danger @enderror" value="{{$customer->name}}" name="name" id="name" >
                        <input type="hidden" name="customer_id" value="{{$customer->id}}">
                        @error('name')
                        <p class="help is-danger">
                            {{ $message }}
                        </p>
                        @enderror

                    </div>
                    <div class="row ">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="phone">رقم الهاتف</label>
                                <input type="text" class="form-control @error('phone') is-danger @enderror" value="{{$customer->phone}}" name="phone" id="phone">
                                @error('phone')
                                <p class="help is-danger">
                                    {{ $message }}
                                </p>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="source">المصدر</label>
                                <input type="text" class="form-control @error('source') is-danger @enderror" value="{{$customer->source}}" name="source" id="source">
                                @error('source')
                                <p class="help is-danger">
                                    {{ $message }}
                                </p>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="notes">ملاحظات علي العميل</label>
                                <input type="text" class="form-control @error('notes') is-danger @enderror" value="{{$customer->notes}}" name="notes" id="notes">
                                @error('notes')
                                <p class="help is-danger">
                                    {{ $message }}
                                </p>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="link">صفحة العميل الخاصة</label>
                                <input type="text" class="form-control @error('link') is-danger @enderror" value="{{$customer->link}}" name="link" id="link">
                                @error('link')
                                <p class="help is-danger">
                                    {{ $message }}
                                </p>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group ">
                                <label for="type">نوع العميل</label>
                                <select class="form-control @error('type') is-danger @enderror" value="{{$customer->type}}" name="type" id="type">
                                    <option value="" disabled selected>حدد صفة تعامل العميل</option>
                                    <option value="individual" {{$customer->type== "individual" ? "selected":''}}>عميل عادي</option>
                                    <option value="related"  {{$customer->type== "related" ? "selected":''}}>عميل مميز</option>
                                    <option value="wholesaler" {{$customer->type== "wholesaler" ? "selected":''}}>تاجر جملة</option>
                                    <option value="retailer" {{$customer->type== "retailer" ? "selected":''}}>بائع</option>
                                </select>
                                @error('type')
                                <p class="help is-danger">
                                    {{ $message }}
                                </p>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="address">عنوان العميل</label>
                        <input type="text" class="form-control @error('address') is-danger @enderror " value="{{$customer->address}}" name="address" id="address">
                        @error('address')
                        <p class="help is-danger">
                            {{ $message }}
                        </p>
                        @enderror
                    </div>


                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                    <button type="submit" id="reg" onclick="test()" class="btn btn-primary">تأكيد</button>
                    <a href="{{route('customer.list')}}" class="btn btn-info">رجوع</a>

                </div>
            </form>
        </div>
    </div>
</div>

<script>
    var count = 0;
    function test() {
        count++;
        if (count == 2) {
            var button = document.getElementById('reg');
            button.disabled = true;
        }
    }
</script>

@endsection