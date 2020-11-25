@extends('index')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"> المنتجات الخاصة بإذن القص</h3>
                <a href="{{Route('cutting_order.add_page', $cutting_order->id)}}" class="btn btn-success float-right">إنشاء</a>
            </div>
            <h4 class="ml-3 mt-2">{{$cutting_order->factory ?'الشركة المسؤلة عن القص:'. $cutting_order->factory->name: 'الموظف المسؤل عن القص: '.$cutting_order->user->name}}</h3>
                <!-- /.card-header -->
                <div class="card-body">
                    <table class="table ">
                        <thead>
                            <tr class="row">
                                <div class="col-md-12">
                                    <th class="col-md-2">الرقم المرجعي</th>
                                    <th class="col-md-4">اسم المنتج</th>
                                    <th class="col-md-3">مقاس المنتج</th>
                                    <th class="col-md-1">الكمية</th>
                                    <th class="col-md-2">الخيارات</th>
                                </div>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($orders as $value)
                            <tr class="row">
                                <div class="col-md-12">
                                    <td class="col-md-2">{{$value['id']}}</td>
                                    <td class="col-md-4">{{$value['product_type']}}</td>
                                    <td class="col-md-3">{{$value['size']}}</td>
                                    <td class="col-md-1">{{$value['qty']}}</td>
                                    <td class="col-md-2">
                                        <form style="display:inline" action="{{Route('cutting.delete_product')}}" method="POST">
                                            @csrf
                                            <input type="hidden" name="id" value="{{$value['id']}}">
                                            <button type="submit" class="btn btn-danger">حذف</button>
                                        </form>
                                    </td>
                                </div>
                            </tr>
                            @endforeach
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