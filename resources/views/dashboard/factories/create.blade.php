@extends('index')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">إضافة مصنع</h3>
            </div>
            @include('includes.loading')
            <!-- /.card-header -->
            <!-- form start -->
            <form role="form" id="myForm" action="{{Route('factory.store')}}" method="POST">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label for="name">اسم المصنع</label>
                        <input type="text" class="form-control" name="name" id="name" placeholder="ادخل اسم المصنع"
                        class="@error('name') is-danger @enderror" value="{{old('name')}}">
                        @error('name')
                            <p class="help is-danger">
                                {{$message}}
                            </p>
                        @enderror
                    </div>
            <div class="row ">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="phone">تيليفون المصنع</label>
                        <input type="text" class="form-control" name="phone" id="phone" placeholder="ادخل تيليفون المصنع"
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
                        class="@error('factory_type_id') is-danger @enderror" value="{{old('factory_type_id')}}">
                            <option value="" disabled selected>حدد نوع المصنع</option>
                            @foreach($types as $type)
                                <option value="{{$type->id}}" {{ $type->id == old('factory_type_id') ? 'selected' : '' }} >{{$type->name}}</option>
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
                        <label for="address">عنوان المصنع</label>
                        <input type="text" class="form-control" name="address" id="address" placeholder="ادخل نوع المصنع"
                        class="@error('address') is-danger @enderror" value="{{old('address')}}">
                        @error('address')
                        <p class="help is-danger">
                            {{$message}}
                        </p>
                        @enderror
                    </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                <button type = "submit" id="btnSubmit" class="btn btn-primary">إضافة</button>
                    <a href="{{url()->previous()}}" class="btn btn-info">رجوع</a>
                </div>
            </form>
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