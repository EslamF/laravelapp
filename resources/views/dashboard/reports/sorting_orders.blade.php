@extends('index')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">{{__('words.sorting_orders_reports')}}</h3>
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
                            <label>موظف الفرز</label>
                            <select class = "form-control" name = "sorting_employee_id">
                                    <option value = "">كل الموظفين</option>
                                @foreach($sorting_employees as $sorting_employee)
                                    <option value = "{{$sorting_employee->id}}" {{ $sorting_employee->id == request()->sorting_employee_id ? 'selected' : '' }} >{{ $sorting_employee->name }}</option>
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
                            <th>موظف الفرز</th>
                            <th>رقم إذن الفرز</th>
                            <th>إجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $order)
                        <tr>
                            <td>{{$order->user->name}}</td>
                            <td>{{$order->sortinguser ? $order->sortinguser->name : '--'}}</td>
                            <td>{{$order->code}}</td>
                            <td>
                                <a href="{{Route('sort.product.list', $order->id)}}" class="btn btn-primary">رؤية</a>             
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