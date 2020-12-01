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
                    <input type="text" class="form-control @error('name') is-danger @enderror " name="name" value = "{{ old('name') }}" id="name" placeholder="ادخل اسم العميل">
                        @error('name')
                        <p class="help is-danger">
                            {{ $message }}
                        </p>
                        @enderror
                    
                    </div>
                    <div class="row ">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="phone"> رقم الهاتف</label>
                                <input type="text" class="form-control @error('phone') is-danger @enderror " name="phone" value = "{{ old('phone') }}" id="phone" placeholder="ادخل رقم الهاتف">
                                @error('phone')
                                <p class="help is-danger">
                                    {{ $message }}
                                </p>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="source">المصدر </label>
                                <input type="text" class="form-control @error('source') is-danger @enderror" name="source" value = "{{ old('source') }}"  id="source" placeholder="مصدر وصولك الينا">
                                @error('source')
                                <p class="help is-danger">
                                    {{ $message }}
                                </p>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="notes">ملاحظات علي العميل </label>
                                <input type="text" class="form-control @error('notes') is-danger @enderror " name="notes"  value = "{{ old('notes') }}"  id="notes" placeholder="ادخل ملاحظات علي العميل">
                                @error('notes')
                                <p class="help is-danger">
                                    {{ $message }}
                                </p>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="link">صفحة العميل الخاصة</label>
                            <input type="text" class="form-control  @error('link') is-danger @enderror " name="link" value = "{{ old('link') }}"  id="link" placeholder="من اين علمت بنا">
                            @error('link')
                            <p class="help is-danger">
                                {{ $message }}
                            </p>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group ">
                            <label for="type">نوع العميل</label>
                            <select class="form-control  @error('type') is-danger @enderror " name="type" id="type">
                                <option value="" disabled selected>حدد نوع تعامل العميل</option>
                                <option value="individual" {{ old('type') == 'individual' ? 'selected' : '' }} >عميل عادي</option>
                                <option value="related" {{ old('type') == 'related' ? 'selected' : '' }} >عميل مميز</option>
                                <option value="wholesaler" {{ old('type') == 'wholesaler' ? 'selected' : '' }} >تاجر جملة</option>
                                <option value="retailer" {{ old('type') == 'retailer' ? 'selected' : '' }} >تاجر قطاعي</option>
                            </select>
                            @error('type')
                            <p class="help is-danger">
                                {{ $message }}
                            </p>
                            @enderror
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="address">العنوان</label>
                                    <input type="text" class="form-control  @error('address') is-danger @enderror " name="address" value = "{{ old('address') }}" id="address" placeholder="ادخل العنوان">
                                    @error('address')
                                    <p class="help is-danger">
                                        {{ $message }}
                                    </p>
                                    @enderror
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                    <button type="submit" id="reg" onclick="test()" class="btn btn-primary">إضافة</button>
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