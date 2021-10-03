@extends('index')
@section('content')
<div class="row" id = "app">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="row mb-3">
                    <h3 class="card-title">{{__('words.shipping_orders')}}</h3>
                </div>
                <a href="{{Route('shipping.create_page')}}" class="btn btn-success float-right {{ Laratrust::isAbleTo('add-shipping-order') ? '' : 'disabled' }}" >{{__('words.add')}}</a>

                
                @permission('upload-file-shipping-order')
                <form action="{{Route('shipping.import_excel')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="file" name="file" value="fileupload" class="hidden" id="fileupload">
                    <input type = "submit" class = "btn btn-primary" value = "{{__('words.upload')}}">
                </form>
                @endpermission

                <br><br>

                    <form method = "GET">
                        <div class="row">
                            <div class="col-md-3">
                                <select name = "shipping_company" class = "form-control">
                                    <option value = "">كل شركات الشحن</option>
                                    @foreach ($shipping_companies as $company)
                                        <option value = "{{$company->id}}" {{$company->id == request()->shipping_company ? 'selected' : ''}} >{{$company->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <input type = "submit" class = "btn btn-success" value = "search">
    
                            </div>
                        </div>
                    </form>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                @if($orders->count())
                    <table class="table ">
                        <thead>
                            <tr>
                                <th>{{__('words.id')}}</th>
                                <th>التاريخ</th>
                                <th>{{__('words.shipping_number')}}</th>
                                <th>{{__('words.shipping_date')}}</th>
                                <th>{{__('words.actions')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($orders as $order)
                            <tr>
                                <td>{{$order->id}}</td>
                                <td dir = "ltr" class = "text-right">{{$order->created_at}}</td>
                                <td>{{$order->shipping_code}}</td>
                                <td>{{$order->shipping_date}}</td>

                                <td>
                                    <a href="{{Route('shipping.get', $order->id)}}" class="btn btn-primary">{{__('words.show')}}</a>
                                   
                                    <button type="button" @click="deleteItem({{$order->id}})" class="btn btn-danger" {{ Laratrust::isAbleTo('delete-shipping-order') ? '' : 'disabled' }} >{{__('words.delete')}}</button>
                                   
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
                {{$orders->appends($_GET)->links()}}
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
                            data.id = id
                            axios.post("{{Route('delete_shipping_order')}}", data)
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