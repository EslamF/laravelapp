@extends('index')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">{{__('words.sales_reports')}}</h3>
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
                            <label  style = "visibility:hidden;">بحث</label>
                            <input type = "submit" value = "بحث" class = "form-control btn btn-success">
                        </div>
                    

                </div>
            </form>
                <br><br>
                @if($orders->count())

                <h3 class = "bg-danger text-center" style = "padding: 5px 0;">{{__('words.total') . ' : ' . $total . ' ج '}}</h3>
                <table class="table">
                    <thead>
                        <tr>
                            <th>{{__('words.order_number')}}</th>
                            <th>{{__('words.employee')}}</th>
                            <th>{{__('words.customer')}}</th>
                            <th>{{__('words.delivery_date')}}</th>
                            <th>{{__('words.price')}}</th>
                            <th>{{__('words.actions')}}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $order)
                        <tr>
                                <td>{{$order->bar_code}}</td>
                                <td>{{$order->user->name}}</td>
                                <td><a href = "{{route('customer.show' , $order->customer_id)}}" target = "_Blank">{{$order->customer->name}}</a></td>
                                <td>{{$order->delivery_date}}</td>
                                <td>{{$order->orderTotal() . ' ج '}}</td>
                                <td>
                                    <a href="{{Route('buy.show_order', $order->id)}}" class="btn btn-info">{{__('words.show')}}</a>
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