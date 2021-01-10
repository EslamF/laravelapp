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
                @if($data->count())
                <table class="table ">
                    <thead>
                        <tr>
                            {{--<th>{{__('words.id')}}</th>--}}
                            <th>{{__('words.order_number')}}</th>
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
                                <td><span class = "{{$value->status_color}}" style = "padding:5px; border-radius:5px;">{{ $value->translate_status }}</span></td>
                                <td>{{ __('words.' . $value->preparation)}}</td>
                                <td>{{Str::limit($value->customer->name , 15)}}</td>
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
            <!-- /.card-body -->
            <div class="card-footer clearfix">
                {{$data->links()}}
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