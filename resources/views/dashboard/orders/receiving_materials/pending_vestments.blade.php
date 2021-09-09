@extends('index')
@section('content')
<div id="app" class="row">
    <div class="col-md-12">
        <div class="card ">
            <div class="card-header">
                <h3 class="card-title"> جرد الخامات</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <form method = "GET">
                    <input name = "mq_r_code" class = "form-control col-md-3" type = "text" value = "{{request()->mq_r_code}}" placeholder="كود الخامة">
                </form>
                <br>
                @if($vestments->count())

                    

                    <p style = "font-size: 1.3em;color: #b82626;font-weight: bold;">مجموع الأوزان : {{$vestments->sum('weight')}} </p>
                    @include('includes.flash-message')
                    <table class="table">
                        <thead>
                            <tr>
                                <th>كود الخامة</th>
                                <th>الباركود</th>
                                <th>الوزن</th>
                                <th>الرقم المرجعي لإذن الإستلام</th>
                                <th>التاريخ</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($vestments as $vestment)
                            <tr>
                                <td>{{$vestment->material ? $vestment->material->mq_r_code : '--'}}</td>
                                <td>التوب({{$vestment->barcode}})</td>
                                <td>{{$vestment->weight}}</td>
                                <td>{{$vestment->material_id}}</td>
                                <td dir = "ltr" class = "text-right">{{$vestment->created_at}}</td>
                                
                                
                                
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
                {{$vestments->links()}}
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
                            data.material_id = id
                            axios.post("{{Route('receiving.material.delete')}}", data)
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