@extends('index')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Receiving Material Order Table</h3>
                <a href="{{Route('order.receiving_material.create_page')}}" class="btn btn-success float-right">Add</a>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table class="table ">
                    <thead>
                        <tr class="row">
                            <div class="col-md-12">
                                <th class="col-md-1">id</th>
                                <th class="col-md-2">MQ_R_CODE</th>
                                <th class="col-md-2">Type</th>
                                <th class="col-md-2">supplier</th>
                                <th class="col-md-2">Bill Number</th>
                                <th class="col-md-1">Receivied By</th>
                                <th class="col-md-2">Action</th>
                            </div>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($receiving as $material)
                        <tr class="row">
                            <div class="col-md-12">
                                <td class="col-md-1">{{$material->id}}</td>
                                <td class="col-md-2">{{$material->mq_r_code}}</td>
                                <td class="col-md-2">{{$material->materialType->name}}</td>
                                <td class="col-md-2">{{$material->supplier->name}}</td>
                                <td class="col-md-2">{{$material->bill_number}}</td>
                                <td class="col-md-1">{{$material->user->name}}</td>
                                <td class="col-md-2">
                                    <a href="{{Route('receiving.material.edit_page', $material->id)}}"
                                        class="btn btn-primary">Edit</a>
                                    <form style="display:inline" action="{{Route('receiving.material.delete')}}"
                                        method="POST">
                                        @csrf
                                        <input type="hidden" name="material_id" value="{{$material->id}}">
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
                {{$receiving->links()}}
            </div>
        </div>
        <!-- /.card -->
    </div>
</div>
@endsection