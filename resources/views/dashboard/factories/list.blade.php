

@extends('index')
@section('content')
<div id="app" class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">المصانع</h3>
                <a href="{{Route('factory.create_page')}}" class="btn btn-success float-right">إضافة</a>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table class="table ">
                    <thead>
                        <tr class="row">
                            <div class="col-md-12">
                                <th class="col-md-2">الرقم المرجعي</th>
                                <th class="col-md-2">اسم</th>
                                <th class="col-md-2">تيليفون</th>
                                <th class="col-md-2">العنوان</th>
                                <th class="col-md-2">أنواع المصانع</th>
                                <th class="col-md-2">إجراءات</th>
                            </div>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($factories as $factory)
                        <tr class="row">
                            <div class="col-md-12">
                                <td class="col-md-2">{{$factory->id}}</td>
                                <td class="col-md-2">{{$factory->name}}</td>
                                <td class="col-md-2">{{$factory->phone}}</td>
                                <td class="col-md-2">{{$factory->address}}</td>
                                <td class="col-md-2">{{$factory->factory_type_id}}</td>
                                <td class="col-md-2">
                                    <a href="{{Route('factory.edit_page', $factory->id)}}"
                                        class="btn btn-primary">تعديل</a>
                                    <button type="submit" @click="deleteItem({{$factory->id}})" class="btn btn-danger">حذف</button>
                                </td>
                            </div>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
            <div class="card-footer clearfix">
                {{$factories->links()}}
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
                            data.factory_id = id
                            axios.post("{{Route('factory.delete')}}", data)
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





