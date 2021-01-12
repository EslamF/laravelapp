<script src="https://cdn.jsdelivr.net/npm/vue"></script>
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<script>
    var app = new Vue({
        el: '#app',
        data: {
            produce_order_id: '',
            produce_orders: [],
            products: [],
            error: {
                produce_order_id: '',
            },
            have_error: false ,
            have_value: true
        },
        mounted() {
            this.getProductOrders();
        },
        methods: {
            getProductOrders() {
                const metas = document.getElementsByTagName('meta');
                axios.defaults.headers = {
                    'Content-Type': 'application/json',
                    'Access-Control-Allow-Origin': '*',
                    'X-CSRF-TOKEN': metas['csrf-token'].getAttribute('content')
                };
                axios.get('{{Route("produce_order.get_all")}}').then(res => {
                    this.produce_orders = res.data;
                    console.log(res.data);
                    //document.getElementById('loader').style.display = 'block';
                }).catch(err => {

                });
            },
            listProducts(id) {
                const metas = document.getElementsByTagName('meta');
                axios.defaults.headers = {
                    'Content-Type': 'application/json',
                    'Access-Control-Allow-Origin': '*',
                    'X-CSRF-TOKEN': metas['csrf-token'].getAttribute('content')
                };
                axios.get('{{url("orders/receiving-products/allProducts")}}' + '/' + id).then(res => {
                    this.products = res.data;
                    console.log(res.data);
                }).catch(err => {

                });
            },
            goToProduceOrderList() {
                this.validateAll();
                if (!this.have_error) 
                {

                    // pop message when we not recieve all the products
                    var all_count = 0;
                    var all_received = 0;
                    var all_required = 0;

                    $.each(this.products, function(index, product) {
                        all_count+= parseInt(product.count) ;
                        all_received+= parseInt(product.number_of_received) ;
                        all_required+= parseInt(product.required) ;
                    });
                    
                    all_count = parseInt(all_count);
                    all_required = parseInt(all_required);

                    if(all_required != all_count)
                    {
                        swal({
                            title: "هل انت متأكد؟",
                            text: "أنت لم تستلم كل المنتجات التابعة لإذن التصنيع ! ",
                            icon: "warning",
                            buttons: true,
                            dangerMode: true,
                        })
                        .then((sure) => {
                            if (sure) {
                                //console.log(data);
                                $("#btnSubmit").attr("disabled", true);
                                document.getElementById('loader').style.display = 'block';
                                var data = {};
                                data.produce_order_id = this.produce_order_id;
                                data.products = this.products;
                                //console.log(data);
                                const metas = document.getElementsByTagName('meta');
                                axios.defaults.headers = {
                                    'Content-Type': 'application/json',
                                    'Access-Control-Allow-Origin': '*',
                                    'X-CSRF-TOKEN': metas['csrf-token'].getAttribute('content')
                                };
                                axios.post('{{route("order_status")}}', data).then(res => {
                                    swal("تم الإضافة بنجاح", {
                                            icon: "success",
                                        });

                                        window.location.href = "{{Route('receiving.product.list')}}";
                                }).catch(err => {

                                });
                  
                            }
                        });
                    }

                    else 
                    {
                        $("#btnSubmit").attr("disabled", true);
                        document.getElementById('loader').style.display = 'block';
                        var data = {};
                        data.produce_order_id = this.produce_order_id;
                        data.products = this.products;
                        //console.log(data);
                        const metas = document.getElementsByTagName('meta');
                        axios.defaults.headers = {
                            'Content-Type': 'application/json',
                            'Access-Control-Allow-Origin': '*',
                            'X-CSRF-TOKEN': metas['csrf-token'].getAttribute('content')
                        };
                        axios.post('{{route("order_status")}}', data).then(res => {
                            swal("تم الإضافة بنجاح", {
                                    icon: "success",
                                });

                                window.location.href = "{{Route('receiving.product.list')}}";
                        }).catch(err => {

                        });
                    }


                    
                }
                
            } , 

            validateAll() {
                this.have_error = false;
                this.error = {
                    produce_order_id: '',
                }

                if (!this.produce_order_id) {
                    this.error.produce_order_id = "* يجب إدخال إذن التصنيع";
                    this.have_error = true;
                }

                var have_error_var = this.have_error;
                var have_value_var = false;

                $.each(this.products, function(index, product) {
                    product.err = '';
                    if (product.count < product.required) 
                    {
                        console.log('You cant use this amount');
                        product.err = "You can't use this amount";
                        have_error_var = true;
                    }
                    else if(product.required != '' && product.required > 0 && !have_value_var)
                    {
                        have_value_var = true;
                    }
                });
                this.have_error = have_error_var ;
                this.have_value = have_value_var ;

            }
        }

    })
</script>