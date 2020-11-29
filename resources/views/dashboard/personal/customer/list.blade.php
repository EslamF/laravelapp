@extends('index')
@section('content')
<div id="app" class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"> العملاء</h3>
                <a href="{{Route('customer.create_page')}}" class="btn btn-success float-right">إضافة عميل</a>
            </div>
            <!-- /.card-header -->
        <div class="card-body">
                <table class="table ">
                    <thead>
                        <tr class="row">
                            <div class="col-md-12">
                                <th class="col-md-2"> الرقم المرجعي</th>
                                <th class="col-md-2">الاسم</th>
                                <th class="col-md-1">الهاتف</th>
                                <th class="col-md-1">العنوان</th>
                                <th class="col-md-1">وصف</th>
                                <th class="col-md-1">المصدر</th>
                                <th class="col-md-1">الوصول</th>
                                <th class="col-md-1">النوع </th>
                                <th class="col-md-2">إجراءات</th>
                            </div>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($customers as $customer)
                        <tr class="row">
                            <div class="col-md-12">
                                <td class="col-md-2">{{$customer->id}}</td>
                                <td class="col-md-2">{{$customer->name}}</td>
                                <td class="col-md-1">{{$customer->phone}}</td>
                                <td class="col-md-1">{{$customer->address}}</td>
                                <td class="col-md-1">{{$customer->notes}}</td>
                                <td class="col-md-1">{{$customer->source}}</td>
                                <td class="col-md-1">{{$customer->link}}</td>
                                <td class="col-md-1">{{ __('customers.'.$customer->type)}}</td>
                                <td class="col-md-2">
                                    <a href="{{Route('customer.edit_page',$customer->id)}}" class="btn btn-primary">تعديل</a>
                                    <button type="button" @click="deleteItem({{$customer->id}})" class="btn btn-danger">حذف</button>
                                </td>
                            </div>
          </tbody>
                </table>
            </div>
            <!-- /.card-body -->
            <div class="card-footer clearfix">
                {{$customers->links()}}
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
                            data.customer_id = id
                            axios.post("{{Route('customer.delete')}}", data)
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