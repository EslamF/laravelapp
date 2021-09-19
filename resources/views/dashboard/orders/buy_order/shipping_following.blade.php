@extends('index')
@section('content')
<div class="row" id = "app">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">{{__('words.shipping_following')}}</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">

                @include('includes.flash-message')
                
                <div class="table-responsive-sm">

                    <form method = "get">
                        <div class = "row">
                                <div class = "form-group" style = "margin: 10px;">
                                    <label>التاريخ</label>
                                    <input type = "date" name = "from" class = "form-control" value = "{{request()->from}}">
                                </div>
        
                                <div class = "form-group" style = "margin: 10px;">
                                    <label>إلى</label>
                                    <input type = "date" name = "to" class = "form-control" value = "{{request()->to}}">
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
                                    <label>{{__('words.order_status')}}</label>
                                    <select class = "form-control" name = "status">
                                        <option value = "">كل الحالات</option>
                                        @foreach(status_after_shipping() as $status)
                                            <option value="{{$status}}"  {{ request()->status == $status   ? 'selected' : '' }}>{{__('words.status_after_shipping.' . $status)}}</option>
                                        @endforeach
                                    </select>
                                </div>
        
                                <div class = "form-group" style = "margin: 10px;">
                                    <label  style = "visibility:hidden;">بحث</label>
                                    <input type = "submit" value = "بحث" class = "form-control btn btn-success">
                                </div>
                            
        
                        </div>
                    </form>

                    <br>

                    @permission('upload-file-shipping-order')
                    <form action="{{Route('shipping.import_excel')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <input type="file" name="file" value="fileupload" class="hidden" id="fileupload">
                        <input type = "submit" class = "btn btn-primary" value = "{{__('words.upload')}}">
                    </form>
                    @endpermission

                    <br>
                    @if($orders->count())
                    <table class="table">
                        <thead>
                            <tr>
                                <th>{{__('words.order_number')}}</th>
                                <th>التاريخ</th>
                                <th>{{__('words.order_status')}}</th>
                                <th>{{__('words.customer')}}</th>
                                <th>{{__('words.delivery_date')}}</th>
                                <th>{{__('words.price')}}</th>
                                <th>{{__('words.shipping_fees')}}</th>
                                <th>{{__('words.net')}}</th>
                                <th>{{__('words.shipping_company')}}</th>
                                <th>{{__('words.actions')}}</th>
                            
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($orders as $order)
                            <tr>
                                    <td>
                                        <a href = "{{route('buy.show_order' , $order->id)}}">
                                            {{Str::limit($order->order_number , 15)}}
                                            <br>
                                            {{$order->bar_code}}
                                        </a>
                                    </td>
                                    <td dir = "ltr" class = "text-right">{{$order->created_at}}</td>
                                    
                                    <td><span class = "{{$order->status_color}}" style = "padding:5px; border-radius:5px;">{{ $order->translate_status }}</span></td>
                                    <td>
                                        <a href="{{Route('customer.show',$order->customer_id)}}">
                                            {{Str::limit($order->customer->name , 15)}}
                                            <br>
                                            {{$order->customer->phone}}
                                        </a>
                                    </td>
                                    <td>{{$order->delivery_date}}</td>
                                    <td>{{$order->orderTotal()}}</td>
                                    <td>{{$order->shipping_fees ?? '-'}}</td>
                                    <td>{{$order->net}}</td>
                                    <td>{{$order->shippingCompany ? $order->shippingCompany->name : ''}}</td>
                                    <td>
                                        <button type="button" class="btn btn-info" data-toggle="modal" data-target="#modal-default-{{$order->id}}">
                                            <i class="fas fa-truck"></i>
                                        </button>

                                        <div class="modal fade" id="modal-default-{{$order->id}}">
                                            <div class="modal-dialog">
                                              <div class="modal-content">
                                                <div class="modal-header">
                                                  <h4 class="modal-title">{{$order->order_number}}</h4>
                                                  {{-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                  </button> --}}
                                                </div>
                                                <form method = "POST" action = "{{route('buy.edit_shipping_fees')}}">
                                                    @csrf
                                                    <div class="modal-body">
                                                    
                                                        <input type = "hidden" name = "buy_order_id" value = "{{$order->id}}">
                                                        <label>{{__('words.shipping_fees')}}</label>
                                                        <input type = "number" name = "shipping_fees" value = "{{$order->shipping_fees}}" class = "form-control">
                                                    
                                                    </div>
                                                    <div class="modal-footer justify-content-between">
                                                    <button type="button" class="btn btn-default" data-dismiss="modal">غلق</button>
                                                    <button type="submit" class="btn btn-primary">تعديل</button>
                                                    </div>
                                                </form>
                                              </div>
                                              <!-- /.modal-content -->
                                            </div>
                                            <!-- /.modal-dialog -->
                                        </div>
                                        <!-- /.modal -->
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
                {{ $orders->appends($_GET)->links() }}
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

</script>
@endsection