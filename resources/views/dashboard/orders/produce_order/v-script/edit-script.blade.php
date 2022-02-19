<script src="https://cdn.jsdelivr.net/npm/vue"></script>
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<script>
    Vue.createApp({
        data() {
            return {
                cutting_orders: [],
                available_products: [] ,
                factories: [],
                factory_id: "{{$data['records']->factory_id}}",
                cutting_order_id: "{{$data['records']->cutting_order_id}}",
                receiving_date: "{{$data['records']->receiving_date}}",
                out_date: "{{$data['records']->out_date}}",
                factory_type_id: "{{$data['records']->factory->factory_type_id}}",
                produce_order_id: "{{$data['records']->id}}",
                error: {
                    factory_id: '',
                    cutting_order_id: '',
                    receiving_date: '',
                    out_date: ''
                },
                factory_types: [],
                have_error: false,
                have_value: false,
            }
           
        },
        mounted() {
            this.getCuttingOrders();
            this.getFactoryTypes();
            this.getFactory();
            this.getAvailableProducts();
        },
        methods: {
            getFactoryTypes() {
                axios.get('{{Route("factory.type_all")}}')
                    .then(res => {
                        this.factory_types = res.data;
                    }).catch(err => {

                    })
            },
            getCuttingOrders() {
                const metas = document.getElementsByTagName('meta');
                axios.defaults.headers = {
                    'Content-Type': 'application/json',
                    'Access-Control-Allow-Origin': '*',
                    'X-CSRF-TOKEN': metas['csrf-token'].getAttribute('content')
                };
                axios.get('{{Route("cutting_order.all")}}').then(res => {
                    this.cutting_orders = res.data;
                    //document.getElementById('loader').style.display = 'block';
                }).catch(err => {

                });
            },
            getAvailableProducts() {
                //console.log('cutting_order_id : ' + this.cutting_order_id);

                this.available_products = [];
                var data = {};
                //data.cutting_order_id = this.cutting_order_id;
                data.produce_order_id = this.produce_order_id;  

                console.log(data);

                const metas = document.getElementsByTagName('meta');
                axios.defaults.headers = {
                    'Content-Type': 'application/json',
                    'Access-Control-Allow-Origin': '*',
                    'X-CSRF-TOKEN': metas['csrf-token'].getAttribute('content')
                };
                axios.post('{{Route("produce_order.getAvailableProducts")}}' , data).then(res => {
                    console.log(res.data);
                    var products_array = [];
                    var have_value_var = false;
                    $.each(res.data, function(key, value) {
                        var counting = 0;
                        for(var i = 0; i<value.length; i++)
                        {
                            if(value[i].produce_order_id)
                            {
                                counting++;
                            }
                        }
                       
                        var object = {
                            'produce_code' : key ,
                            'quantity'     : value.length ,
                            'name'         : value[0].product_type.name  ,
                            'size'         : value[0].size.name ,
                            'required_quantity' : counting
                        } ;
                        products_array.push(object);

                        if(object.quantity > 0)
                        {
                            have_value_var = true ;
                        }
                    });

                    this.available_products = products_array;
                    this.have_value = have_value_var ;
                    console.log(this.available_products);

                }).catch(err => {

                });

            } ,

            checkQuantity(index , quantity) {

                //this.have_error = false;
                this.available_products[index].err = '';

                if (this.available_products[index].quantity < this.available_products[index].required_quantity) {
                    this.available_products[index].err = "You can't use this amount";
                    this.have_error = true;
                }
                else if(this.available_products[index].required_quantity != '' && this.available_products[index].required_quantity > 0)
                {
                    this.have_value = true;
                }

            } ,
            
            getFactoryByCuttingId(id) {
                this.getAvailableProducts();
                const metas = document.getElementsByTagName('meta');
                axios.defaults.headers = {
                    'Content-Type': 'application/json',
                    'Access-Control-Allow-Origin': '*',
                    'X-CSRF-TOKEN': metas['csrf-token'].getAttribute('content')
                };
                axios.get('{{url("/factory/get-by-cutting/")}}' + '/' + id).then(res => {
                    this.factory_id = res.data.id;
                }).catch(err => {

                });
            },
            getFactory() {
                const metas = document.getElementsByTagName('meta');
                axios.defaults.headers = {
                    'Content-Type': 'application/json',
                    'Access-Control-Allow-Origin': '*',
                    'X-CSRF-TOKEN': metas['csrf-token'].getAttribute('content')
                };
                axios.get('{{url("factory/get-by-id")}}' + '/' + this.factory_type_id).then(res => {
                    this.factories = res.data;
                }).catch(err => {

                });
            },
            store() {
                var data = {};
                data.factory_id = this.factory_id;
                data.factory_type_id = this.factory_type_id;
                data.produce_order_id = this.produce_order_id;
                data.receiving_date = this.receiving_date;
                data.out_date = this.out_date;
                data.products = this.available_products;
                //console.log(this.have_error);
                this.validations();
                //console.log(this.have_error);
                if (!this.have_error) {

                    // pop message when we not recieve all the products
                    var all = 0;
                    var required = 0;
                    $.each(this.available_products, function(index, product) {
                        all+= product.quantity ;
                        required+= parseInt( product.required_quantity) ;
                        //console.log('required q : ' + product.required_quantity);
                    });

                    all = parseInt(all);
                    required = parseInt(required);
                    //console.log('all : ' + all);
                    //console.log('required : ' + required);

                    if(all != required)
                    {
                        swal({
                            title: "هل انت متأكد؟",
                            text: "أنت لم تستلم كل المنتجات التابعة لإذن القص ! ",
                            icon: "warning",
                            buttons: true,
                            dangerMode: true,
                        })
                        .then((sure) => {
                            if (sure) {
                                //console.log(data);
                                $("#btnSubmit").attr("disabled", true);
                                document.getElementById('loader').style.display = 'block';
                                const metas = document.getElementsByTagName('meta');
                                axios.defaults.headers = {
                                    'Content-Type': 'application/json',
                                    'Access-Control-Allow-Origin': '*',
                                    'X-CSRF-TOKEN': metas['csrf-token'].getAttribute('content')
                                };
                                axios.post('{{Route("produce.order.update")}}', data).then(res => {
                                    //console.log(res.data); 
                                    if(res.data != 'error')
                                    {
                                                swal("تم التعديل بنجاح", {
                                                    icon: "success",
                                                });
                                            window.location.href = "{{Route('produce.order.list')}}"
                                    }
                                }).catch(err => {

                                });
                            }
                        });

                    }

                    else 
                    {
                        $("#btnSubmit").attr("disabled", true);
                        document.getElementById('loader').style.display = 'block';
                        const metas = document.getElementsByTagName('meta');
                        axios.defaults.headers = {
                            'Content-Type': 'application/json',
                            'Access-Control-Allow-Origin': '*',
                            'X-CSRF-TOKEN': metas['csrf-token'].getAttribute('content')
                        };
                        axios.post('{{Route("produce.order.update")}}', data).then(res => {
                            if(res.data != 'error')
                            {
                                swal("تم التعديل بنجاح", {
                                    icon: "success",
                                });
                                window.location.href = "{{Route('produce.order.list')}}"
                            }
                                
                        }).catch(err => {

                        });
                    }
                }

                    
            } ,
            
            validations() {
                this.have_error = false;
                this.error = {
                    factory_id: '',
                    cutting_order_id: '',
                    receiving_date: '',
                    out_date: ''
                }
                if (!this.cutting_order_id) {
                    console.log('cutting_order_id');
                    this.error.cutting_order_id = "* this field is required";
                    this.have_error = true;
                }

                if (!this.factory_id) {
                    console.log('factory_id');
                    this.error.factory_id = "* this field is required";
                    this.have_error = true;
                }

                if (!this.receiving_date) {
                    console.log('receiving_date');
                    this.error.receiving_date = "* this field is required";
                    this.have_error = true;
                }

                if (!this.out_date) {
                    console.log('out_date');
                    this.error.out_date = "* this field is required";
                    this.have_error = true;
                }

                var have_error_var = this.have_error;
                var have_value_var = false;

                $.each(this.available_products, function(index, product) {

                    product.err = '';

                    if (product.quantity < product.required_quantity) {
                        console.log('You cant use this amount');
                        product.err = "You can't use this amount";
                        have_error_var = true;
                    }
                    else if(product.required_quantity != '' && product.required_quantity > 0 && !have_value_var)
                    {
                        have_value_var = true;
                    }

                });

                this.have_error = have_error_var ;
                this.have_value = have_value_var ;

                //console.log(this.have_value);
            }
        }

    }).mount("#app")
</script>