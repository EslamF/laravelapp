@extends('index')
@section('content')
<div class="row" id = "app">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"> المنتجات</h3>
                <a href="{{Route('product.create_page')}}" class="btn btn-success float-right">انشاء</a>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table class="table ">
                    <thead>
                        <tr>
                            <th> الرقم المرجعي </th>
                            <th>كود المنتج</th>
                            <th>كود المنتج</th>
                            <th>حالة المنتج</th>
                            <th>حالة الفرز</th>
                            <th>الحالة البيعية</th>
                            <th>الخيارات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($products as $value)
                        <tr>
                            <td>{{$value->id}}</td>
                            <td>{{$value->prod_code}}</td>
                            <td>{{$value->receiving_order_id}}</td>
                            <td>{{$value->damaged == 1 ? 'True': 'False'}}</td>
                            <td>{{$value->sorted == 1 ? 'True' : 'False'}}</td>
                            <td>{{$value->status}}</td>
                            <td>
                                <a href="{{Route('product.edit_page', $value->id)}}" class="btn btn-primary">تعديل</a>
                                <button type="submit" class="btn btn-danger" @click = "deleteItem({{$value->id}})">حذف</button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
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