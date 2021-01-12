@extends('index')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">{{__('words.customers_reports')}}</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">

                <form method = "get">
                <div class = "row">

                        <div class = "form-group" style = "margin: 10px;">
                            <label>العميل</label>
                            <input type = "text" class = "form-control" name = "customer" value = "{{request()->customer}}">
                        </div>

                        <div class = "form-group" style = "margin: 10px;">
                            <label  style = "visibility:hidden;">بحث</label>
                            <input type = "submit" placeholder = "بحث" value = "بحث" class = "form-control btn btn-success">
                        </div>
                </div>
            </form>
                <br><br>
                @if($customers->count())
                <table class="table">
                    <thead>
                        <tr>
                            <th>الاسم</th>
                            <th>الهاتف</th>
                            <th>المصدر</th>
                            <th>الوصول</th>
                            <th>النوع </th>
                            <th>عدد الطلبات</th>
                            <th>الإجمالي</th>
                            <th>إجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($customers as $customer)
                            <tr>
                                <td>{{$customer->name}}</td>
                                <td>{{$customer->phone}}</td>
                                <td>{{$customer->source}}</td>
                                <td><a href= "{{$customer->link}}" target = "_Blank">{{ Str::limit( $customer->link , 15)}}</a></td>
                                <td>{{ __('customers.'.$customer->type)}}</td>
                                <td><span style = "background: #111314;color:white;padding:10px;border-radius:10px;font-size:1.1em;">{{$customer->number_of_orders  }}</span></td>
                                <td><span style = "background: #111314;color:white;padding:10px;border-radius:10px;font-size:1.1em;">{{$customer->total_price }} ج</span></td>
                                <td>
                                    <a href="{{Route('customer.show',$customer->id)}}" class="btn btn-info btn-sm" >عرض</a>
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
                {{$customers->appends(['customer' => request()->customer])->links()}}
            </div>
        </div>
        <!-- /.card -->
    </div>
</div>
@endsection