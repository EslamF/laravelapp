<script src="https://cdn.jsdelivr.net/npm/vue"></script>
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<script>
    Vue.config.devtools = true
    var app = new Vue({
        el: '#app',
        data: {
            search_phone: '',
            customers: [],
            customer_id: '',
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
            description: '',
            mq_r_code: '',
            mq_r_code_err : '' ,
            products: [],
            data: [],
            errors: [],
            delivery_date: '',
            error: '',
            have_error: false,
            customer_errors: {},
            have_value: false,
            price: 0,
            price_error: '',
            order_number: '',
        },
        mounted() {
            this.setDate(2);
        },
        methods: {
            searchOnCustomer() {
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
            },
            setDate(numberOfDaysToAdd) {
                var someDate = new Date();
                someDate.setDate(someDate.getDate() + numberOfDaysToAdd);
                var dd = someDate.getDate();
                var mm = (someDate.getMonth() + 1 > 9) ? someDate.getMonth() + 1 : '0' + (someDate.getMonth() + 1);
                var y = someDate.getFullYear();

                this.delivery_date = y + '-' + mm + '-' + dd;
                //document.getElementById('loader').style.display = 'block';

            },
            getCustomer() {
                const metas = document.getElementsByTagName('meta');
                axios.defaults.headers = {
                    'Content-Type': 'application/json',
                    'Access-Control-Allow-Origin': '*',
                    'X-CSRF-TOKEN': metas['csrf-token'].getAttribute('content')
                };
                axios.get('{{url("customers/get")}}' + '/' + this.customer_id).then(res => {
                    console.log(res.data);
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
                    console.log(res.data);
                    this.data = res.data;
                    this.addToProduct();
                }).catch(err => {

                });
            },
            addToProduct() {
                
                for (var i = 0; i < this.data.length; i++) {
                    //console.log("i " + i);
                    this.checkIfExistsInProduct(this.data[i]);
                    
                }
            },
            checkIfExistsInProduct(item) {
                //console.log('item');
                //console.log(item);
                
                if (this.products.length > 0) {
                    for (var i = 0; i < this.products.length; i++) {
                        //if (this.products[i].produce_code == item.produce_code &&
                        if (this.products[i].product_material_code == item.product_material_code &&
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
                //console.log("new");
                
                this.customerValidate();
                //console.log('have value : ' + this.have_value + ' .. have error : ' + this.have_error);
                if (!this.have_error && this.have_value) {
                    $("#btnSubmit").attr("disabled", true);
                    //console.log(document.getElementById('loader'));
                    document.getElementById('loader').style.display = 'block';
                    let data = {};
                    data.customer = this.customer;
                    data.products = this.products;
                    data.description = this.description;
                    data.delivery_date = this.delivery_date;
                    data.price = this.price;
                    data.order_number = this.order_number;
                    console.log('products');
                    console.log(data.products);
                    console.log('data');
                    console.log(data);
                    console.log('price');
                    console.log(data.price);
                    const metas = document.getElementsByTagName('meta');
                    axios.defaults.headers = {
                        'Content-Type': 'application/json',
                        'Access-Control-Allow-Origin': '*',
                        'X-CSRF-TOKEN': metas['csrf-token'].getAttribute('content')
                    };
                    axios.post('{{route("buy.receive_order")}}', data).then(res => {
                        window.location.href = "{{Route('buy.list_page')}}";
                    }).catch(err => {

                    });
                }
            },
            customerValidate() {

                this.have_error = false;
                this.customer_errors = {};
                this.price_error = "";

                if (!this.customer.name) {
                    this.customer_errors.name = "* يجب ادخال هذا الحقل";
                    this.have_error = true;
                }
                if (!this.customer.phone) {
                    this.customer_errors.phone = "* يجب ادخال هذا الحقل"
                    this.have_error = true;
                }
                if (!this.customer.address) {
                    this.customer_errors.address = "* يجب ادخال هذا الحقل"
                    this.have_error = true;
                }
                if (!this.customer.source) {
                    this.customer_errors.source = "* يجب ادخال هذا الحقل"
                    this.have_error = true;
                }
                if (!this.customer.link) {
                    this.customer_errors.link = "* يجب ادخال هذا الحقل"
                    this.have_error = true;
                }
                this.productsValidate();

                //price
                if(!this.price || this.price < 1) {
                    this.price_error = "يجب إدخال السعر";
                    this.have_error = true;
                }

                //console.log()
            },
            productsValidate() {
                //console.log("products validation");
                this.error = {
                    qty: '',
                    price: ''
                };

                var reg = new RegExp('^(?:0|00)\d+$')

                this.have_value = false ;
                this.mq_r_code_err = '' ;


                /*if(!this.mq_r_code)
                {
                    //console.log("mq r code validation");
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
                    }   
                    */
                    

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