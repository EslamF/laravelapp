@extends('index')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">بيانات إذن إستلام الخامة</h3>
            </div>
            @include('includes.loading')
            <!-- /.card-header -->
            <!-- form start -->
            <form role="form" id="myForm" action="{{Route('receiving.material.update')}}" method="POST">
                @csrf
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="mq_r_code">كود الخامة</label>
                                <input type="text" class="form-control" value="{{ old('mq_r_code') ?? $data['material']->mq_r_code}}" name="mq_r_code" id="mq_r_code" class="@error('mq_r_code') is-danger @enderror">
                                @error('mq_r_code')
                                <p class="help is-danger">
                                    {{$message}}
                                </p>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="bill_number"> الرقم المرجعي الفتورة</label>
                                <input type="text" class="form-control" value="{{ old('bill_number') ?? $data['material']->bill_number}}" name="bill_number" id="bill_number" class="@error('bill_number') is-danger @enderror" value="{{old('bill_number')}}">
                                @error('bill_number')
                                <p class="help is-danger">
                                    {{$message}}
                                </p>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="user">المشتري</label>
                                <select class="form-control" name="buyer_id" id="user" class="@error('buyer_id') is-danger @enderror">
                                    <option value="" disabled selected>حدد المشتري</option>
                                    @foreach($data['users'] as $user)
                                        <option value="{{$user->id}}" {{ old('buyer_id') == $user->id  ? 'seleted' : (  $data['material']->buyer_id  == $user->id ? 'selected' : '' )}}>{{$user->name}}</option>
                                    @endforeach
                                </select>
                                @error('buyer_id')
                                <p class="help is-danger">
                                    {{$message}}
                                </p>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="supplier">المورد</label>
                                <select class="form-control" name="supplier_id" id="supplier">
                                    <option value="" disabled selected>حدد اسم المورد</option>
                                    @foreach($data['suppliers'] as $supplier)
                                    <option value="{{$supplier->id}}" {{$data['material']->supplier_id == $supplier->id ? 'selected':''}}>
                                        {{$supplier->name}}</option>
                                    @endforeach
                                </select>
                                @error('supplier_id')
                                <p class="help is-danger">
                                    {{$message}}
                                </p>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>النوع</label>
                                <select id="type" class="form-control" name="type" disabled>
                                    <option value="" disabled selected>حدد النوع</option>
                                    <option value="material" {{ !$data['material']->qty ?  'selected' : ''}}>خامة</option>
                                    <option value="accessory"{{ $data['material']->qty  ?  'selected' : ''}}>اكسسوار</option>
                                </select>
                            </div>
                        </div>

                        <input type = "hidden" name = "type" value = "{{ !$data['material']->qty ?  'material' : 'accessory'}}">
                    </div>
                    <div id="material" style="{{!$data['material']->qty ? '' : 'display:none' }}" class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="weight">الوزن</label>
                                <input type="text" class="form-control" name="weight" id="weight" value="{{ old('weight') ?? $data['material']->weight}}" class="@error('weight') is-danger @enderror" value="{{old('weight')}}">
                                @error('weight')
                                <p class="help is-danger">
                                    {{$message}}
                                </p>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="material_types">نوع الخامة</label>
                                <select class="form-control" name="material_type_id" id="material_types" class="@error('material_type_id') is-danger @enderror">
                                    <option value="" disabled selected>حدد نوع الخامة</option>
                                    @foreach($data['material_types'] as $type)
                                    
                                    <option value="{{$type->id}}" {{$data['material']->material_type_id == $type->id ? 'selected' : ''}}>
                                        {{$type->name}}</option>
                                    @endforeach
                                </select>

                                @error('material_type_id')
                                <p class="help is-danger">
                                    {{$message}}
                                </p>
                                @enderror

                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="color">اللون</label>
                                <input type="text" class="form-control" name="color" value="{{$data['material']->color}}" id="color" class="@error('color') is-danger @enderror" value="{{old('color')}}">
                                @error('color')
                                <p class="help is-danger">
                                    {{$message}}
                                </p>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="number_of_vestments">عدد الأتواب</label>
                                <input type="text" class="form-control" name="number_of_vestments" id="number_of_vestments" placeholder="عدد الأتواب" class="@error('number_of_vestments') is-danger @enderror" value="{{old('number_of_vestments') ?? $data['material']->number_of_vestments}}">
                                @error('number_of_vestments')
                                <p class="help is-danger">
                                    {{$message}}
                                </p>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-10">
                            <div class = "form-group">
                                <label for = "vestments">الأتواب</label>
                                @error('vestments')
                                <span style="color:red" class="danger">
                                    {{$message}}
                                </span>
                                @enderror
                                <div id = "vestments">
                                    @if(count($data['material']->vestments) > 0)
                                        @foreach($data['material']->vestments as $vestment)
                                            <div class = "form-group" style = "width: 50%;">
                                                <label>وزن توب  {{$loop->iteration}} </label> 
                                                <input type = "number" name = "vestments[]" class=  "form-control" value = "{{$vestment->weight}}" placeholder="الوزن">
                                                @error('vestments.' . $loop->index)
                                                <span style="color:red" class="danger">
                                                    {{$message}}
                                                </span>
                                                @enderror
                                            </div>
                                        @endforeach
                                    @elseif(old('vestments'))
                                        
                                        @foreach(old('vestments') as $vestment)
                                            <div class = "form-group" style = "width: 50%;">
                                                <label>وزن توب  {{$loop->iteration}} </label> 
                                                <input type = "number" name = "vestments[]" class=  "form-control" value = "{{$vestment}}" placeholder="الوزن">
                                                @error('vestments.' . $loop->index)
                                                <span style="color:red" class="danger">
                                                    {{$message}}
                                                </span>
                                                @enderror
                                            </div>
                                        @endforeach
                                        
                                    @elseif($data['material']->number_of_vestments > 0)

                                        @for ($i = 0; $i < $data['material']->number_of_vestments; $i++)
                                        <div class = "form-group" style = "width: 50%;">
                                            <label>وزن توب  {{$i + 1}} </label> 
                                            <input type = "number" name = "vestments[]" class=  "form-control" value = "" placeholder="الوزن">
                                            @error('vestments.' . $i)
                                            <span style="color:red" class="danger">
                                                {{$message}}
                                            </span>
                                            @enderror
                                        </div>
                                        @endfor
                                        
                                    @endif
                                    
                                </div>
                            </div>
                        </div>

                    </div>
                    <div id="accessory" style="{{$data['material']->qty ? '' : 'display:none' }}" class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="qty">الكمية</label>
                                <input type="text" value="{{$data['material']->qty}}" class="form-control" name="qty" id="qty" class="@error('qty') is-danger @enderror" value="{{old('qty')}}">
                                @error('qty')
                                <p class="help is-danger">
                                    {{$message}}
                                </p>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="description">ملاحظات</label>
                        <textarea class="form-control" name="description" id="description" class="@error('description') is-danger @enderror">{{$data['material']->description}}</textarea>

                        @error('description')
                        <p class="help is-danger">
                            {{$message}}
                        </p>
                        @enderror
                        <input type="hidden" name="material_id" value="{{$data['material']->id}}">
                    </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                    <button type="submit" id="btnSubmit" class="btn btn-primary">تأكيد</button>
                    <a href="{{Route('order.receiving.material')}}" class="btn btn-info">رجوع</a>
                </div>
            </form>
        </div>
    </div>
</div>

@section('footer-script')
<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous">
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
            $("#loader").css("display" , "block");

            return true;

        });
    })
</script>

<script>
    $("input[name='number_of_vestments']").change(function(){
       
       var number_of_vestments = $(this).val();
       number_of_vestments = parseInt(number_of_vestments);
       if (typeof number_of_vestments === 'number') 
       {
           $("#vestments").empty();
           
           var item = '';

           for (var i = 1; i<=number_of_vestments; i++) 
           {
               item = '<div class = "form-group" style = "width: 50%;">' + 
                           '<label>وزن توب  ' + i + ' : </label>' + 
                           '<input type = "number" name = "vestments[]" class=  "form-control"  placeholder="الوزن">' + 
                       '</div>'
                       ;
               $("#vestments").append(item);
           }
       }

       else 
       {
           console.log("NAN");
       }
   });
</script>

@endsection
@endsection