@extends('index')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">{{__('words.produce_orders_reports')}}</h3>
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
                <table class="table">
                    <thead>
                        <tr>
                            <th>الموظف</th>
                            <th>المصنع</th>
                            <th>تاريخ التسليم</th>
                            <th>إجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $order)
                        <tr>
                            <td>{{$order->user->name}}</td>
                            <td>{{$order->factory ? $order->factory->name : ''}}</td>
                            <td>{{$order->receiving_date}}</td>
                            <td>
                                <a href="{{Route('produce_order.show', $order->id)}}" class="btn btn-primary">عرض</a>             
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