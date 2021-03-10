@extends('index')
@section('content')
<div id="app" class="row">
    <div class="col-md-12">
        <div class="card ">
            <div class="card-header">
                <h3 class="card-title"> أذونات الفرش السابقة</h3>
                <a href="{{Route('spreading.material.counter_list')}}" class="btn btn-info float-right" style="margin-right: 5px">رجوع</a>
                <a href="{{Route('spreading.material.create_page')}}" class="btn btn-success float-right {{ Laratrust::isAbleTo('add-spreading-order') ? '' : 'disabled' }}"  >إنشاء</a>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                @if($data->count())
                    @include('includes.flash-message')
                    <table class="table ">
                        <thead>
                            <tr>
                                <th> الرقم المرجعي</th>
                                <th> التاريخ</th>
                                <th>النوع</th>
                                <th>كود الخامة</th>
                                <th>الوزن</th>
                                <th>إختيارات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data as $value)
                            <tr>
                                <td>{{$value->id}}</td>
                                <td dir = "ltr" class = "text-right">{{$value->created_at}}</td>
                                <td>
                                    @if($value->type == 'inner' && $value->spreadinguser)
                                        داخلى ({{$value->spreadinguser->name}})
                                    @elseif($value->type == 'outer' && $value->factory)
                                        خارجي ({{$value->factory->name}})
                                    @endif
                                </td>
                                <td>{{$value->material->mq_r_code}}</td>
                                <td>{{$value->weight}}</td>
                                <td>
                                    <button type="submit" @click="deleteItem({{$value->id}})" class="btn btn-danger" {{ Laratrust::isAbleTo('delete-spreading-order') ? '' : 'disabled' }} >حذف</button>
                                    {{--<a class = "btn btn-danger" href = "{{route('spreading.material.delete' , $value->id)}}">حذف</a>--}}
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
                <div class="offset-5">
                    {{$data->links()}}
                </div>
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
                        text: "سيتم حذف جميع المنتجات والأذونات الناتجة من إذن الفرش ",
                        icon: "warning",
                        buttons: true,
                        dangerMode: true,
                    })
                    .then((willDelete) => {
                        if (willDelete) {
                            var data = {};
                            data.spreading_id = id
                            axios.post("{{Route('spreading.material.delete')}}", data)
                                .then(res => {
                                    swal("تم الحذف بنجاح", {
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