

@extends('index')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">الوظائف </h3>
                <a href="{{Route('role.create_page')}}" class="btn btn-success float-right">إضافة</a>
            </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table class="table ">
                    <thead>
                        <tr class="row">
                            <div class="col-md-12">
                                <th class="col-md-2">الرقم المرجعي</th>
                                <th class="col-md-3">الاسم الوظيفة</th>
                                <th class="col-md-5">الوصف</th>
                                <th class="col-md-2">إجراءات</th>
                            </div>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($types as $role)
                        <tr class="row">
                            <div class="col-md-12">
                                <td class="col-md-1">{{$role->id}}</td>
                                <td class="col-md-3">{{$role->label == "" ? " لا يوجد اسم وظيفي" : $role->label}}</td>
                                <td class="col-md-6">{{$role->description == "" ? " لا يوجد وصف": $role->description}}</td>
                                <td class="col-md-2">
                                    <a href="{{Route('role.edit_page', $role->id)}}"
                                        class="btn btn-primary">تعديل</a>
                                        <form style="display:inline" action="{{Route('role.delete')}}" method="POST">
                                            @csrf
                                            <input type="hidden" name="type_id" value="{{$role->id}}">
                                            <button type="submit" class="btn btn-danger">حذف</button>
                                    </form>
                                </td>
                            </div>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
            <div class="card-footer clearfix">
                {{$types->links()}}
            </div>
        </div>
        <!-- /.card -->
    </div>
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





