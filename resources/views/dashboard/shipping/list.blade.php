@extends('index')
@section('content')
<div class="row" id = "app">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">شركات الشحن </h3>
                <a href="{{Route('shippingcompany.create_page')}}" class="btn btn-success float-right {{ Laratrust::isAbleTo('add-shipping-company') ? '' : 'disabled' }}"  >إضافة</a>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                @include('includes.flash-message')
                @if($types->count())
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
                            <tr>
                                <td>{{$shipping->id}}</td>
                                <td>{{$shipping->name}}</td>
                                <td>
                                    <a href="{{Route('shippingcompany.edit_page', $shipping->id)}}" class="btn btn-primary {{ Laratrust::isAbleTo('edit-shipping-company') ? '' : 'disabled' }}"  >تعديل</a>
                                    {{--
                                    <form style="display:inline" action="{{Route('shippingcompany.delete')}}" method="POST">
                                        @csrf
                                        <input type="hidden" name="type_id" value="{{$shipping->id}}">
                                        <button type="submit" class="btn btn-danger">حذف</button>
                                    </form>
                                    --}}
                                    <button type="submit" @click="deleteItem({{$shipping->id}})" class="btn btn-danger" {{ Laratrust::isAbleTo('delete-shipping-company') ? '' : 'disabled' }} >حذف</button>
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
                            axios.post("{{Route('shippingcompany.delete_company')}}", data)
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