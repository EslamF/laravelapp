@extends('index')
@section('content')
<div class="row" id = "app">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header bg-danger">
                <h3 class="card-title">{{__('words.about_to_run_products')}}</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                @include('includes.flash-message')
                @if($about_to_run_products->count())
                    <table class="table">
                        <thead>
                            <tr>
                                <th class = "text-center">نوع المنتج</th>
                                <th class = "text-center">المقاس</th>
                                <th class = "text-center">كود الخامة</th>
                                <th class = "text-center">الخامة</th>
                                <th class = "text-center">الكمية المتاحة</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($about_to_run_products as $product)
                            <tr>
                                <td class = "text-center">{{$product->productType->name}}</td>
                                <td class = "text-center">{{$product->size->name}}</td>
                                <td class = "text-center">{{$product->material->mq_r_code}}</td>       
                                <td class = "text-center">{{$product->material->materialType->name}} - {{$product->first()->material->color}}</td>               
                                
                                <td class = "text-center">{{$product->total}}</td>
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
                {!! $about_to_run_products->links() !!}

                
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