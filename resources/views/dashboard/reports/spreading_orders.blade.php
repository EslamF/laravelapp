@extends('index')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">{{__('words.spreading_orders_reports')}}</h3>
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
                            <label>النوع</label>
                            <select class = "form-control" name = "type">
                                    <option value = "">الكل</option>
                                    <option value = "inner" {{ request()->type == 'inner' ? 'selected' : ''}} >داخلي</option>
                                    <option value = "outer" {{ request()->type == 'outer' ? 'selected' : ''}}>خارجي</option>
                            </select>
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
                            <label>موظف الفرش</label>
                            <select class = "form-control" name = "spreading_employee_id">
                                    <option value = "">كل الموظفين</option>
                                @foreach($spreading_employees as $spreading_employee)
                                    <option value = "{{$spreading_employee->id}}" {{ $spreading_employee->id == request()->spreading_employee_id ? 'selected' : '' }} >{{ $spreading_employee->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{--
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
                        --}}

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
                            <th>النوع</th>
                            <th>كود الخامة</th>
                            <th>الوزن</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $order)
                        <tr>
                            <td>{{$order->user->name}}</td>
                            <td>
                                @if($order->type == 'inner' && $order->spreadinguser)
                                    داخلى ({{$order->spreadinguser->name}})
                                @elseif($order->type == 'outer' && $order->factory)
                                    خارجي ({{$order->factory->name}})
                                @endif
                            </td>
                            <td>{{$order->material->mq_r_code}}</td>
                            <td>{{$order->weight}}</td>
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