@extends('index')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">بيانات في إذن الفرز</h3>
            </div>
            @include('includes.loading')
            <!-- /.card-header -->
            <!-- form start -->
            <form role="form" id = "myForm" action="{{Route('sort.order.update')}}" method="POST">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label for="name">موظف الفرز</label>
                        <select class="form-control" name="user_id" id="">
                            <option value="" disabled selected>حدد اسم موظف الفرز</option>
                            @foreach($data['users'] as $user)
                                <option value="{{$user->id}}" {{$data['sort']->user_id == $user->id ? "selected": ""}}>{{$user->name}}</option>
                            @endforeach
                        </select>
                    </div>

                    <input type = "hidden" name = "sort_id" value = "{{$data['sort']->id}}">

                    <div class="form-group">
                        <label for="code">الكود</label>
                        <input type = "text" class="form-control" name="code" value = "{{$data['sort']->code}}">
                        @error('code')
                            <p class="help is-danger">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                    <button type="submit" id = "btnSubmit" class="btn btn-primary">تأكيد</button>
                    <a href="{{Route('sort.order.list')}}" class="btn btn-info">رجوع</a>
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