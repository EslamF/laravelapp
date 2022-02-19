@extends('index')
@section('content')
<div class="row" id = "app">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">الوظائف </h3>
                <a href="{{Route('role.create_page')}}" class="btn btn-success float-right" {{ Laratrust::isAbleTo('add-role') ? '' : 'disabled' }} >إضافة</a>
            </div>
                <!-- /.card-header -->
                <div class="card-body">
                    @if($types->count())
                        @include('includes.flash-message')
                        <table class="table ">
                        <thead>
                            <tr>
                                <th>الرقم المرجعي</th>
                                <th>الإسم</th>
                                <th>الإسم التوضيحي</th>
                                <th>الوصف</th>
                                <th>إجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($types as $role)
                            <tr>
                                <td>{{$role->id}}</td>
                                <td>{{$role->name }}</td>
                                <td><span class = "bg-info" style = "padding: 8px;border-radius:10px;">{{$role->display_name}}</span></td>
                                <td>{{$role->description}}</td>
                                <td>
                                    <a href="{{Route('role.edit_page', $role->id)}}"
                                        class="btn btn-primary" {{ Laratrust::isAbleTo('edit-role') ? '' : 'disabled' }} >تعديل</a>
                                    <button type="button" @click="deleteItem({{$role->id}})" class="btn btn-danger" {{ Laratrust::isAbleTo('edit-role') ? '' : 'disabled' }} >حذف</button>
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
                {{$types->links()}}
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
                            data.type_id = id
                            axios.post("{{Route('role.delete')}}", data)
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




