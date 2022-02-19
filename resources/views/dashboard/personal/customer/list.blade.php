@extends('index')
@section('content')
<div id="app" class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"> العملاء</h3>
                <a href="{{Route('customer.create_page')}}" class="btn btn-success float-right  {{ Laratrust::isAbleTo('add-customer') ? '' : 'disabled' }}" >إضافة عميل</a>
            </div>
            <!-- /.card-header -->
        <div class="card-body">
                @if($customers->count())
                    @include('includes.flash-message')
                    <table class="table">
                        <thead>
                            <tr>
                                <th> الرقم المرجعي</th>
                                <th>الاسم</th>
                                <th>الهاتف</th>
                                <th>العنوان</th>
                                <th>المصدر</th>
                                <th>الوصول</th>
                                <th>النوع </th>
                                <th>إجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($customers as $customer)
                            <tr>
                                <td>{{$customer->id}}</td>
                                <td>{{$customer->name}}</td>
                                <td>{{$customer->phone}}</td>
                                <td>{{$customer->address}}</td>
                                <td>{{$customer->source}}</td>
                                <td><a href= "{{$customer->link}}" target = "_Blank">{{ Str::limit( $customer->link , 20)}}</a></td>
                                <td>{{ __('customers.'.$customer->type)}}</td>
                                <td>
                                    <a href="{{Route('customer.show',$customer->id)}}" class="btn btn-info btn-sm" >عرض</a>
                                    <a href="{{Route('customer.edit_page',$customer->id)}}" class="btn btn-primary btn-sm {{ Laratrust::isAbleTo('edit-customer') ? '' : 'disabled' }} " >تعديل</a>
                                    <button type="button" @click="deleteItem({{$customer->id}})" class="btn btn-danger btn-sm" {{ Laratrust::isAbleTo('delete-customer') ? '' : 'disabled' }} >حذف</button>
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
                {{$customers->links()}}
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
                            data.customer_id = id
                            axios.post("{{Route('customer.delete')}}", data)
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