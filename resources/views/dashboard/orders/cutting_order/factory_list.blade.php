@extends('index')
@section('content')
<div class="row" id = "app">
    <div class="col-md-12">
        <div class="card ">
            <div class="card-header">
                <h3 class="card-title"> اذونات القص</h3>
                <a href="{{Route('cutting.outer_list')}}" class="btn btn-dark mr-2 float-right"> رجوع</a>
                <a href="{{Route('cutting.material.create_page')}}" class="btn btn-success float-right {{ Laratrust::isAbleTo('add-cutting-order') ? '' : 'disabled' }}" > انشاء</a>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                @if($data->count())
                    @include('includes.flash-message')
                    <table class="table ">
                        <thead>
                            <tr>
                                <th> الرقم المرجعي</th>
                                <th>الشركة</th>
                                <th>كود الخامة</th>
                                <th>موظف الفرش</th>
                                <th>إجراءات</th>
                                
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data as $value)
                            <tr>
                                <td>{{$value->id}}</td>
                                <td>{{$value->factory ? $value->factory->name: 'غير متاح'}}</td>
                                <td>{{$value->spreadingOutMaterialOrder->material->mq_r_code}}</td>
                                <td>{{$value->spreadingOutMaterialOrder->user->name}}</td>
                                <td>
                                    <a href = "{{route('cutting.material.edit_page' , $value->id)}}" class = "btn btn-info {{ $value->can_edit ? '' : 'disabled' }}  {{ Laratrust::isAbleTo('edit-cutting-order') ? '' : 'disabled' }}" >تعديل</a>
                                    <a href="{{Route('cutting_order.show_products', $value->id)}}" class="btn btn-primary">رؤية</a>
                                    <button type="submit" class="btn btn-danger" @click = "deleteItem({{$value->id}})"  {{ Laratrust::isAbleTo('delete-cutting-order') ? '' : 'disabled' }}>حذف</button>
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
                            data.cutting_order_id = id
                            axios.post("{{Route('cutting.material.delete')}}", data)
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