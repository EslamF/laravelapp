

@extends('index')
@section('content')
<div id="app" class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">المصانع</h3>
                <a href="{{Route('factory.create_page')}}" class="btn btn-success float-right  {{ Laratrust::isAbleTo('add-factory') ? '' : 'disabled' }}" >إضافة</a>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                @if($factories->count())
                    @include('includes.flash-message')
                    <table class="table ">
                        <thead>
                            <tr>
                                <th>الرقم المرجعي</th>
                                <th>اسم</th>
                                <th>تيليفون</th>
                                <th>العنوان</th>
                                <th>أنواع المصانع</th>
                                <th>الخيارات</th>
                                
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($factories as $factory)
                            <tr>
                                <td>{{$factory->id}}</td>
                                <td>{{$factory->name}}</td>
                                <td>{{$factory->phone}}</td>
                                <td>{{$factory->address}}</td>
                                <td>{{$factory->factoryType->name}}</td> 
                                <td>
                                    <a href="{{Route('factory.edit_page', $factory->id)}}"
                                        class="btn btn-primary {{ Laratrust::isAbleTo('edit-factory') ? '' : 'disabled' }} " >تعديل</a>
                                    <button type="submit" @click="deleteItem({{$factory->id}})" class="btn btn-danger" {{ Laratrust::isAbleTo('delete-factory') ? '' : 'disabled' }} >حذف</button>
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
                            data.factory_type_id = id
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

    }).mount("#app")
</script>
@endsection