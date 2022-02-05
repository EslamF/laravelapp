@extends('index')
@section('content')
<div class="row" id = "app">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header bg-danger">
                <h3 class="card-title">{{__('words.low_sale_products')}}</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                @include('includes.flash-message')
                @if($low_sale_products->count())
                    <table class="table">
                        <thead>
                            <tr>
                                <th class = "text-center">نوع المنتج</th>
                                <th class = "text-center">كود الخامة</th>
                                <th class = "text-center">الخامة</th>
                                {{--<th class = "text-center">الكمية المتاحة</th>--}}
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($low_sale_products as $key => $product)
                            <tr>
                                <td class = "text-center">{{$product->first()->productType->name}}</td>
                                <td class = "text-center">{{$product->first()->material->mq_r_code}}</td>       
                                <td class = "text-center">{{$product->first()->material && $product->first()->material->materialType ? $product->first()->material->materialType->name : ''}} - {{$product->first()->material->color}}</td>               
                                
                                {{--<td class = "text-center">{{count($product)}}</td>--}}
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
                            data.product_id = id
                            axios.post("{{Route('product.delete')}}", data)
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