@extends('index')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"> المقاسات</h3>
                <a href="{{Route('size.create_page')}}" class="btn btn-success float-right">انشاء</a>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th> الرقم المرجعي</th>
                            <th>المقاسات</th>
                            <th>الالخيارات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($types as $size)
                        <tr>
                                <td>{{$size->id}}</td>
                                <td>{{$size->name}}</td>
                                <td>
                                    <a href="{{Route('size.edit_page', $size->id)}}" class="btn btn-primary">تعديل</a>
                                    <form style="display:inline" action="{{Route('size.delete')}}" method="POST">
                                        @csrf
                                        <input type="hidden" name="type_id" value="{{$size->id}}">
                                        <button type="submit" class="btn btn-danger">حذف</button>
                                    </form>
                                </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
            <div class="card-footer clearfix">
                {{$types->links()}}
            </div>
        </div>
        <!-- /.card -->
    </div>
</div>
@endsection