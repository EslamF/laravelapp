@extends('index')
@section('content')
<div class="row" id = "app">
    <div class="col-md-12">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">رفع شيت للمنتجات</h3>
            </div>
            @include('includes.loading')

            @include('includes.flash-message')
            <!-- /.card-header -->
            <!-- form start -->
            <form role="form" id = "myForm" action="{{Route('product.import_sheet_excel')}}" method="POST" enctype='multipart/form-data' >
                @csrf
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <input type = "file" name = "file">
                                @error('file')
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
                </div>

                
                <!-- /.card-body -->

                <div class="card-footer">
                    <button type="submit" id = "btnSubmit" class="btn btn-primary">إضافة</button>
                    <a href="{{url()->previous()}}" class="btn btn-info">رجوع</a>
                </div>
            </form>
            <br>

            <div style = "margin: 10px;">


                        <h5>اتبع التعليمات بعناية قبل استيراد الملف.
                            يجب أن تكون الأعمدة في الملف  بالترتيب التالي.</h5>
                    
                        <img src="{{asset('excel_sheet_format.png')}}" style = "width: 100%;" alt="">
                  
            </div>
          

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