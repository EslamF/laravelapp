@extends('index')
@section('content')
<div class="row">
    <div class="col-md-12"> 
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"> المنتجات الخاصة بإذن القص</h3>
                {{--<a href="{{Route('cutting_order.add_page', $cutting_order->id)}}" class="btn btn-success float-right">إنشاء</a>--}}
            </div>
            <h4 class="ml-3 mt-2">{{$cutting_order->factory ?'الشركة المسؤلة عن القص:'. $cutting_order->factory->name: 'الموظف المسؤل عن القص: '.$cutting_order->cuttinguser->name}}</h3>
                <!-- /.card-header -->
                <div class="card-body">
                    <table class="table ">
                        <thead>
                            <tr>
                                <th>الرقم المرجعي</th>
                                <th>اسم المنتج</th>
                                <th>مقاس المنتج</th>
                                <th>الكمية</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($orders as $value)
                            <tr>
                                <td>{{$value['id']}}</td>
                                <td>{{$value['product_type']}}</td>
                                <td>{{$value['size']}}</td>
                                <td>{{$value['qty']}}</td>
                            </tr>
                            @endforeach
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
                                <td>{{$cutting_order->spreadingOutMaterialOrder->id}}</td>
                                <td>{{$cutting_order->spreadingOutMaterialOrder->spreadinguser->name}}</td>
                                <td>{{$cutting_order->spreadingOutMaterialOrder->weight}}</td>
                                <td>{{$cutting_order->spreadingOutMaterialOrder->material->mq_r_code}}</td>
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