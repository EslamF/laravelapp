

@extends('index')
@section('content')
<div class="row" id = "app">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">انواع المصانع</h3>
                <a href="{{Route('factory.type.create_page')}}" class="btn btn-success float-right {{ Laratrust::isAbleTo('add-factory-type') ? '' : 'disabled' }} " >إضافة</a>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                @if($types->count())
                    @include('includes.flash-message')
                    <table class="table ">
                        <thead>
                            <tr>
                                <div>
                                    <th >الرقم المرجعي</th>
                                    <th>النوع</th>
                                    <th>الخيارات</th>
                                </div>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($types as $type)
                            <tr>
                                
                                <td class="">{{$type->id}}</td>
                                <td class="">{{$type->name}}</td>
                                <td class="">
                                    <a href="{{Route('factory.type.edit_page', $type->id)}}" class="btn btn-primary {{ Laratrust::isAbleTo('edit-factory-type') ? '' : 'disabled' }}"  >تعديل</a>
                                    <button type="submit" @click="deleteItem({{$type->id}})" class="btn btn-danger" {{ Laratrust::isAbleTo('delete-factory-type') ? '' : 'disabled' }} >حذف</button>
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
                            data.type_id = id
                            axios.post("{{Route('factory.type.delete')}}", data)
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











