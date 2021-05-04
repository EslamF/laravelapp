@extends('index')
@section('content')
<div class="row" id = "app">
    <div class="col-md-12">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">بيانات في بيانات المنتج</h3>
            </div>
            @include('includes.loading')
            <!-- /.card-header -->
            <!-- form start -->
            <ul>
                @foreach($errors as $error)
                <li>{{$error}}</li>
                @endforeach
            </ul>
            <form role="form" id = "myForm" action="{{Route('product.update')}}" method="POST">
                @csrf
                <div class="card-body">
                    <div class="row">
                        {{--
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="material_id">كود خامة</label>
                                <select name="material_id" class="form-control" id="">
                                    @foreach($materials as $material)
                                    <option value="{{$material->id}}" {{  $material->id  == $product->material->id ? 'selected' : '' }}>{{$material->mq_r_code}}</option>
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
                               
                                <input type = "text" class = "form-control" name = "material_code" value = "{{$product->material ? $product->material->mq_r_code : ''}}">
                                
                                @error('material_code')
                                <p class="help is-danger">
                                    {{$message}}
                                </p>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="prod_code">كود المنتج</label>
                                <input type="text" class="form-control" name="prod_code" value="{{ $product->prod_code }}" id="">
                                @error('prod_code')
                                <p class="help is-danger">
                                    {{$message}}
                                </p>
                            @enderror
                            </div>
                            
                        </div>
                    </div>
                    <div class="row">
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="damaged"> حالة الفرز</label>
                                <select class="form-control" name="damage_type" id="material">
                                    <option value="" disabled selected>حالة المنتج</option>
                                    <option value="" {{$product->damage_type == null ? 'selected': ''}}>صالج</option>
                                    <option value="ironing" {{$product->damage_type == 'ironing' ? 'selected': ''}}>كي</option>
                                    <option value="tailoring" {{$product->damage_type == 'tailoring' ? 'selected': ''}}>خياطة</option>
                                    <option value="dyeing" {{$product->damage_type == 'dyeing' ? 'selected': ''}}>صباغة</option>
                                </select>

                                @error('damaged')
                                <p class="help is-danger">
                                    {{$message}}
                                </p>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="status">الحالة</label>
                                <select class="form-control" name="status" id="material">
                                    <option value="" disabled selected>جدد حالة المنتج</option>

                                    @if($product->damage_type == null)
                                        <option value="available" {{$product->status == 'available' ?  'selected' : ''}}>متاح</option>
                                        <option value="pending" {{$product->status == 'pending' ?  'selected' : ''}}>انتظار</option>
                                        <option value="sold" {{$product->status == 'sold' ?  'selected' : ''}}>تم البيع</option>
                                    @else 
                                        <option value="damaged" {{ $product->damage_type || $product->status == 'damaged' ?  'selected' : ''}}>تالف</option>
                                    @endif
                                    {{--
                                        <option value="available" {{$product->status == 'available' ?  'selected' : ''}}>متاح</option>
                                        <option value="pending" {{$product->status == 'pending' ?  'selected' : ''}}>انتظار</option>
                                        <option value="sold" {{$product->status == 'sold' ?  'selected' : ''}}>تم البيع</option>
                                        <option value="damaged" {{$product->status == 'damaged' ?  'selected' : ''}}>تالف</option>
                                    --}}
                                </select>

                                @error('status')
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
                                <label for="product_type_id">نوع منتج</label>
                                <select name="product_type_id" class="form-control" id="">
                                    @foreach($product_types as $type)
                                    <option value="{{$type->id}}" {{$type->id  == $product->productType->id ? 'selected' : '' }}>{{$type->name}}</option>
                                    @endforeach
                                </select>
                                @error('product_type_id')
                                <p class="help is-danger">
                                    {{$message}}
                                </p>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="size_id">مقاس المنتج</label>
                                <select name="size_id" class="form-control" id="">
                                    @foreach($sizes as $size)
                                    <option value="{{$size->id}}" {{$size->id  == $product->size->id ? 'selected' : '' }}>{{$size->name}}</option>
                                    @endforeach
                                </select>
                                @error('size_id')
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
                                <label for="factory_id">المصنع</label>
                                <select class="form-control" name="factory_id">
                                    <option value="" disabled selected>اختر المصنع</option>
                                    @foreach($factories as $factory)
                                        <option value="{{$factory->id}}" {{ $factory->id == $product->factory_id ? 'selected' : '' }}  >{{$factory->name}}</option>
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
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="description">الوصف</label>
                                <textarea class="form-control" name="description" id="description" placeholder="ادخل الوصف">{{$product->description}}</textarea>
                                @error('description')
                                <p class="help is-danger">
                                    {{$message}}
                                </p>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="product_id" value="{{$product->id}}">
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                    <button id = "btnSubmit" type="submit" class="btn btn-primary">تعديل</button>
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

    $("select[name = 'damage_type']").change(function(){

        $("select[name = 'status']").empty();
        if($(this).val() == "")
        {
            $("select[name = 'status']").append(
                '<option value="available">متاح</option>' + 
                '<option value="pending">انتظار</option>' + 
                '<option value="sold">تم البيع</option>' 
            );
        }

        else 
        {
            $("select[name = 'status']").append(
                '<option value="damaged">تالف</option>' 
            );
        }
        /*<option value="available" {{$product->status == 'available' ?  'selected' : ''}}>متاح</option>
        <option value="pending" {{$product->status == 'pending' ?  'selected' : ''}}>انتظار</option>
        <option value="sold" {{$product->status == 'sold' ?  'selected' : ''}}>تم البيع</option>
        <option value="damaged" {{$product->status == 'damaged' ?  'selected' : ''}}>تالف</option>*/
    });
</script>
@endsection