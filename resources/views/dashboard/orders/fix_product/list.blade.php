@extends('index')
@section('content')
<div class="row" id = "app">
    <div class="col-md-12">
        <div class="card ">
            <div class="card-header">
                <h3 class="card-title">أذونات خروج المنتجات التالفة</h3>
                <a href="{{Route('fix.product.create_page')}}" class="btn btn-success float-right {{ Laratrust::isAbleTo('add-fix-product-out') ? '' : 'disabled' }}" >انشاء</a>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                @if($data->count())
                    @include('includes.flash-message')
                    <table class="table ">
                        <thead>
                            <tr>
                                <th> الرقم المرجعي</th>
                                <th>كود المنتج</th>
                                <th>المصنع</th>
                                <th>الخيارات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data as $order)
                            <tr>
                                <td>{{$order->id}}</td>
                                <td>{{$order->product->prod_code}}</td>
                                <td>{{$order->factory->name}}</td>
                                <td>
                                    <button type="submit" class="btn btn-danger" @click = "deleteItem({{$order->id}})" {{ Laratrust::isAbleTo('delete-fix-product-out') ? '' : 'disabled' }} >حذف</button>
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
                {{$data->links()}}
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
                            data.id = id
                            axios.post("{{Route('fix.product.delete')}}", data)
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