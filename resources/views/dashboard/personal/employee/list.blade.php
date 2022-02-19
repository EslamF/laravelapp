@extends('index')
@section('content')
<div id="app" class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">الموظفين</h3>
                @can('add-employee')
                <a href="{{Route('employee.create_page')}}" class="btn btn-success float-right {{ Laratrust::isAbleTo('add-employee') ? '' : 'disabled' }}" >انشاء</a>
                @endcan
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                @if($data['user']->count())
                    @include('includes.flash-message')
                    <table class="table">
                        <thead>
                            <tr>
                                <th> الرقم المرجعي</th>
                                <th>الإسم</th>
                                <th>البريد الالكتروني</th>
                                <th>الوظيفة</th>
                                <th>الخيارات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data['user'] as $employee)
                            <tr>
                                <td>{{$employee->id}}</td>
                                <td>{{$employee->name}}</td>
                                <td>{{$employee->email}}</td>
                                <td>
                                    <span class = "bg-info" style = "padding: 8px;border-radius:10px;">
                                        {{isset($employee->roles[0]->display_name) ? $employee->roles[0]->display_name: "" }}
                                    </span>
                                </td>
                                <td>
                                    @can('edit-employee')
                                        <a href="{{Route('employee.edit_page', $employee->id)}}" class="btn btn-primary {{ Laratrust::isAbleTo('edit-employee') ? '' : 'disabled' }}" >تعديل</a>
                                    @endcan
                                    @can('delete-employee')
                                        <button type="submit" class="btn btn-danger" @click = "deleteItem({{$employee->id}})" {{ Laratrust::isAbleTo('delete-employee') ? '' : 'disabled' }} >حذف</button>
                                    @endcan
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

    }).mount("#app")
</script>
@endsection