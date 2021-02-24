@extends('index')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">انشاء إذن فرز</h3>
            </div>
            @include('includes.loading')
            <!-- /.card-header -->
            <!-- form start -->
            <form role="form" id = "myForm" action="{{Route('sort.order.store')}}" method="POST">
                @csrf
                <div class="card-body">
                    {{--
                    <div class="form-group">
                        <label for="user_id">موظف الفرز</label>
                        <select class="form-control" name="user_id" id="">
                            <option value="" disabled selected>حدد موظف الفرز</option>
                            @foreach($users as $user)
                            <option value="{{$user->id}}">{{$user->name}}</option>
                            @endforeach
                        </select>
                        @error('user_id')
                            <p class="help is-danger">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                    --}}
                    {{--
                    <div class="form-group row">
                        <label for = "users">موظفين الفرز</label>
                        <div class = "form-control select2 col-10" stle = "padding:0">
                            <select name = "users">
                                <option value="" disabled selected>حدد موظف الفرز</option>
                                @foreach($users as $user)
                                    <option value="{{$user->id}}">{{$user->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    --}}

                    <div class = "form-group">
                        <select class = "select2 form-control w-100" name = "users[]" multiple>
                                @foreach($users as $user)
                                    <option value="{{$user->id}}">{{$user->name}}</option>
                                @endforeach
                        </select>
                    </div>

                    {{--
                        <div class="form-group">
                        @inject('nokia_requesters' , 'App\Models\NokiaRequester')
                        {!!Form::select('nokia_requester_id' , $nokia_requesters->all()->pluck('name' , 'id')->toArray() , null , ['class'  => 'form-control nokia_requesters_select2 w-100' , 'placeholder' => 'Choose a nokia requester'])!!}
                        </div>
                    --}}

                    {{--
                        <div class="form-group">
                            @inject('streams' , 'App\Models\Stream')
                            {!!Form::select('stream_id' , $streams->all()->pluck('name' , 'id')->toArray() , null , ['class'  => 'form-control streams_select2' , 'placeholder'  => 'Choose a stream'])!!}
                        </div>
                    --}}
                    

                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                    <button type="submit" id = "btnSubmit" class="btn btn-primary">إضافة</button>
                    <a href="{{Route('sort.order.list')}}" class="btn btn-info">رجوع</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('footer-script')
<!-- jQuery -->

<script>
    $('.select2').select2({
            placeholder: 'موظفين الفرز'
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

        

        //$('.select2').select2();
    })
</script>
@endsection