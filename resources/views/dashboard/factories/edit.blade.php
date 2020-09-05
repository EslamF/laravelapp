@extends('index')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">بيانات المصنع</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form role="form" action="{{Route('factory.update')}}" method="POST">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label for="name">اسم المصنع</label>
                        <input type="text" class="form-control" name="name" value="{{$data['factory']->name}}" id="name"
                            placeholder="ادخل"
                            class="@error('name') is-danger @enderror" value="{{old('name')}}">
                                @error('name')
                                <p class="help is-danger">
                                    {{$message}}
                                </p>
                                @enderror
                        <input type="hidden" name="type_id" value="{{$data['factory']->id}}">
                    </div>
                    <div class="row ">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="phone">تيليفون المصنع</label>
                                <input type="text" class="form-control" name="phone" value="{{$data['factory']->phone}}" id="phone" placeholder="دخل تيليفون المصنع"
                                class="@error('phone') is-danger @enderror" value="{{old('phone')}}">
                                @error('phone')
                                <p class="help is-danger">
                                    {{$message}}
                                </p>
                                @enderror
                            </div>
                            </div>
                    <div class="col-md-8">
                        <div class="form-group ">
                            <label for="type">نوع المصنع</label>
                            <select class="form-control" name="factory_type_id" id="factory_type_id" 
                            class="@error('factory_type_id') is-danger @enderror">
                                <option value="" disabled selected>حدد نوع المصنع</option>
                                @foreach($data['type'] as $type)
                                <option value="{{$type->id}}" {{$data['factory']->factory_type_id == $type->id ? 'selected' : '' }}>{{$type->name}}</option>
                                @endforeach
                            </select>
                            @error('factory_type_id')
                            <p class="help is-danger">
                                {{$message}}
                            </p>
                            @enderror
                        </div>
                    </div>
                    </div>
                        <div class="form-group">
                            <label for="address">العنوان</label>
                            <input type="text" class="form-control" name="address" value="{{$data['factory']->address}}" id="address" placeholder=" ادخل العنوان"  
                            class="@error('address') is-danger @enderror" value="{{old('address')}}">
                            @error('address')
                            <p class="help is-danger">
                                {{$message}}
                            </p>
                            @enderror
                    <input type="hidden" name="type_id" value="{{$type->id}}">
                        </div>
                </div>
                <!-- /.card-body -->
          
                <div class="card-footer">
                    <button type="submit" onclick="submitForm()" class="btn btn-primary">تأكيد</button>
                    <a href="{{url()->previous()}}" class="btn btn-info">رجوع</a>
                </div>
            </form>
        </div>
    </div>
</div>
@section('footer-script')
<script src="https://code.jquery.com/jquery-3.3.1  .min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous">
</script>
<script>
    $(document).ready(function() {
        if ($('#qty').val()) {
            $('select#type').val('accessory');
        } else {
            $('select#type').val('material');
        };

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

            //disable a normal button
            $("#btnTest").attr("disabled", true);

            return true;

        });
    })
</script>
@endsection
@endsection