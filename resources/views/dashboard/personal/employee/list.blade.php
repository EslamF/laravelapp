@extends('index')
@section('content')
<div id="app" class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">  الموظفين</h3>
                @can('add-employee')
                <a href="{{Route('employee.create_page')}}" class="btn btn-success float-right">انشاء</a>
                @endcan
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table class="table ">
                    <thead>
                        <tr class="row">
                            <div class="col-md-12">
                                <th class="col-md-2"> الرقم المرجعي</th>
                                <th class="col-md-3">اسم</th>
                                <th class="col-md-3">البريد الالكتروني</th>
                                <th class="col-md-2">صلحية الموظف</th>
                                <th class="col-md-2">إجراءات</th>
                            </div>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data['user'] as $employee)
                        <tr class="row">
                            <div class="col-md-12">
                                <td class="col-md-2">{{$employee->id}}</td>
                                <td class="col-md-2">{{$employee->name}}</td>
                                <td class="col-md-3">{{$employee->email}}</td>
                                <td class="col-md-3">{{isset($employee->roles[0]->label) ? $employee->roles[0]->label: "لا يوجد لة صلاحية" }}</td>
                                <td class="col-md-2">
                                    @can('edit-employee')
                                    <a href="{{Route('employee.edit_page', $employee->id)}}" class="btn btn-primary">تعديل</a>
                                    @endcan
                                    @can('delete-employee')
                                    <button type="submit" @click="deleteItem({{$employee->id}})" class="btn btn-danger">حذف</button>
                                    @endcan
                                </td>
                            </div>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
            <div class="card-footer clearfix">
                {{$data['user']->links()}}
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
                            data.type_id = id
                            axios.post("{{Route('employee.delete')}}", data)
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