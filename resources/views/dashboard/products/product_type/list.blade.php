@extends('index')
@section('content')
<div class="row" id = "app">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"> أنواع المنتجات</h3>
                <a href="{{Route('product.type.create_page')}}" class="btn btn-success float-right {{ Laratrust::isAbleTo('add-product-type') ? '' : 'disabled' }}" >انشاء</a>
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
                                <th>الخيارات </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($types as $type)
                            <tr>
                                <td>{{$type->id}}</td>
                                <td>{{$type->name}}</td>
                                <td>
                                    <a href="{{Route('product.type.edit_page', $type->id)}}"
                                        class="btn btn-primary {{ Laratrust::isAbleTo('edit-product-type') ? '' : 'disabled' }}" >تعديل</a>
                                        {{--
                                    <form style="display:inline" action="{{Route('product.type.delete')}}"
                                        method="POST">
                                        @csrf
                                        <input type="hidden" name="type_id" value="{{$type->id}}">
                                        <button type="submit" class="btn btn-danger">حذف</button>
                                    </form>
                                    --}}
                                    <button type="submit" @click="deleteItem({{$type->id}})" class="btn btn-danger" {{ Laratrust::isAbleTo('delete-product-type') ? '' : 'disabled' }} >حذف</button>
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
                            axios.post("{{Route('product.type.delete')}}", data)
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