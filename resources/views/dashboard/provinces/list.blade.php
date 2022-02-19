

@extends('index')
@section('content')
<div class="row" id = "app">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">المحافظات</h3>
                <a href="{{Route('province.create_page')}}" class="btn btn-success float-right {{-- Laratrust::isAbleTo('add-province') ? '' : 'disabled' --}} " >إضافة</a>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                @if($provinces->count())
                    @include('includes.flash-message')
                    <table class="table">
                        <thead>
                            <tr>
                                <div>
                                    <th>الإسم</th>
                                    <th>الخيارات</th>
                                </div>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($provinces as $province)
                            <tr>
                                <td class="">{{$province->name}}</td>
                                <td class="">
                                    <a href="{{Route('province.edit_page', $province->id)}}" class="btn btn-primary {{-- Laratrust::isAbleTo('edit-province') ? '' : 'disabled' --}}"  >تعديل</a>
                                    <button province="submit" @click="deleteItem({{$province->id}})" class="btn btn-danger" {{-- Laratrust::isAbleTo('delete-province') ? '' : 'disabled' --}} >حذف</button>
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
                {{$provinces->links()}}
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
                console.log('id : ' + id);
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
                            data.province_id = id
                            axios.post("{{Route('province.delete')}}", data)
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











