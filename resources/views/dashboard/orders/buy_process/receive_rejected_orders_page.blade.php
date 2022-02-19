@extends('index')
@section('content')
<div id="app" class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title" style="display: block;">Order code</h3>
                <h3 class="card-title float-right">Delivery date</h3>
            </div>
            <h4 class="ml-3 mt-2">
                </h3>
                <!-- /.card-header -->
                <div class="card-body">
                    <table class="table ">
                        <thead>
                            <tr>
                                <th>{{__('words.mq_r_code')}}</th>
                                <th>{{__('words.product')}}</th>
                                <th>{{__('words.size')}}</th>
                                <th>{{__('words.qty')}}</th>
                                <th>{{__('words.price')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($order->buyOrderProducts as $product)
                            <tr>
                                <td>{{$product->mq_r_code}}</td>
                                <td>{{$product->type}}</td>
                                <td>{{$product->size}}</td>
                                <td>{{$product->factory_qty + $product->company_qty }}</td>
                                <td>{{$product->price }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
                <div class="card-footer clearfix">
                    <button type="button" class="btn btn-primary" @click = "receiveOrder({{$order->id}})" {{-- Laratrust::isAbleTo('edit-size') ? '' : 'disabled' --}} >{{__('words.receive')}}</button>
                   
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
            receiveOrder(id) {
                swal({
                        title: "هل انت متأكد ",
                        text: "من إستلام المنتجات ؟ ",
                        icon: "warning",
                        buttons: true,
                        dangerMode: true,
                    })
                    .then((willReceive) => {
                        if (willReceive) {
                            var data = {};
                            data.id = id
                            axios.post("{{Route('process.receive_rejected_orders_submit')}}", data)
                                .then(res => {
                                    swal("تم إستلام المنتجات بنجاح", {
                                        icon: "success",
                                    });
                                    window.location.href = "{{Route('process.rejected_orders_list')}}"
                                }).catch(err => {

                                });

                        }
                    });

            }
        }

    }).mount("#app")
</script>
@endsection