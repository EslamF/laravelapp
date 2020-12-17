@extends('index')
@section('content')
<div class="row">
    <div class="col-md-12 ">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">بيانات نوع الخامة</h3>
            </div>
            @include('includes.loading')
            <!-- /.card-header -->
            <!-- form start -->
            <form role="form" id = "myForm" action="{{Route('material.type.update')}}" method="POST">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label for="name">النوع</label>
                        <input type="text" class="form-control" name="name" value="{{$type->name}}" id="name" placeholder="ادخل نوع الخامة" class="@error('name') is-danger @enderror" value="{{old('name')}}">
                        @error('name')
                        <p class="help is-danger">
                            {{$message}}
                        </p>
                        @enderror
                        <input type="hidden" name="type_id" value="{{$type->id}}">
                    </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                    <button type="submit" id = "btnSubmit" class="btn btn-primary">تأكيد</button>
                    <a href="{{Route('material.type.list')}}" class="btn btn-info">رجوع</a>
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