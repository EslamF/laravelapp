

@extends('index')
@section('content')
<div id="app" class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">الموردين</h3>
                <a href="{{Route('supplier.create_page')}}" class="btn btn-success float-right {{ Laratrust::isAbleTo('add-supplier') ? '' : 'disabled' }}" >إضافة مورد</a>
            </div>
            <!-- /.card-header -->
        <div class="card-body">
            @if($suppliers->count())
                    @include('includes.flash-message')
                    <table class="table">
                        <thead>
                            <tr>
                                <th>الرقم المرجعي </th>
                                <th>اسم المورد</th>
                                <th>الخيارات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($suppliers as $supplier)
                            <tr>
                                <td>{{$supplier->id}}</td>
                                <td>{{$supplier->name}}</td>
                                <td>
                                        
                                        <a href="{{Route('supplier.edit_page', $supplier->id)}}" class="btn btn-primary {{ Laratrust::isAbleTo('edit-supplier') ? '' : 'disabled' }}" >تعديل</a>
                                        
                                        <button type="submit" @click="deleteItem({{$supplier->id}})" class="btn btn-danger" {{ Laratrust::isAbleTo('delete-supplier') ? '' : 'disabled' }} >حذف</button>
                                        
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
                            axios.post("{{Route('supplier.delete')}}", data)
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


