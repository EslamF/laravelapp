@extends('index')
@section('content')
<div class="row" id = "app">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">{{__('words.receving_products_in_company_orders')}}</h3>
                <a href="{{Route('store.end_product.create_page')}}" class="btn btn-success float-right {{ Laratrust::isAbleTo('add-store-order') ? '' : 'disabled' }}" >{{__('words.add')}}</a>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                @if($orders->count())
                    @include('includes.flash-message')
                    <table class="table">
                        <thead>
                            <tr>
                                <th>{{__('words.id')}}</th>
                                <th>التاريخ</th>
                                <th>{{__('words.order_code')}}</th>
                                <th>{{__('words.actions')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($orders as $order)
                            <tr>
                                <td>{{$order->id}}</td>
                                <td dir = "ltr" class = "text-right">{{$order->created_at}}</td>
                                <td>{{$order->code}}</td>
                                <td>
                                    <a href="{{Route('send.end_product.get_order', $order->save_order_id)}}" class="btn btn-info">{{__('words.show')}}</a>
                                    
                                    {{--<button type="submit" @click="deleteItem({{$order->id}})" class="btn btn-danger" {{ Laratrust::isAbleTo('delete-store-order') ? '' : 'disabled' }} >{{__('words.delete')}}</button>--}}
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
                {{$orders->links()}}
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
                            data.save_order_id = id
                            axios.post("{{Route('send.end_product.delete')}}", data)
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