@extends('index')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">بيانات المقاس</h3>
                <!-- /.card-header  -->
            </div>
            @include('includes.loading')
            <!-- form start -->
            <form role="form" id = "myForm" action="{{Route('size.update')}}" method="POST">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label for="name">المقاس</label>
                        <input type="text" class="form-control" value="{{$type->name}}" name="name" id="name" placeholder="ادخل المقاس">
                        <input type="hidden" name="type_id" value="{{$type->id}}">
                        @error('name')
                            <p class="help is-danger">
                                {{$message}}
                            </p>
                        @enderror
                    </div>
                    <!-- /.card-body -->

                </div>
                <div class="card-footer">
                    <button id = "btnSubmit" type="submit" class="btn btn-primary">تعديل</button>
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