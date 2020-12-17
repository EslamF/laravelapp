<script src="https://cdn.jsdelivr.net/npm/vue"></script>
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<script>
    var app = new Vue({
        el: '#app',
        data: {
            produce_order_id: '',
            produce_orders: [],
            products: [],
            received_products: [],
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
                    document.getElementById('loader').style.display = 'block';
                }).catch(err => {

                });
            },
            listProducts(id) {
                this.ReceivedProducts(id);
                const metas = document.getElementsByTagName('meta');
                axios.defaults.headers = {
                    'Content-Type': 'application/json',
                    'Access-Control-Allow-Origin': '*',
                    'X-CSRF-TOKEN': metas['csrf-token'].getAttribute('content')
                };
                axios.get('{{url("orders/receiving-products/list")}}' + '/' + id).then(res => {
                    this.products = res.data;
                }).catch(err => {

                });
            },
            ReceivedProducts(id) {
                const metas = document.getElementsByTagName('meta');
                axios.defaults.headers = {
                    'Content-Type': 'application/json',
                    'Access-Control-Allow-Origin': '*',
                    'X-CSRF-TOKEN': metas['csrf-token'].getAttribute('content')
                };
                axios.get('{{url("orders/receiving-products/received/list")}}' + '/' + id).then(res => {
                    this.received_products = res.data;
                }).catch(err => {

                });
            },
            changeStatus(received, produce_code, index) { 

                this.validateAll();
                console.log('have_value ' + this.have_value);
                console.log('have_error ' + this.have_error);
                if(!this.have_error && this.have_value)
                {
                    var data = {};
                    data.produce_code = produce_code;
                    data.received = received;
                    const metas = document.getElementsByTagName('meta');
                    axios.defaults.headers = {
                        'Content-Type': 'application/json',
                        'Access-Control-Allow-Origin': '*',
                        'X-CSRF-TOKEN': metas['csrf-token'].getAttribute('content')
                    };
                    //axios.post('{{route("receiving_product.change_status")}}', data).then(res => {
                        //console.log(this.received_products, this.products);
                        if (received == 1) {
                            this.received_products.push(this.products[index]);
                            this.products.splice(index, 1);
                        } else {
                            this.products.push(this.received_products[index]);
                            this.received_products.splice(index, 1);
                        }
                    /*}).catch(err => {

                    });*/
                }
                
            },
            goToProduceOrderList() {
                this.validateAll();
                if (!this.have_error) 
                {
                    var data = {};
                    data.produce_order_id = this.produce_order_id;
                    data.received_products = this.received_products;
                    data.products = this.products;
                    const metas = document.getElementsByTagName('meta');
                    axios.defaults.headers = {
                        'Content-Type': 'application/json',
                        'Access-Control-Allow-Origin': '*',
                        'X-CSRF-TOKEN': metas['csrf-token'].getAttribute('content')
                    };
                    axios.post('{{route("order_status")}}', data).then(res => {
                        $("#btnSubmit").attr("disabled", true);

                        window.location.href = "{{Route('receiving.product.list')}}";
                    }).catch(err => {

                    });
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
                $.each(this.received_products, function(index, product) {
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