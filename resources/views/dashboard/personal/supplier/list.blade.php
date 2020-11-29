

@extends('index')
@section('content')
<div id="app" class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">الموردين</h3>
                <a href="{{Route('supplier.create_page')}}" class="btn btn-success float-right">إضافة مورد</a>
            </div>
            <!-- /.card-header -->
        <div class="card-body">
                <table class="table ">
                    <thead>
                    <tr class="row">
                            <div class="col-md-12">
                                <th class="col-md-2">الرقم المرجعي المورد</th>
                                <th class="col-md-4">اسم المورد</th>
                                <th class="col-md-6">إجراءات</th>
                            </div>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($suppliers as $supplier)
                        <tr class="row">
                            <div class="col-md-12">
                                <td class="col-md-2">{{$supplier->id}}</td>
                                <td class="col-md-4">{{$supplier->name}}</td>
                                <td class="col-md-6">
                                    @can('edit-supplier')
                                    <a href="{{Route('supplier.edit_page', $supplier->id)}}" class="btn btn-primary">تعديل</a>
                                    @endcan
                                    @can('delete-supplier')
                                    <button type="submit" @click="deleteItem({{$supplier->id}})" class="btn btn-danger">حذف</button>
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
                {{$suppliers->links()}}
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
                            axios.post("{{ Route('supplier.delete') }}", data)
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


