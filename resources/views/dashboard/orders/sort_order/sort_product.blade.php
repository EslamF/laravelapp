@extends('index')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card ">
            <div class="card-header">

                <div class="float-right">
                    <p class = "text-center">M.O.M Brand</p>
                    <img src = "{{asset('logo2.jpeg')}}" style = "width:80px;">
                </div>

                <div class = "text-center">
                    {{--<h3 >موظف الفرز : {{$data['sort_order']->sortinguser->name}}</h3>--}}
                    <h3>موظفين الفرز</h3>
                    @foreach($data['sort_order']->users as $user)
                        <p class = "bg-primary text-center" style = "width: 10%; margin: 0 auto 2px auto;">{{$user->name}}</p>
                    @endforeach
                    <br>
                    <h3>البار كود : {{$data['sort_order']->code}}</h3>
                </div>
                {{--
                <form action="{{Route('sort.product')}}" method="POST" style="display:inline">
                    @csrf
                    <div class="row">
                        <div class="col-md-3">
                            <h3 class="card-title">  فرز المنتجات</h3>
                        </div>
                        <div class="col-md-4">
                            <input type="text" name="prod_code" class="form-control" placeholder="كود المنتج">
                        </div>
                        <div class="col-md-3">
                            <select name="damage_type" class="form-control" id="">
                                <option value="" disabled selected>حدد حالة المنتج</option>
                                <option value="fine">صالح</option>
                                <option value="ironing">كي</option>
                                <option value="tailoring">خياطة </option>
                                <option value="dyeing">صباغة</option>
                            </select>
                        </div>
                        <input type="hidden" name="sort_id" value="{{$data['sort_id']}}" id="">
                        <div class="col-md-1">
                            <button type="submit" class="btn btn-success float-right">إضافة</button>
                        </div>
                    </div>
                </form>
                --}}
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <h5>منتجات إذن الفرز </h5>
                <br>
                <table class="table ">
                    <thead>
                        <tr>
                            <th> الرقم المرجعي</th>
                            <th>كود الخامة</th>
                            <th>حالة المنتج</th>
                            <th>تاريخ الفرز</th>
                            <th>إجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data['records'] as $product)
                        <tr>
                            <td>{{$product->id}}</td>
                            <td>{{$product->prod_code}}</td>
                            @switch($product->damage_type)
                            @case('ironing')
                            <td>كي</td>
                            @break
                            @case('tailoring')
                            <td>خياطة</td>
                            @break
                            @case('dyeing')
                            <td>صباغ</td>
                            @break
                            @default
                            <td>صالح</td>
                            @endswitch
                            <td>{{$product->sort_date}}</td>
                            <td>
                                <form style="display:inline" action="{{Route('product.sort.delete')}}" method="POST">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{$product->id}}">
                                    <input type="hidden" name="sort_id" value="{{$data['sort_id']}}">
                                    <button type="submit" class="btn btn-danger" {{ Laratrust::isAbleTo('delete-sort-order-products') ? '' : 'disabled' }} >حذف</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
            <div class="card-footer clearfix">
                {{$data['records']->links()}}
            </div>
        </div>
        <!-- /.card -->
    </div>
</div>
@endsection