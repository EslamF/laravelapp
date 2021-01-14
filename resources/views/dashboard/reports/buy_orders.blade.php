@extends('index')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">{{__('words.buy_orders_reports')}}</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">

                <form method = "post" action = "{{route('buy.export')}}">
                    @csrf 
                    <input type = "hidden" name = "from" value = "{{request()->from}}">
                    <input type = "hidden" name = "to" value = "{{request()->to}}">
                    <input type = "hidden" name = "employee_id" value = "{{request()->employee_id}}">
                    <input type = "hidden" name = "confirmation" value = "{{request()->confirmation}}">
                    <input type = "submit" class = "btn btn-success" value = "شيت إكسيل" >
                </form>

                <form method = "get">
                <div class = "row">
            
                    
                        <div class = "form-group" style = "margin: 10px;">
                            <label>تاريخ التوصل من</label>
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
                            <label>حالة الطلب</label>
                            <select class = "form-control" name = "confirmation">
                                <option value = "">كل الحالات</option>
                                <option value = "pending"  {{ request()->confirmation == 'pending'   ? 'selected' : '' }}> {{ __('words.pending_orders') }}</option>
                                <option value = "delayed"  {{ request()->confirmation == 'delayed'   ? 'selected' : '' }}> {{ __('words.delayed_orders') }}</option>
                                <option value = "confirmed"{{ request()->confirmation == 'confirmed' ? 'selected' : '' }}> {{ __('words.confirmed_orders') }}</option>
                                <option value = "canceled" {{ request()->confirmation == 'canceled'  ? 'selected' : '' }}> {{ __('words.canceled_orders') }}</option>
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
                            <th>{{__('words.order_number')}}</th>
                            <th>{{__('words.employee')}}</th>
                            <th>{{__('words.order_preparation')}}</th>
                            <th>{{__('words.customer')}}</th>
                            <th>{{__('words.delivery_date')}}</th>
                            <th>{{__('words.confirmation')}}</th>
                            <th>{{__('words.price')}}</th>
                            <th>{{__('words.actions')}}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $order)
                        <tr>
                                <td>{{$order->bar_code}}</td>
                                <td>{{$order->user->name}}</td>
                                <td>{{ __('words.' . $order->preparation)}}</td>
                                <td><a href = "{{route('customer.show' , $order->customer_id)}}" target = "_Blank">{{$order->customer->name}}</a></td>
                                <td>{{$order->delivery_date}}</td>
                                <td><span class = "{{$order->confirmation_color}}" style = "padding:5px; border-radius:5px;">{{ __('words.' . $order->confirmation)}}</span></td>
                                <td>{{$order->orderTotal()}} ج </td>
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
                {!! $orders->appends(['from' => request()->from , 'to' => request()->to , 'employee_id' => request()->employee_id , 'confirmation' => request()->confirmation ])->links()!!}
            </div>
        </div>
        <!-- /.card -->
    </div>
</div>
@endsection