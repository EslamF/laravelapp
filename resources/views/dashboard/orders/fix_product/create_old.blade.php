@extends('index')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">إذن خروج منتجات تالفة</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form role="form" action="{{Route('fix.product.store')}}" method="POST">
                @csrf
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group">
                                <label for="weight"> الرقم المرجعي المنتج</label>
                                <input type="text" class="form-control @error('prod_code') is-danger @enderror "
                                 name="prod_code" id="weight" placeholder="ادخل  الرقم المرجعي المنتج"
                                
                                value="{{old('prod_code')}}">
                            @error('prod_code')
                            <p class="help is-danger">
                                {{$message}}
                            </p>
                            @enderror
                            </div>
                        </div>
                        {{--
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="name">المصنع</label>
                                <select class="form-control" name="factory_id" id=""
                                class="@error('factory_id') is-danger @enderror"
                                value="{{old('factory_id')}}">
                                    <option value="" disabled selected>حدد المصنع</option>
                                    @foreach($factories as $factory)
                                    <option value="{{$factory->id}}">{{$factory->name}}</option>
                                    @endforeach
                                </select>
                                
                            @error('factory_id')
                            <p class="help is-danger">
                                {{$message}}
                            </p>
                            @enderror
                            </div>
                        </div>
                        --}}
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="mq_r_code">نوع المصنع</label>
                                <select class="form-control" id = "factory_type_id" name = "factory_type_id">
                                    <option value="" disabled selected>حدد نوع المصنع</option>
                                    @inject('factory_types' , 'App\Models\Organization\FactoryType')
                                    @foreach($factory_types->get() as $factory_type )
                                        <option value = "{{ $factory_type->id }}"  {{ $factory_type->id == old('factory_type_id') ? 'selected' : '' }} > {{ $factory_type->name }} </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="factory_id">المصنع</label>
                                <select class="form-control" name="factory_id" id = "factory_id_select">
                                    <option value="" disabled selected>حدد اسم المصنع</option>

                                    @if( old('factory_type_id') )
                                        @inject('factories' , 'App\Models\Organization\Factory')
                                        @foreach( $factories->where('factory_type_id' , old('factory_type_id') )->get() as $factory )
                                            <option value = " {{ $factory->id }} " {{ old('factory_id') == $factory->id ? 'selected' : '' }} > {{ $factory->name }} </option>
                                        @endforeach
                                    @endif
                                </select>
                                @error('factory_id')
                                <p class="help is-danger">
                                    {{$message}}
                                </p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">إضافة</button>
                    <a href="{{url()->previous()}}" class="btn btn-info">رجوع</a>
                </div>
            </form>
        </div>
    
    </div>
</div>

@push('scripts')
<script>
    
    $("#factory_type_id").change(function(){

        var id = $(this).val();
        console.log(id);
        //{{url("factory/get-by-id")}}
        if(id)
        {
            $.ajax({
                    url:"{{ url('factory/get-by-id') }}"+'/'+id,
                    method:"GET",
                    success : function(data)
                    {
                        $("#factory_id_select").empty();
                        $.each(data , function(index , factory){
                            
                            $("#factory_id_select").append('<option value = "' + factory.id + '"> ' + factory.name + ' </option>');
                        });
                        
                        //console.log(data);
                    }
                })
        }

        else 
        {
            $("#factory_id_select").empty();
        }

    });
</script>
@endpush

@endsection