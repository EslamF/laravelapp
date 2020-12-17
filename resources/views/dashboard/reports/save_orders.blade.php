@extends('index')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">{{__('words.save_orders_reports')}}</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">

                <form method = "get">
                <div class = "row">
                        <div class = "form-group" style = "margin: 10px;">
                            <label>من</label>
                            <input type = "date" name = "from" class = "form-control" value = "{{request()->from}}">
                        </div>

                        <div class = "form-group" style = "margin: 10px;">
                            <label>إلى</label>
                            <input type = "date" name = "to" class = "form-control" value = "{{request()->to}}">
                        </div>

                        <div class = "form-group" style = "margin: 10px;">
                            <label>الموظف</label>
                            <select class = "form-control" name = "employee_id">
                                    <option value = "">كل الموظفين</option>
                                @foreach($employees as $employee)
                                    <option value = "{{$employee->id}}" {{ $employee->id == request()->employee_id ? 'selected' : '' }} >{{ $employee->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class = "form-group" style = "margin: 10px;">
                            <label>موظف الشحن</label>
                            <select class = "form-control" name = "shipping_employee_id">
                                    <option value = "">كل الموظفين</option>
                                @foreach($shipping_employees as $shipping_employee)
                                    <option value = "{{$shipping_employee->id}}" {{ $shipping_employee->id == request()->shipping_employee_id ? 'selected' : '' }} >{{ $shipping_employee->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class = "form-group" style = "margin: 10px;">
                            <label  style = "visibility:hidden;">بحث</label>
                            <input type = "submit" value = "بحث" class = "form-control btn btn-success">
                        </div>
                    

                </div>
            </form>
                <br><br>
                @if($orders->count())
                <table class="table">
                    <thead>
                        <tr>
                            <th>الموظف</th>
                            <th>موظف الشحن</th>
                            <th>رقم الإذن </th>
                            <th>حالة التخزين </th>
                            <th>إجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $order)
                        <tr>
                            <td>{{$order->user->name}}</td>
                            <td>{{$order->shippinguser ? $order->shippinguser->name : '--'}}</td>
                            <td>{{$order->code}}</td>
                            <td>
                                @if($order->stored == 1)
                                    <i class = "fa fa-check-circle bg-success" style = "padding: 10px;font-size:1.3em;"></i>
                                @else
                                    <i class = "fa fa-times-circle bg-danger" style = "padding: 10px;font-size:1.3em;"></i>
                                @endif
                            </td>
                            <td>
                                <a href="{{Route('send.end_product.get_order', $order->id)}}" class="btn btn-primary">رؤية</a>             
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
                
            </div>
        </div>
        <!-- /.card -->
    </div>
</div>
@endsection