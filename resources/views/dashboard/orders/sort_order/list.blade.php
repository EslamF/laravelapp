@extends('index')
@section('content')
<div class="row" id = "app">
    <div class="col-md-12">
        <div class="card ">
            <div class="card-header">
                <h3 class="card-title">  اذونات الفرز</h3>
                <a href="{{Route('sort.order.create_page')}}" class="btn btn-success float-right {{ Laratrust::isAbleTo('add-sort-order') ? '' : 'disabled' }}" >إضافة</a>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                @if($orders->count())
                    @include('includes.flash-message')
                    <table class="table ">
                        <thead>
                            <tr>
                                <th> الرقم المرجعي</th>
                                <th>التاريخ</th>
                                <th>كود</th>
                                <th>موظفين الفرز</th>
                                <th>تاريخ الفرز</th>
                                <th>الخيارات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($orders as $order)
                            <tr>
                                <td>{{$order->id}}</td>
                                <td dir = "ltr" class = "text-right">{{$order->created_at}}</td>
                                <td>{{$order->code}}</td>
                                <td>
                                    @foreach($order->users as $user)
                                        <p class = "bg-primary text-center" style = "margin-bottom:1px;">{{$user->name}}</p>
                                    @endforeach
                                </td>
                                <td>{{$order->created_at}}</td>
                                <td>
                                    <a href="{{Route('sort.product.list', $order->id)}}"
                                            class="btn btn-info">اظهار</a>

                                    <a href="{{Route('sort.order.scanningPage', $order->id)}}"
                                        class="btn btn-info">scanning</a>

                                    <a href="{{Route('sort.order.edit_page', $order->id)}}"
                                        class="btn btn-primary {{ Laratrust::isAbleTo('edit-sort-order') ? '' : 'disabled' }}" >تعديل</a>
                                    <button type="button" @click="deleteItem({{$order->id}})" class="btn btn-danger" {{ Laratrust::isAbleTo('delete-sort-order') ? '' : 'disabled' }} >حذف</button>
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
                {{$orders->links()}}
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
                            data.sort_id = id
                            axios.post("{{Route('sort.order.delete')}}", data)
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