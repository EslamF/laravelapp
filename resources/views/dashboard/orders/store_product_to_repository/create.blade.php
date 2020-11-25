@extends('index')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            @csrf
            <div class="card-header">
                <h3 class="card-title">Store Order To Repository Table</h3>
                <button type="button" class="btn btn-success float-right submit-form">Add</button>
            </div>
            <div>
                <div class="row ml-3 mr-3 mt-3">
                    <div class="col-md-8">
                        <div class="form-group">
                            <label for="tags">Products</label>
                            <span class="error" style="display:none;color:red;font-weight:500"> * Invalid Product</span>
                            <input style="display: block;" type="text" class="form-control code" class="form-control" name="products" placeholder="Add Product Code" />

                        </div>
                        <div class="parent-count" style="display: none;">
                            <span class="mt-3" style="font-weight:bold;display:inline">Products need to be add(</span>
                            <span style="color:red" class="count"></span>
                            <span style="font-weight:bold;display:inline">)</span>

                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">Select Order</label>
                            <span class="select-error" style="display:none;color:red;font-weight:500"> * Select Order first</span>
                            <select id="order" name="save_order_id" class="form-control order">
                                <option value="" selected disabled>Choose Order</option>
                                @foreach($orders as $order)
                                <option value="{{$order->id}}">{{$order->code}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <table class="table">
                            <thead>
                                <tr class="row" style="display: none;">
                                    <th class="col-md-12">Product Code</td>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
            <!-- /.card-body -->
            <div class="card-footer clearfix">

            </div>
        </div>
        <!-- /.card -->
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous">
</script>
<script>
    var totalLength;
    var products = [];
    var addProducts = [];
    var count = 0;
    var save_order_id;
    $(document).ready(function() {
        $('select#order').on('change', function() {
            $('.select-error').css('display', 'none');
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
                    $('.parent-count').css('display', 'block');

                    $.each(res, function(index, value) {
                        count = 0;
                        products = [];
                        addProducts = [];
                        $.each(value.products, function(index, product) {
                            products.push(product.prod_code);
                            save_order_id = product.save_order_id;
                            count++;
                        });
                    });
                    $('span.count').empty();
                    $('span.count').append(count);
                }
            });

        });

    });
    $(document).keypress(function(event) {
        var keycode = (event.keyCode ? event.keyCode : event.which);
        if (keycode == '13') {
            if (products.length > 0) {
                if (products.includes($('.code').val()) && !addProducts.includes($('.code').val())) {
                    $('.error').css('display', 'none');
                    $("tbody").empty();
                    addProducts.push($('.code').val());
                    count--;
                    $('span.count').empty();
                    $('span.count').append(count);
                    $.each(addProducts, function(index, value) {
                        $("tbody").append(
                            '<tr class="row">' +
                            '<td class="col-md-12">' + value + '</td>' +
                            '</tr>'
                        );
                    });
                    $('.code').val('');
                } else {
                    $('.error').css('display', 'inline');
                }
            } else {
                $('.select-error').css('display', 'inline')
            }
        }
    });

    $(document).ready(function() {
        $('.submit-form').on('click', function() {
            if (products.length != 0 && products.length == addProducts.length) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type: "POST",
                    url: "{{url('orders/store-end-product/store')}}",
                    dataType: "json",
                    data: {
                        'data': addProducts,
                        'save_order_id': save_order_id
                    },
                    success: function(msg) {
                        window.location.href = "{{url('orders/store-end-product/get-all')}}";
                    }
                });
            } else {

            }
        })
    })
</script>
@endsection