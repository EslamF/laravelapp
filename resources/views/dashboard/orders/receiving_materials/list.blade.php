@extends('index')
@section('content')
<div id="app" class="row">
    <div class="col-md-12">
        <div class="card ">
            <div class="card-header">
                <h3 class="card-title"> أذونات إستلام الخامات</h3>
                <a href="{{Route('order.receiving_material.create_page')}}" class="btn btn-success float-right {{ Laratrust::isAbleTo('add-receiving-material') ? '' : 'disabled' }}"   >انشاء إذن إستلام </a>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                @if($receiving->count())
                    @include('includes.flash-message')
                    <table class="table ">
                        <thead>
                            <tr>
                                    <th> الرقم المرجعي</th>
                                    <th>كود الخامة</th>
                                    <th>إسم الخامة</th>
                                    <th>عدد الأتواب</th>
                                    <th>المورد</th>
                                    <th>الرقم المرجعي الفاتورة</th>
                                    <th>المستلم</th>
                                    <th>المشتري</th>
                                    <th>الخيارات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($receiving as $material)
                            <tr>
                                    <td>{{$material->id}}</td>
                                    <td>{{$material->mq_r_code}}</td>
                                    <td>{{$material->materialType ? 'الخامة   : '.  $material->materialType->name : 'اكسسوار'}}</td>
                                    <td>{{$material->number_of_vestments}}</td>
                                    <td>{{$material->supplier->name}}</td>
                                    <td>{{$material->bill_number}}</td>
                                    <td>{{$material->user->name}}</td>
                                    <td>{{$material->buyer->name}}</td>
                                    <td>
                                        <a href="{{Route('receiving.material.edit_page', $material->id)}}" class="btn btn-primary {{ Laratrust::isAbleTo('edit-receiving-material') ? '' : 'disabled' }}" >تعديل</a>
                                        <button type="submit" @click="deleteItem({{$material->id}})" class="btn btn-danger" {{ Laratrust::isAbleTo('delete-receiving-material') ? '' : 'disabled' }} >حذف</button>
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
                {{$receiving->links()}}
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
                            data.material_id = id
                            axios.post("{{Route('receiving.material.delete')}}", data)
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