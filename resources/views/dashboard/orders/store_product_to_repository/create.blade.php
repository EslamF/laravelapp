@extends('index')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Store Order To Repository Table</h3>
                <a href="{{Route('store.end_product.create_page')}}" class="btn btn-success float-right">Add</a>
            </div>
            <div>
                <form action="{{Route('')}}" method="POST">
                    <div class="row ml-3 mr-3 mt-3">
                        <div class="col-md-8">
                            <div class="form-group">
                                <label for="tags" style="display:block">Products</label>
                                <input style="display: block;" type="text" class="form-control" id="tags" class="form-control" name="products" placeholder="Add Product Code" data-role="tagsinput" />
                                <div class="mt-4 parent-count" style="display: none;">
                                    <span class="count"></span> of Total <span class="totat-count"></span> are received
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">Select Order</label>
                                <select id="order" class="form-control order">
                                    <option value="" selected disabled>Choose Order</option>
                                    @foreach($orders as $order)
                                    <option value="{{$order->id}}">{{$order->code}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr class="row" style="display: none;">
                            <th class="col-md-6">id</td>
                            <th class="col-md-6">Product Name</td>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
            <div class="card-footer clearfix">

            </div>
        </div>
        <!-- /.card -->
    </div>
</div>
<script src="http://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous">
</script>
<script>
    var totalLength;
    $(document).ready(function() {

        $('select#order').on('change', function() {
            var selected = $(this).children("option:selected").val();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });
            jQuery.ajax({
                url: "{{ url('orders/store-end-product/order/') }}" + "/" + selected,
                type: 'GET',
                dataType: 'json', // added data type
                success: function(res) {
                    totalLength = res.length;

                    $('thead .row').css('display', 'flex');
                    $.each(res, function(index, value) {
                        $("tbody").append(
                            '<tr class="row">' +
                            '<td class="col-md-6">' + value.id + '</td>' +
                            '<td class="col-md-6">' + value.name + '</td>' +
                            '</tr>'
                        )
                    });
                }
            });

        });

    });
    $(document).keypress(function(event) {
        $('.parent-count').css('display', 'block')
        var keycode = (event.keyCode ? event.keyCode : event.which);
        if (keycode == '13') {
            console.log(totalLength)
            var inputV = $('#tags').val();
            var list = inputV.split(",");
            console.log(list);
            $(".count").empty();
            $(".count").append(list.length);
            $(".totat-count").empty();
            $(".totat-count").append(totalLength);
        }
    });
</script>
@endsection