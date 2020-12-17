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
                @include('includes.flash-message')
                @if($products->count())
                    <table class="table">
                        <thead>
                            <tr>

                                <th class = "text-center"> الرقم المرجعي </th>
                                <th class = "text-center">كود الخامة</th>
                                <th class = "text-center">نوع المنتج</th>
                                <th class = "text-center">المقاس</th>
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
                                <td class = "text-center">{{$value->prod_code}}</td>
                                <td class = "text-center">{{$value->damage_type ?  __('words.damaged') . ' ( ' . __('words.' .$value->damage_type) . ' ) ' : __('words.valid')  }}</td>
                                {{--<td class = "text-center">{{$value->status}}</td>--}}
                                <td class = "text-center">
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
                {{$products->links()}}
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
@endsection