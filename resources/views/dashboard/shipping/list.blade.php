@extends('index')
@section('content')
<div class="row" id = "app">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">شركات الشحن </h3>
                <a href="{{Route('shippingcompany.create_page')}}" class="btn btn-success float-right">إضافة</a>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th> الرقم المرجعي</th>
                            <th>اسم الشركة</th>
                            <th>الخيارات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($types as $shipping)
<<<<<<< HEAD
                        <tr class="row">
                            <div class="col-md-12">
                                <td class="col-md-1">{{$shipping->id}}</td>
                                <td class="col-md-8">{{$shipping->name}}</td>
                                <td class="col-md-2">
                                    <a href="{{Route('shippingcompany.edit_page', $shipping->id)}}" class="btn btn-primary">تعديل</a>
                                    <form style="display:inline" action="{{Route('shippingcompany.delete_company')}}" method="POST">
                                        @csrf
                                        @method('delete')
                                        <input type="hidden" name="type_id" value="{{$shipping->id}}">
                                        <button type="submit" class="btn btn-danger">حذف</button>
                                    </form>
                                </td>
                            </div>
=======
                        <tr>
                            <td>{{$shipping->id}}</td>
                            <td>{{$shipping->name}}</td>
                            <td>
                                <a href="{{Route('shippingcompany.edit_page', $shipping->id)}}" class="btn btn-primary">تعديل</a>
                                {{--
                                <form style="display:inline" action="{{Route('shippingcompany.delete')}}" method="POST">
                                    @csrf
                                    <input type="hidden" name="type_id" value="{{$shipping->id}}">
                                    <button type="submit" class="btn btn-danger">حذف</button>
                                </form>
                                --}}
                                <button type="submit" @click="deleteItem({{$shipping->id}})" class="btn btn-danger">حذف</button>
                            </td>
>>>>>>> d06e9b0d1369f53f61a5f1d560a6e382f83ffa27
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
                            axios.post("{{Route('shippingcompany.delete')}}", data)
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