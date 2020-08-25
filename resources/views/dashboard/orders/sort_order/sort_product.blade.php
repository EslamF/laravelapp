@extends('index')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <form action="{{Route('sort.product')}}" method="POST" style="display:inline">
                    @csrf
                    <div class="row">
                        <div class="col-md-3">
                            <h3 class="card-title">Sorted Product Table</h3>
                        </div>
                        <div class="col-md-4">
                            <input type="text" name="prod_code" class="form-control" placeholder="Product Code">
                        </div>
                        <div class="col-md-3">
                            <select name="damage_type" class="form-control" id="">
                                <option value="" disabled selected>Choose status</option>
                                <option value="fine">Fine</option>
                                <option value="ironing">Ironing</option>
                                <option value="tailoring">Tailoring</option>
                                <option value="dyeing">Dyeing</option>
                            </select>
                        </div>
                        <input type="hidden" name="sort_id" value="{{$data['sort_id']}}" id="">
                        <div class="col-md-1">
                            <button type="submit" class="btn btn-success float-right">Add</button>
                        </div>
                    </div>
                </form>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table class="table ">
                    <thead>
                        <tr class="row">
                            <div class="col-md-12">
                                <th class="col-md-1">id</th>
                                <th class="col-md-3">MQ_R_CODE</th>
                                <th class="col-md-2">Status</th>
                                <th class="col-md-3">Sort Date</th>
                                <th class="col-md-3">Action</th>
                            </div>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data['records'] as $product)
                        <tr class="row">
                            <div class="col-md-12">
                                <td class="col-md-1">{{$product->id}}</td>
                                <td class="col-md-3">{{$product->prod_code}}</td>
                                @switch($product->damage_type)
                                @case('ironing')
                                <td class="col-md-2">Ironing</td>
                                @break
                                @case('tailoring')
                                <td class="col-md-2">Tailoring</td>
                                @break
                                @case('dyeing')
                                <td class="col-md-2">Dyeing</td>
                                @break
                                @default
                                <td class="col-md-2">Fine</td>
                                @endswitch
                                <td class="col-md-3">{{$product->sort_date}}</td>
                                <td class="col-md-3">
                                    <form style="display:inline" action="{{Route('product.sort.delete')}}" method="POST">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{$product->id}}">
                                        <input type="hidden" name="sort_id" value="{{$data['sort_id']}}">
                                        <button type="submit" class="btn btn-danger">Delete</button>
                                    </form>
                                </td>
                            </div>
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