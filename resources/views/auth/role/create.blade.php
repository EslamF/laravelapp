@extends('index')
            @section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">الوظائف</h3>
            </div>
            @include('includes.loading')
            <!-- /.card-header -->
            <!-- form start  -->
            <form role="form" id = "myForm" action="{{Route('role.store')}}" method="POST">
                @csrf
                <div class="card-body " style="height: 100%">
                
                    <div class="form-group">
                        <label for="name">اسم الوظيفة</label>
                        <input type="text" class="form-control @error('name') is-danger @enderror"
                               name="name" id="name"  placeholder="ادخل اسم الوظيفة" value="{{old('name')}}">
                        @error('name')
                            <p class=" is-danger">{{$message}}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="display_name">الإسم التوضيحي</label>
                        <input type="text" class="form-control @error('display_name') is-danger @enderror"
                               name="display_name" id="display_name"  placeholder="الإسم التوضيحي" value="{{old('display_name')}}">
                        @error('display_name')
                            <p class=" is-danger">{{$message}}</p>
                        @enderror
                    </div>

                    <div class="form-group ">
                        <label for="description">وصف الوظيفة</label>
                        <input type="text" class="form-control" name="description" id="description"  placeholder="ادخل الملاحظات">
                        @error('description')
                        <p class=" is-danger">{{$message}}</p>
                            @enderror
                    </div>
                    
                    <h5> 
                        صلاحيات الوظيفة
                    </h5>
                    <div class = "form-group">
                        <input type = "checkbox" id = "select-all-permissions">
                        <label>الكل</label>
                    </div>
                    <div class="row ">
                    @foreach($permissions as $permission)
                        <div class="form-check col-3 ">
                            <input type="checkbox" class="form-check-input" name="permissions[]" id="{{$permission->id}}" value="{{$permission->id}}">
                            <label class="form-check-label" for="{{$permission->id}}"  >{{$permission->display_name}}</label>
                        </div>
                    @endforeach
                </div>
            </div>
                <!-- /.card-body -->

                <div class="card-footer">
                    <button type="submit"id = "btnSubmit"  class="btn btn-primary">إضافة</button>
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
    $(document).ready(function()
        {
            $("#select-all-permissions").click(function () {
                $('input:checkbox').not(this).prop('checked', this.checked);
            });
        });
    
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