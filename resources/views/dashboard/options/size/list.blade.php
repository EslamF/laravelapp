@extends('index')
@section('content')
<div class="row" id = "app">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"> المقاسات</h3>
                <a href="{{Route('size.create_page')}}" class="btn btn-success float-right {{ Laratrust::isAbleTo('edit-size') ? '' : 'disabled' }}" >انشاء</a>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                @if($types->count())
                    @include('includes.flash-message')
                    <table class="table">
                        <thead>
                            <tr>
                                <th> الرقم المرجعي</th>
                                <th>المقاسات</th>
                                <th>الالخيارات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($types as $size)
                            <tr>
                                    <td>{{$size->id}}</td>
                                    <td>{{$size->name}}</td>
                                    <td>
                                        <a href="{{Route('size.edit_page', $size->id)}}" class="btn btn-primary {{ Laratrust::isAbleTo('edit-size') ? '' : 'disabled' }}" >تعديل</a>
                                        <button type="submit" class="btn btn-danger" @click = "deleteItem({{$size->id}})" {{ Laratrust::isAbleTo('delete-size') ? '' : 'disabled' }} >حذف</button>
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
                            axios.post("{{Route('size.delete')}}", data)
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