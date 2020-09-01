<script src="https://cdn.jsdelivr.net/npm/vue"></script>
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<script>
    var app = new Vue({
        el: '#app',
        data: {
            search_phone: '',
            customers: [],
            customer_id: '',
            customer: {
                id: '',
                name: '',
                address: '',
                link: '',
                phone: '',
                source: '',
                type: '',
            },
            product: {
                qty: '',
                err: '',
                price: ''
            },
            description: '',
            mq_r_code: '',
            products: [],
            data: [],
            errors: [],
            delivery_date: '',
            error: '',
            have_error: false,
            customer_errors: {}
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
                console.log(this.delivery_date);

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
                    this.data = res.data;
                    this.addToProduct();
                }).catch(err => {

                });
            },
            addToProduct() {
                for (i = 0; i < this.data.length; i++) {
                    this.checkIfExistsInProduct(this.data[i]);
                }
            },
            checkIfExistsInProduct(item) {
                if (this.products.length > 0) {
                    var checker = false;
                    for (i = 0; i < this.products.length; i++) {
                        if (this.products[i].produce_code == item.produce_code &&
                            this.products[i].product_type == item.product_type &&
                            this.products[i].size == item.size) {
                            continue;
                        } else {
                            checker = true;
                        }
                    }
                    if (checker) {
                        console.log(checker);
                        console.log('test');
                        this.products.push(item);
                    }
                } else {
                    console.log(checker);
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
            },
            sendOrder() {
                this.customerValidate();
                if (!this.have_error) {
                    let data = {};
                    data.customer = this.customer;
                    data.products = this.products;
                    data.description = this.description;
                    data.delivery_date = this.delivery_date;
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
                this.customer_errors = {}

                if (!this.customer.name) {
                    this.customer_errors.name = "* field is required";
                    this.have_error = true;
                }
                if (!this.customer.phone) {
                    this.customer_errors.phone = "* field is required"
                    this.have_error = true;
                }
                if (!this.customer.address) {
                    this.customer_errors.address = "* field is required"
                    this.have_error = true;
                }
                if (!this.customer.source) {
                    this.customer_errors.source = "* field is required"
                    this.have_error = true;
                }
                if (!this.customer.link) {
                    this.customer_errors.link = "* field is required"
                    this.have_error = true;
                }
                this.productsValidate();
            },
            productsValidate() {
                this.error = {
                    qty: '',
                    price: ''
                };

                var reg = new RegExp('^(?:0|00)\d+$')

                for (i = 0; i < this.products.length; i++) {
                    let error = {}
                    this.products[i].error_qty = '';
                    this.products[i].error_price = '';
                    this.products[i].price_err = '';

                    if (this.products[i].qty > this.products[i].company_count) {
                        this.setDate(7);
                    }

                    if ((this.products[i].qty <= 0 && this.products[i].qty !== "")) {
                        console.log('test1');
                        this.products[i].error_qty = "* this field is required";
                        this.have_error = true;
                    }

                    if (this.products[i].price > 0 && !this.products[i].qty || reg.test(this.products[i].qty)) {
                        console.log('test2');
                        this.products[i].error_qty = "* this field is required";
                        this.have_error = true;
                    }

                    if ((this.products[i].qty > 0 && !this.products[i].price) || this.products[i].price <= 0) {
                        this.products[i].price_err = "* this field is required";
                        console.log('test3');

                        this.have_error = true;
                    }

                }
            }

        }

    })
</script>