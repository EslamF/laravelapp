<script src="https://cdn.jsdelivr.net/npm/vue"></script>
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<script>
    Vue.config.devtools = true
    var app = new Vue({
        el: '#app',
        data: {
            search_phone: '',
            customers: [],
            customer_id: '{{$order->customer_id}}',
            buy_order_id: '{{$order->id}}',
            customer: {
                id: '',
                name: '',
                notes: '',
                address: '',
                link: '',
                phone: '',
                source: '',
                type: '',
                buy_orders: []
            },
            product: {
                qty: '',
                err: '',
                price: ''
            },
            description: '{{$order->description}}',
            mq_r_code: '',
            mq_r_code_err : '' ,
            products: [],
            data: [],
            errors: [],
            delivery_date: '{{$order->delivery_date}}',
            error: '',
            have_error: false,
            customer_errors: {},
            have_value: true,
            price: '{{$order->price}}',
            price_error: '',
            order_number: '{{$order->order_number}}',
        },
        mounted() {
            this.getCustomer();
            //this.getOrder();
            this.getOrderProducts();
            //this.setDate(2);
        },
        methods: {
            getOrderProducts() {
                const metas = document.getElementsByTagName('meta');
                axios.defaults.headers = {
                    'Content-Type': 'application/json',
                    'Access-Control-Allow-Origin': '*',
                    'X-CSRF-TOKEN': metas['csrf-token'].getAttribute('content')
                };
                axios.get('{{url("orders/buy/show-order-in-edit-page")}}' + '/' + this.buy_order_id).then(res => {
                    console.log('getOrderProducts');
                    console.log(res.data);
                    this.data = res.data;
                    console.log('data length');
                    console.log(this.data.length);
                    this.addToProduct();
                    console.log(this.products);
                }).catch(err => {

                });

            } ,
            /*searchOnCustomer() {
                this.customers = [];
                const metas = document.getElementsByTagName('meta');
                axios.defaults.headers = {
                    'Content-Type': 'application/json',
                    'Access-Control-Allow-Origin': '*',
                    'X-CSRF-TOKEN': metas['csrf-token'].getAttribute('content')
                };
                axios.get('{{url("customers/search")}}' + '/' + this.search_phone).then(res => {
                    this.customers = res.data;
                }).catch(err => {

                });
            },*/
            /*setDate(numberOfDaysToAdd) {
                var someDate = new Date();
                someDate.setDate(someDate.getDate() + numberOfDaysToAdd);
                var dd = someDate.getDate();
                var mm = (someDate.getMonth() + 1 > 9) ? someDate.getMonth() + 1 : '0' + (someDate.getMonth() + 1);
                var y = someDate.getFullYear();

                this.delivery_date = y + '-' + mm + '-' + dd;
                //document.getElementById('loader').style.display = 'block';

            },*/

            getOrder() {
                axios.get('{{url("orders/buy/show")}}' + '/' + this.buy_order_id )
                    .then(res => {
                        //this.data = res.data;
                        //document.getElementById('loader').style.display = 'block'
                        //this.getGrandTotal();
                        console.log('my order');
                        console.log(res.data);
                    }).catch(err => {

                    })
            },

            getCustomer() {
                const metas = document.getElementsByTagName('meta');
                axios.defaults.headers = {
                    'Content-Type': 'application/json',
                    'Access-Control-Allow-Origin': '*',
                    'X-CSRF-TOKEN': metas['csrf-token'].getAttribute('content')
                };
                axios.get('{{url("customers/get")}}' + '/' + this.customer_id).then(res => {
                    this.customer = res.data;
                }).catch(err => {

                });
            },
            cuttingOrders() {
                const metas = document.getElementsByTagName('meta');
                axios.defaults.headers = {
                    'Content-Type': 'application/json',
                    'Access-Control-Allow-Origin': '*',
                    'X-CSRF-TOKEN': metas['csrf-token'].getAttribute('content')
                };
                axios.get('{{url("orders/buy/get-material")}}' + '/' + this.mq_r_code).then(res => {
                    this.mq_r_code_err = '' ;
                    console.log('mq r code products');
                    console.log(res.data);
                    this.data = res.data;
                    this.addToProduct();
                }).catch(err => {

                });
            },
            addToProduct() {
                for (var i = 0; i < this.data.length; i++) {
                    this.checkIfExistsInProduct(this.data[i]);
                }
            },
            checkIfExistsInProduct(item) {
                if (this.products.length > 0) {
                    for (var i = 0; i < this.products.length; i++) {
                        if (this.products[i].produce_code == item.produce_code &&
                            this.products[i].product_type == item.product_type &&
                            this.products[i].size == item.size) {
                            checker = false;
                            break;
                        } else {
                            checker = true;
                        }
                    }
                    if (checker) {
                        this.products.push(item);
                    }

                } else {
                    this.products.push(item);

                }

            },
            updateStock(index, qty) {
                this.have_error = false;
                this.products[index].err = '';

                if (this.products[index].company_count + this.products[index].factory_count < qty) {
                    this.products[index].err = "You can't use this amount";
                    this.have_error = true;
                }
                else if(qty != '' && qty > 0)
                {
                    this.have_value = true;
                }

            },
            sendOrder() {
              
                
                this.customerValidate();
                //console.log('have value : ' + this.have_value + ' .. have error : ' + this.have_error);
                if (!this.have_error && this.have_value) {
                    $("#btnSubmit").attr("disabled", true);
                    document.getElementById('loader').style.display = 'block';
                    let data = {};
                    //data.customer = this.customer;
                    data.products = this.products;
                    data.buy_order_id = this.buy_order_id;
                    data.description = this.description;
                    data.delivery_date = this.delivery_date;
                    data.customer_id = this.customer_id;
                    data.price = this.price;
                    data.order_number = this.order_number;
                    const metas = document.getElementsByTagName('meta');
                    axios.defaults.headers = {
                        'Content-Type': 'application/json',
                        'Access-Control-Allow-Origin': '*',
                        'X-CSRF-TOKEN': metas['csrf-token'].getAttribute('content')
                    };
                    axios.post('{{route("buy.edit_order")}}', data).then(res => {
                        window.location.href = "{{Route('buy.list_page')}}";
                    }).catch(err => {

                    });
                }
            },
            customerValidate() {

                this.have_error = false;
                this.customer_errors = {}

                this.productsValidate();

                //price
                if(!this.price || this.price < 1) {
                    this.price_error = "يجب إدخال السعر";
                    this.have_error = true;
                }

            },
            productsValidate() {

                this.error = {
                    qty: '',
                    price: ''
                };

                var reg = new RegExp('^(?:0|00)\d+$')

                this.have_value = false ;
                this.mq_r_code_err = '' ;


                /*if(!this.mq_r_code)
                {
                    this.mq_r_code_err = 'يجب إدخال كود الخامة';
                    this.have_error = true;
                }*/
                for (var i = 0; i < this.products.length; i++) {
                    let error = {}
                    this.products[i].error_qty = '';
                    this.products[i].error_price = '';
                    this.products[i].price_err = '';
                    //extra
                    this.products[i].err = "";
                    /*if (this.products[i].qty > this.products[i].company_count) {
                        this.setDate(7);
                    }*/

                    /*if ((this.products[i].qty <= 0 && this.products[i].qty !== "")) {
                        console.log(i + ' : ' + 1);
                        this.products[i].error_qty = "* يجب ادخال هذا الحقل";
                        this.have_error = true;
                    }*/

                    /*
                    if (this.products[i].price > 0 && !this.products[i].qty || reg.test(this.products[i].qty)) {
                        console.log(i + ' : ' + 2);
                        this.products[i].error_qty = "* يجب ادخال هذا الحقل";
                        this.have_error = true;
                    }

                    if(   !(this.products[i].price <= 0 && this.products[i].qty <=0 ))
                    {
                        if (   (this.products[i].qty > 0 && !this.products[i].price) || (this.products[i].qty > 0 && this.products[i].price <= 0)  )   {
                            //!(this.products[i].price <= 0 && this.products[i].qty <=0)
                            console.log(i + ' : ' + 3);
                            console.log( 'condition 1 : ' + (this.products[i].qty > 0 && !this.products[i].price) );
                            console.log( 'condition 1 : ' + (this.products[i].price <= 0) );
                            console.log('price : ' + this.products[i].price);
                            this.products[i].price_err = "* يجب ادخال هذا الحقل";

                            this.have_error = true;
                        }
                    }   */
                    

                    //extra : if the price and quantity are 0 in the same time => success



                    if (this.products[i].qty && this.products[i].qty > 0) {
                        console.log(i + ' : ' + 4);
                        this.have_value = true;
                    }
                    //extra
                    if (this.products[i].company_count + this.products[i].factory_count < this.products[i].qty) {
                        //console.log(i + ' : ' + 1);
                        //console.log('index : ' + i);
                        //console.log('company_count :  ' + this.products[i].company_count);
                        //console.log('factory_count :  ' + this.products[i].factory_count);
                        //console.log('qty :  ' + this.products[i].qty);
                        console.log(i + ' : ' + 5);
                        this.products[i].error_qty = "You can't use this amount";
                        this.have_error = true;
                    }
                }

            }

        }

    })
</script>