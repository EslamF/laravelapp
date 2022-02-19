@extends('index')
@section('content')
<div id="app" class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"> أنواع الخامات</h3>
                <a href="{{Route('material.type.create_page')}}" class="btn btn-success float-right {{ Laratrust::isAbleTo('add-material') ? '' : 'disabled' }}" >انشاء نوع جديد</a>
            </div>
            <!-- /.card-header -->
            
                <div class="card-body">
                    @if($types->count())
                        @include('includes.flash-message')
                        <table class="table ">
                            <thead>
                                <tr>
                                    <th> الرقم المرجعي</th>
                                    <th>النوع</th>
                                    <th>الخيارات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($types as $type)
                                <tr>
                                    <td>{{$type->id}}</td>
                                    <td>{{$type->name}}</td>
                                    <td>
                                        <a href="{{Route('material.type.edit_page', $type->id)}}" class="btn btn-primary {{ Laratrust::isAbleTo('edit-material') ? '' : 'disabled' }}" >تعديل</a>
                                        <button type="submit" @click="deleteItem({{$type->id}})" class="btn btn-danger"  {{ Laratrust::isAbleTo('delete-material') ? '' : 'disabled' }} >حذف</button>

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
                            axios.post("{{Route('material.type.delete')}}", data)
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