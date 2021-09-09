@extends('index')
@section('content')
<div class="row" id = "app">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">{{__('words.buy_orders')}}</h3>
                <a href="{{Route('buy.create_page')}}" class="btn btn-success float-right {{ Laratrust::isAbleTo('add-buy-order') ? '' : 'disabled' }}" >{{__('words.add')}}</a>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                
                <div class="table-responsive-sm">
                    <form method = "post" action = "{{route('buy.export')}}">
                        @csrf 
                        <input type = "hidden" name = "from" value = "{{request()->from}}">
                        <input type = "hidden" name = "to" value = "{{request()->to}}">
                        <input type = "hidden" name = "employee_id" value = "{{request()->employee_id}}">
                        <input type = "hidden" name = "confirmation" value = "{{request()->confirmation}}">
                        <input type = "hidden" name = "shipping_company_id" value = "{{request()->shipping_company_id}}">
                        <input type = "submit" class = "btn btn-success" value = "شيت إكسيل" >
                    </form>
                    <br>
                    <form method = "get" action = "{{route('buy.print')}}">
                        @csrf 
                        <input type = "hidden" name = "from" value = "{{request()->from}}">
                        <input type = "hidden" name = "to" value = "{{request()->to}}">
                        <input type = "hidden" name = "employee_id" value = "{{request()->employee_id}}">
                        <input type = "hidden" name = "confirmation" value = "{{request()->confirmation}}">
                        <input type = "hidden" name = "shipping_company_id" value = "{{request()->shipping_company_id}}">
                        <input type = "submit" class = "btn btn-info" value = "طباعة" >
                    </form>
                    <br>

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
                                    <label>شركة الشحن</label>
                                    <select class = "form-control" name = "shipping_company_id">
                                            <option value = "">كل الشركات</option>
                                        @foreach($shipping_companies as $shipping_company)
                                            <option value = "{{$shipping_company->id}}" {{ $shipping_company->id == request()->shipping_company_id ? 'selected' : '' }} >{{ $shipping_company->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
        
                                <div class = "form-group" style = "margin: 10px;">
                                    <label>{{__('words.confirmation')}}</label>
                                    <select class = "form-control" name = "confirmation">
                                        <option value = "">كل الحالات</option>
                                        <option value = "pending"  {{ request()->confirmation == 'pending'   ? 'selected' : '' }}> {{ __('words.pending_orders') }}</option>
                                        <option value = "delayed"  {{ request()->confirmation == 'delayed'   ? 'selected' : '' }}> {{ __('words.delayed_orders') }}</option>
                                        <option value = "confirmed"{{ request()->confirmation == 'confirmed' ? 'selected' : '' }}> {{ __('words.confirmed_orders') }}</option>
                                        <option value = "canceled" {{ request()->confirmation == 'canceled'  ? 'selected' : '' }}> {{ __('words.canceled_orders') }}</option>
                                    </select>
                                </div>

                                <div class = "form-group" style = "margin: 10px;">
                                    <label>{{__('words.order_status')}}</label>
                                    <select class = "form-control" name = "status">
                                        <option value = "">كل الحالات</option>
                                        <option value = "pending"   {{ request()->status == 'pending'   ? 'selected' : '' }}>قيد الإنتظار</option>
                                        <option value = "done"      {{ request()->status == 'done'   ? 'selected' : '' }}>تم اكتمال الطلب</option>
                                        <option value = "rejected"  {{ request()->status == 'rejected' ? 'selected' : '' }}> تم رفضه</option>
                                        <option value = "returned"  {{ request()->status == 'returned'  ? 'selected' : '' }}> تم إرجاعه</option>
                                    </select>
                                </div>

                                <div class = "form-group" style = "margin: 10px;">
                                    <label>{{__('words.order_preparation')}}</label>
                                    <select class = "form-control" name = "preparation">
                                        <option value = "">كل الحالات</option>
                                        <option value = "need_prepare"   {{ request()->preparation == 'need_prepare'   ? 'selected' : '' }}>{{__('words.need_prepare')}}</option>
                                        <option value = "prepared"       {{ request()->preparation == 'prepared'   ? 'selected' : '' }}>{{__('words.prepared')}}</option>
                                        <option value = "shipped"        {{ request()->preparation == 'shipped' ? 'selected' : '' }}> {{__('words.shipped')}}</option>
                                    </select>
                                </div>
        
                                <div class = "form-group" style = "margin: 10px;">
                                    <label  style = "visibility:hidden;">بحث</label>
                                    <input type = "submit" value = "بحث" class = "form-control btn btn-success">
                                </div>
                            
        
                        </div>
                    </form>

                    <br>
                    @if($data->count())
                    <table class="table">
                        <thead>
                            <tr>
                                {{--<th>{{__('words.id')}}</th>--}}
                                <th>{{__('words.order_number')}}</th>
                                <th>التاريخ</th>
                                <th>{{__('words.order_reference')}}</th>
                                <th>{{__('words.order_status')}}</th>
                                <th>{{__('words.order_preparation')}}</th>
                                <th>{{__('words.customer')}}</th>
                                <th>{{__('words.delivery_date')}}</th>
                                <th>{{__('words.confirmation')}}</th>
                                <th>{{__('words.price')}}</th>
                                <th>{{__('words.shipping_company')}}</th>
                                <th>{{__('words.actions')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data as $value)
                            <tr>
                                    {{--<td>{{$value->id}}</td>--}}
                                    <td>{{$value->bar_code}}</td>
                                    <td dir = "ltr" class = "text-right">{{$value->created_at}}</td>
                                    <td>{{Str::limit($value->order_number , 15)}}</td>
                                    <td><span class = "{{$value->status_color}}" style = "padding:5px; border-radius:5px;">{{ $value->translate_status }}</span></td>
                                    <td>{{ __('words.' . $value->preparation)}}</td>
                                    <td>
                                        {{Str::limit($value->customer->name , 15)}}
                                        <br>
                                        {{$value->customer->phone}}
                                    </td>
                                    <td>{{$value->delivery_date}}</td>
                                    <td><span class = "{{$value->confirmation_color}}" style = "padding:5px; border-radius:5px;">{{ __('words.' . $value->confirmation)}}</span></td>
                                    <td>{{$value->orderTotal()}}</td>
                                    <td>{{$value->shippingCompany ? $value->shippingCompany->name : ''}}</td>
                                    <td>
                                        <a href="{{Route('buy.show_order', $value->id)}}" class="btn btn-info btn-sm">{{__('words.show')}}</a>
                                        <a href="{{Route('buy.edit_page', $value->id)}}" class="btn btn-primary btn-sm {{ Laratrust::isAbleTo('edit-buy-order') ? '' : 'disabled' }} {{$value->status == 'returned' ? 'disabled' : ''}} " >تعديل</a>
                                        {{--
                                        <form style="display:inline" action="{{Route('buy.delete_order')}}" method="POST" >
                                            @csrf
                                            <input type="hidden" name="id" value="{{$value->id}}">
                                            <button type="submit" class="btn btn-danger btn-sm" {{ Laratrust::isAbleTo('delete-buy-order') ? '' : 'disabled' }}>{{__('words.delete')}}</button>
                                        </form>
                                        --}}
                                        <button type="submit" class="btn btn-danger btn-sm" @click = "deleteItem({{$value->id}})"  {{ Laratrust::isAbleTo('delete-buy-order') ? '' : 'disabled' }} >{{__('words.delete')}}</button>
                                    </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    @else 
                        <p class="text-center">لا يوجد بيانات</p>
                    @endif
                </div>
               
            </div>
            <!-- /.card-body -->
            <div class="card-footer clearfix">
                {{$data->appends(['from' => request()->from , 'to' => request()->to , 'employee_id' => request()->employee_id , 'shipping_company_id' => request()->shipping_company_id ])->links()}}
            </div>
        </div>
        <!-- /.card -->
    </div>
</div>
@endsection
@section('footer-script')
<script src="https://cdn.jsdelivr.net/npm/vue"></script>
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<script>
    var app = new Vue({
        el: '#app',
        data: {

        },

        methods: {
            deleteItem(id) {
                swal({
                        title: "هل انت متأكد؟",
                        text: "بمجرد مسح هذه البيانات لا يمكنك ارجعها مره اخري!",
                        icon: "warning",
                        buttons: true,
                        dangerMode: true,
                    })
                    .then((willDelete) => {
                        if (willDelete) {
                            var data = {};
                            data.id = id
                            axios.post("{{Route('buy.delete_order')}}", data)
                                .then(res => {
                                    swal("تم المسح بنجاح", {
                                        icon: "success",
                                    });
                                    window.location.reload();
                                }).catch(err => {

                                });

                        }
                    });

            }
        }

    })
</script>
@endsection