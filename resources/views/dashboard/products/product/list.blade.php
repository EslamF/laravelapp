@extends('index')
@section('content')
<div class="row" id = "app">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"> المنتجات</h3>
                <a href="{{Route('product.create_page')}}" class="btn btn-success float-right {{ Laratrust::isAbleTo('add-product') ? '' : 'disabled' }}" >انشاء</a>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <div> 
                    <form method = "GET" id = "get_form">
                        <div class = "row">

                            <div class = "col-md-3">
                                <div class = "form-group">
                                    <label>{{__('words.mq_r_code')}}</label>
                                    <input type = "text" name = "material_code" value = "{{request()->material_code}}" class = "form-control"> 
                                </div>
                            </div>

                            <div class = "col-md-3">
                                <div class = "form-group">
                                    <label>{{__('words.size')}}</label>
                                    <select class = "form-control" name = "size_id">
                                        @inject('sizes' , 'App\Models\Options\Size')
                                            <option value = "">كل المقاسات</option>
                                        @foreach($sizes->get() as $size)
                                            <option value = "{{$size->id}}" {{$size->id == request()->size_id ? 'selected' : ''}}>{{$size->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class = "col-md-3">
                                <div class = "form-group">
                                    <label>{{__('words.factory')}}</label>
                                    <select class = "form-control" name = "factory_id">
                                        @inject('factories' , 'App\Models\Organization\Factory')
                                            <option value = "">كل المصانع</option>
                                        @foreach($factories->get() as $factory)
                                            <option value = "{{$factory->id}}" {{$factory->id == request()->factory_id ? 'selected' : ''}}>{{$factory->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class = "col-md-3">
                                <div class = "form-group">
                                    <label>{{__('words.product')}}</label>
                                    <input type = "text" name = "product_type" value = "{{request()->product_type}}" class = "form-control"> 
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                @include('includes.flash-message')
                @if($products->count())
                    <table class="table">
                        <p style = "color: #a31616;"> إجمالي المنتجات  : {{ $products->total() }}</p>
                       
                        <thead>
                            <tr>

                                <th class = "text-center"> الرقم المرجعي </th>
                                <th class = "text-center">كود الخامة</th>
                                <th class = "text-center">نوع المنتج</th>
                                <th class = "text-center">المقاس</th>
                                <th class = "text-center">المصنع</th>
                                <th class = "text-center">كود المنتج</th>
                                <th class = "text-center">حالة المنتج</th>
                                {{--<th class = "text-center">الحالة البيعية</th>--}}
                                <th class = "text-center">الخيارات</th>
                                <!--<th> الرقم المرجعي </th>
                                <th>كود المنتج</th>
                                <th>كود المنتج</th>
                                <th>حالة المنتج</th>
                                <th>حالة الفرز</th>
                                <th>الحالة البيعية</th>
                                <th>الخيارات</th>-->
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($products as $value)
                            <tr>
                                <td class = "text-center">{{$value->id}}</td>
                                <td class = "text-center">{{$value->material->mq_r_code}}</td>
                                <td class = "text-center">{{$value->productType->name}}</td>
                                <td class = "text-center">{{$value->size->name}}</td>
                                <td class = "text-center">{{$value->factory ? $value->factory->name : ''}}</td>
                                <td class = "text-center">{{$value->prod_code}}</td>
                                <td class = "text-center">{{$value->damage_type ?  __('words.damaged') . ' ( ' . __('words.' .$value->damage_type) . ' ) ' : __('words.valid')  }}</td>
                                {{--<td class = "text-center">{{$value->status}}</td>--}}
                                <td class = "text-center">
                                    <a href="{{Route('product.print', $value->id)}}" class="btn btn-info {{ Laratrust::isAbleTo('print-product') ? '' : 'disabled' }}" >طباعة</a>
                                    <a href="{{Route('product.edit_page', $value->id)}}" class="btn btn-primary {{ Laratrust::isAbleTo('edit-product') ? '' : 'disabled' }}" >تعديل</a>
                                    <button type="submit" class="btn btn-danger" @click = "deleteItem({{$value->id}})" {{ Laratrust::isAbleTo('delete-product') ? '' : 'disabled' }} >حذف</button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <p class="text-center">لا يوجد بيانات</p>
                @endif

            </div>
            <!-- /.card-body -->
            <div class="card-footer clearfix">
                {!! $products->appends(['size_id' => request()->size_id , 'material_code' => request()->material_code , 'product_type' => request()->product_type])->links()!!}
            
            </div>
        </div>
        <!-- /.card -->
    </div>
</div>
@endsection

@section('footer-script')
<script src="https://cdn.jsdelivr.net/npm/vue"></script>
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<script>
    var app = new Vue({
        el: '#app',
        data: {

        },

        methods: {
            deleteItem(id) {
                swal({
                        title: "هل انت متأكد؟",
                        text: "بمجرد مسح هذه البيانات لا يمكنك ارجعها مره اخري!",
                        icon: "warning",
                        buttons: true,
                        dangerMode: true,
                    })
                    .then((willDelete) => {
                        if (willDelete) {
                            var data = {};
                            data.product_id = id
                            axios.post("{{Route('product.delete')}}", data)
                                .then(res => {
                                    swal("تم المسح بنجاح", {
                                        icon: "success",
                                    });
                                    window.location.reload();
                                }).catch(err => {

                                });

                        }
                    });

            }
        }

    })
</script>
<script>
    $("input[name='material_code']").change(function(){
        $("#get_form").submit();
    });
    $("input[name='product_type']").change(function(){
        $("#get_form").submit();
    });
    $("select[name='size_id']").change(function(){
        $("#get_form").submit();
    });
    $("select[name='factory_id']").change(function(){
        $("#get_form").submit();
    });
</script>
@endsection