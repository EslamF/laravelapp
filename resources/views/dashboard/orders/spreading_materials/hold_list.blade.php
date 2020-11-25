@extends('index')
@section('content')
<div id="app" class="row">
    <div class="col-md-12">
        <div class="card ">
            <div class="card-header">
                <h3 class="card-title"> أذونات الفرش الحالية</h3>
                <a href="{{Route('spreading.material.counter_list')}}" class="btn btn- float-right" style="margin-right: 5px">رجوع</a>
                <a href="{{Route('spreading.material.create_page')}}" class="btn btn-success float-right">إنشاء</a>
            
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table class="table ">
                    <thead>
                        <tr class="row">
                            <div class="col-md-12">
                                <th class="col-md-1"> الرقم المرجعي</th>
                                <th class="col-md-3">موظف الفرش</th>
                                <th class="col-md-3">كود الخامة</th>
                                <th class="col-md-3">الوزن</th>
                                <th class="col-md-2">إجراءات</th>
                            </div>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data as $value)
                        <tr class="row">
                            <div class="col-md-12">
                                <td class="col-md-1">{{$value->id}}</td>
                                <td class="col-md-3">{{$value->user->name}}</td>
                                <td class="col-md-3">{{$value->material->mq_r_code}}</td>
                                <td class="col-md-3">{{$value->weight}}</td>
                                <td class="col-md-2">
                                    <a href="{{Route('spreading.material.edit_page', $value->id)}}" class="btn btn-primary">تعديل</a>
                                    <button type="submit" @click="deleteItem({{$value->id}})" class="btn btn-danger">حذف</button>

                                </td>
                            </div>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
            <div class="card-footer clearfix">
                <div class="offset-5">
                    {{$data->links()}}
                </div>
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
                            data.spreading_id = id
                            axios.post("{{Route('spreading.material.delete')}}", data)
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