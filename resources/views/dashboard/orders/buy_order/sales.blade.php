@extends('index')
@section('content')
<div class="row" id = "app">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">{{__('words.sales')}}</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">

                <form method = "get">
                    <div class = "row">
                            <div class = "form-group" style = "margin: 10px;">
                                <label>تاريخ الطلب من</label>
                                <input type = "date" name = "from" class = "form-control" value = "{{request()->from ?? date('Y-m-d') }}">
                            </div>
    
                            <div class = "form-group" style = "margin: 10px;">
                                <label>إلى</label>
                                <input type = "date" name = "to" class = "form-control" value = "{{request()->to ?? date('Y-m-d')}}">
                            </div>

                            <div class = "form-group" style = "margin: 10px;">
                                <label>رقم الطلب</label>
                                <input type = "text" name = "order_number" class = "form-control" value = "{{request()->order_number}}">
                            </div>

                            <div class = "form-group" style = "margin: 10px;">
                                <label>كود الخامة</label>
                                <input type = "text" name = "mq_r_code" class = "form-control" value = "{{request()->mq_r_code}}">
                            </div>

                            <div class = "form-group" style = "margin: 10px;">
                                <label>المصنع</label>
                                <select name = "factory_id" class = "form-control">
                                    <option value = "">الكل</option>
                                        @foreach($factories as $factory)
                                            <option value = "{{$factory->id}}" {{$factory->id == request()->factory_id ? 'selected' : ''}} >{{$factory->name}}</option>
                                        @endforeach
                                </select>
                            </div>
                            
    
                            <div class = "form-group" style = "margin: 10px;">
                                <label  style = "visibility:hidden;">بحث</label>
                                <input type = "submit" value = "بحث" class = "form-control btn btn-success">
                            </div>
                        
    
                    </div>
                </form>
                @if($products->count())

                <p style = "font-size: 1.3em;color: #b82626;font-weight: bold;">عدد الطلبات : {{$number_of_buy_orders}} </p>
                <p style = "font-size: 1.3em;color: #b82626;font-weight: bold;">عدد المنتجات : {{count($products)}} </p>
                
                <div class="table-responsive-sm">
                  
                   

                    <br>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>{{__('words.order_number')}}</th>
                                <th>{{__('words.created_at')}}</th>
                                <th>{{__('words.order_status')}}</th>
                                <th>{{__('words.mq_r_code')}}</th>
                                <th>{{__('words.product_type')}}</th>
                                <th>{{__('words.factory')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{--
                            @foreach($buy_orders as $buy_order)
                                @foreach($buy_order->products as $product)
                                    <tr>
                                        
                                            <td><a href = "{{Route('buy.show_order', $buy_order->id)}}">{{$buy_order->order_number}}</a></td>
                                            <td dir = "ltr" class = "text-right">{{$buy_order->created_at}}</td>
                                            <td>{{$product->material ? $product->material->mq_r_code : ''}}</td>
                                            <td>{{$product->productType ? $product->productType->name : ''}}</td>
                                            <td>{{$product->factory ? $product->factory->name : ''}}</td>
                                    </tr>
                                @endforeach
                            @endforeach
                            --}}

                            @foreach($products as $product)
                                <tr> 
                                    <td><a href = "{{Route('buy.show_order', $product->buyOrder()->id)}}">{{$product->buyOrder()->order_number}}</a></td>
                                    <td dir = "ltr" class = "text-right">{{$product->buyOrder()->created_at}}</td>
                                    <td><span class = "{{$product->buyOrder()->status_color}}" style = "padding:5px; border-radius:5px;">{{ $product->buyOrder()->translate_status }}</span></td>
                                    <td>{{$product->material ? $product->material->mq_r_code : ''}}</td>
                                    <td>{{$product->productType ? $product->productType->name : ''}}</td>
                                    <td>{{$product->factory ? $product->factory->name : ''}}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <div class="table-responsive-sm">
                    <p class="text-center">لا يوجد بيانات</p>
                </div>
                @endif
            </div>
            <!-- /.card-body -->
            <div class="card-footer clearfix">
                {{ $products->appends($_GET)->links() }}
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
                            axios.post("{{Route('buy.delete_order')}}", data)
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