@extends('index')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"> المنتجات الخاصة بإذن التصنيع</h3>
                {{-- <a href="{{Route('produce.order.create')}}" class="btn btn-success float-right">إضافة</a> --}}
                <div class="float-right">
                    <p class = "text-center">M.O.M Brand</p>
                    <img src = "{{asset('logo2.jpeg')}}" style = "width:80px;">
                </div>
            </div>
            <h4 class="ml-3 mt-2">{{$order->factory ?' المصنع: '. $order->factory->name: ''}}</h3>
                <!-- /.card-header -->
                
                <div class="card-body">
                    <table class="table ">
                        <thead>
                            <tr>
                                <th>إسم المنتج</th>
                                <th>مقاس المنتج</th>
                                <th>الكمية</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($products as $product)
                            <tr>
                                <td>{{$product[0]->productType->name}}</td>
                                <td>{{$product[0]->size->name}}</td>
                                <td>{{count($product)}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    
                    <br><br>
                    <h4>بيانات إذن القص</h4>

                    <table class = "table">
                        <thead>
                            <tr>
                                <th>{{ __('words.id') }}</th>
                                <th> {{ __('words.type') }} </th>
                                <th> {{ $order->cuttingOrder->type == 'inner' ? __('words.cutting_employee') : __('words.factory')  }} </th>
                            </tr>
                        </thead> 
                        <tbody>
                            <tr>
                                <td>{{$order->cuttingOrder->id}}</td>
                                <td>{{ __('words.' . $order->cuttingOrder->type) }}</td>
                                <td> {{ $order->cuttingOrder->type == 'inner' ? $order->cuttingOrder->cuttinguser->name :  $order->cuttingOrder->factory->name  }} </td>
                            </tr>
                        </tbody> 
                    </table>

                    <br><br>
                    <h4>بيانات إذن الفرش</h4>

                    <table class = "table">
                        <thead>
                            <tr>
                                <th>الرقم المرجعي</th>
                                <th>موظف الفرش</th>
                                <th>الوزن</th>
                                <th>كود الخامة</th>

                            </tr>
                        </thead> 

                        <tbody>
                            <tr>
                                <td>{{$order->cuttingOrder->spreadingOutMaterialOrder->id}}</td>
                                <td>{{$order->cuttingOrder->spreadingOutMaterialOrder->spreadinguser->name}}</td>
                                <td>{{$order->cuttingOrder->spreadingOutMaterialOrder->weight}}</td>
                                <td>{{$order->cuttingOrder->spreadingOutMaterialOrder->material->mq_r_code}}</td>
                            </tr>
                        </tbody> 


                    </table>
                </div>
                <!-- /.card-body -->
                <div class="card-footer clearfix">
                </div>
        </div>
        <!-- /.card -->
    </div>
</div>
@endsection