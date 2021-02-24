@extends('index')
@section('content')
<div class="row" id = "app">
    <div class="col-md-12">
        <div class="card ">
            <div class="card-header">
                <h3 class="card-title">  اذونات الإستلام</h3>
                <a href="{{Route('receiving.product.create')}}" class="btn btn-success float-right {{ Laratrust::isAbleTo('add-receiving-product') ? '' : 'disabled' }}" >انشاء اذن إستلام</a>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                @if($data->count())
                    @include('includes.flash-message')
                    <table class="table ">
                        <thead>
                            <tr>
                                <th> الرقم المرجعي</th>
                                <th>التاريخ</th>
                                <th>إذن اتصنيع</th>
                                <th>تاريخ الإستلام</th>
                                <th>حالة الإذن</th>
                                <th>الالخيارات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data as $value)
                            <tr>
                                <td>{{$value->id}}</td>
                                <td dir = "ltr" class = "text-right">{{$value->created_at}}</td>
                                <td>{{$value->produce_order_id}}</td>
                                <td>{{substr($value->created_at,0,10)}}</td>
                                <td>{{$value->status == 1 ? "Approved":"Not Approved"}}</td>
                                <td>
                                    <button type="button" @click="deleteItem({{$value->id}})" class="btn btn-danger" {{ Laratrust::isAbleTo('delete-receiving-product') ? '' : 'disabled' }} >حذف</button>
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
                            data.receiving_id = id
                            axios.post("{{Route('receiving.product.delete')}}", data)
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