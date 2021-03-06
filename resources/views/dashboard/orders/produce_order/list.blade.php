@extends('index')
@section('content')
<div class="row" id = "app">
    <div class="col-md-12">
        <div class="card ">
            <div class="card-header">
                <h3 class="card-title">  اذونات التصنيع</h3>
                <a href="{{Route('produce.order.create')}}" class="btn btn-success float-right {{ Laratrust::isAbleTo('add-produce-order') ? '' : 'disabled' }} ">إضافة</a>
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
                                <th> الرقم المرجعي إذن القص</th>
                                <th>المصنع</th>
                                <th>تاريخ الخروج</th>
                                <th>تاريخ الإستلام</th>
                                <th>الخيارات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data as $value)
                            <tr>
                                <td>{{$value->id}}</td>
                                <td dir = "ltr" class = "text-right">{{$value->created_at}}</td>
                                <td>{{$value->cuttingOrder->id}}</td>
                                <td>{{$value->factory->name}}</td>
                                <td>{{$value->out_date}}</td>
                                <td>{{$value->receiving_date}}</td>
                                <td>
                                    <a href="{{Route('produce.order.edit_page', $value->id)}}" class="btn btn-primary {{$value->can_edit ? '' : 'disabled'}}  {{ Laratrust::isAbleTo('edit-produce-order') ? '' : 'disabled' }}" >تعديل</a>
                                    <a href = "{{ route('produce_order.show' , $value->id) }}"  class = "btn btn-info">إظهار</a>
                                    <button type="button" @click="deleteItem({{$value->id}})" class="btn btn-danger" {{ Laratrust::isAbleTo('delete-produce-order') ? '' : 'disabled' }} >حذف</button>
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
    Vue.createApp({
        data() {
            return {

            }
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
                            data.produce_id = id
                            axios.post("{{Route('produce.order.delete')}}", data)
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

    }).mount("#app")
</script>
@endsection