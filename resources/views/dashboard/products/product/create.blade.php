@extends('index')
@section('content')
<div class="row" id = "app">
    <div class="col-md-12">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">انشاء منتج</h3>
            </div>
            @include('includes.loading')
            <!-- /.card-header -->
            <!-- form start -->
            <form role="form" id = "myForm" action="{{Route('product.store')}}" method="POST">
                @csrf
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="product_type_id">نوع المنتج</label>
                                <select class="form-control" name="product_type_id">
                                    <option value="" disabled selected>اختر نوع المنتج</option>
                                    @foreach($product_types as $type)
                                        <option value="{{$type->id}}" {{ $type->id == old('product_type_id') ? 'selected' : '' }}  >{{$type->name}}</option>
                                    @endforeach
                                </select>
                                @error('product_type_id')
                                <p class="help is-danger">
                                    {{$message}}
                                </p>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="size_id">مقاس المنتج</label>
                                <select class="form-control" name="size_id">
                                    <option value="" disabled selected>اختر مقاس المنتج</option>
                                    @foreach($sizes as $size)
                                        <option value="{{$size->id}}" {{ $size->id == old('size_id') ? 'selected' : '' }}  >{{$size->name}}</option>
                                    @endforeach
                                </select>
                                @error('size_id')
                                <p class="help is-danger">
                                    {{$message}}
                                </p>
                                @enderror
                            </div>
                        </div>

                        {{--
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="material_id">خامة المنتج</label>
                                <select class="form-control" name="material_id">
                                    <option value="" disabled selected>اختر خامة المنتج</option>
                                    @foreach($materials as $material)
                                        <option value="{{$material->id}}"  {{ $material->id == old('material_id') ? 'selected' : '' }}  >{{$material->mq_r_code}}</option>
                                    @endforeach
                                </select>
                                @error('material_id')
                                <p class="help is-danger">
                                    {{$message}}
                                </p>
                                @enderror
                            </div>
                        </div>
                        --}}

                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="material_code">خامة المنتج</label>
                               
                                <input type = "text" class = "form-control" name = "material_code" value = "{{old('material_code')}}">
                                
                                @error('material_code')
                                <p class="help is-danger">
                                    {{$message}}
                                </p>
                                @enderror
                            </div>
                        </div>


                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="qty">الكمية</label>
                                <input type="number" value = "{{ old('qty') }} " name="qty" class="form-control" placeholder="اضف كمية">
                                @error('qty')
                                <p class="help is-danger">
                                    {{$message}}
                                </p>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="factory_id">المصنع</label>
                                <select class="form-control" name="factory_id">
                                    <option value="" disabled selected>اختر المصنع</option>
                                    @foreach($factories as $factory)
                                        <option value="{{$factory->id}}" {{ $factory->id == old('factory_id') ? 'selected' : '' }}  >{{$factory->name}}</option>
                                    @endforeach
                                </select>
                                @error('factory_id')
                                <p class="help is-danger">
                                    {{$message}}
                                </p>
                                @enderror
                            </div>
                        </div>
                        
                    </div>

                    <div class="row">
                        <div class = "col-md-3">
                            <div class="form-group">
                                <label for = "available_in_company">المنتجات متاحة في الشركة  </label>
                                <input type = "checkbox" name = "available_in_company" id = "available_in_company">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="description">الوصف</label>
                                <textarea class="form-control" name="description" id="description" placeholder="ادخل الوصف">{{old('description')}}</textarea>
                                @error('description')
                                <p class="help is-danger">
                                    {{$message}}
                                </p>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class = "col-md-3">
                            <div class="form-group">
                                <label for = "print">طباعة الأكواد </label>
                                <input type = "checkbox" name = "print" id = "print">
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                    <button type="submit" id = "btnSubmit" class="btn btn-primary">إضافة</button>
                    <a href="{{url()->previous()}}" class="btn btn-info">رجوع</a>
                </div>
            </form>
        </div>
    </div>
</div>
</div>
@endsection

@section('footer-script')
<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous">
</script>
<script>
    $(document).ready(function() {
        $("#btnSubmit").click(function(e) {
            //stop submitting the form to see the disabled button effect
            e.preventDefault();
            var form = document.getElementById('myForm');
            form.submit();
            //disable the submit button
            $("#btnSubmit").attr("disabled", true);
            document.getElementById('loader').style.display = 'block';

            return true;

        });
    })

</script>
@endsection