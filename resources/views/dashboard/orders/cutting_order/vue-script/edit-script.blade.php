<script src="https://cdn.jsdelivr.net/npm/vue"></script>
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<script>
    var app = new Vue({
        el: '#app',
        data: {
            users: [],
            productTypes: [],
            sizes: [],
            errors: [{
                product_id: '',
                size_id: '',
                qty: ''
            }],
            error: '',
            have_error: false,
            extra_returns_weight: '',
            cutting_order: {},
            layers: '',
            spreading_orders: [],
            employee_error: '',
            layer_error: '',
            spreading_order_error: '',
            extra_return_error: '',
            products: [],
            submited: false,
            factory_type_url: '{{Route("factory.type_all")}}',
            employee_url: '{{route("employee.get_all")}}',
            employee_id: '',

        },
        mounted() {
            this.getData();
            this.getSpreadingOrders();
            this.getProductType();
            this.getSizes();
            this.getBy();
        },
        methods: {
            getSpreadingOrders() {
                const metas = document.getElementsByTagName('meta');
                axios.defaults.headers = {
                    'Content-Type': 'application/json',
                    'Access-Control-Allow-Origin': '*',
                    'X-CSRF-TOKEN': metas['csrf-token'].getAttribute('content')
                };
                axios.get('{{route("spreading.get_all")}}').then(res => {
                    this.spreading_orders = res.data;
                    document.getElementById('loader').style.display = 'block';
                }).catch(err => {

                });
            },
            getBy(url) {
                const metas = document.getElementsByTagName('meta');
                axios.defaults.headers = {
                    'Content-Type': 'application/json',
                    'Access-Control-Allow-Origin': '*',
                    'X-CSRF-TOKEN': metas['csrf-token'].getAttribute('content')
                };
                axios.get("{{Route('cutting_order.employee')}}").then(res => {
                    this.users = res.data;

                }).catch(err => {

                });
            },
            addRow() {
                this.products.push({
                    type: '',
                    size: '',
                    qty: ''
                });
                this.errors.push({
                    product_type_id: '',
                    size_id: '',
                    qty: ''
                });
            },
            deleteRow(index) {
                if (this.products.length > 1) {
                    this.products.splice(index, 1);
                }
            },
            getProductType() {
                const metas = document.getElementsByTagName('meta');
                axios.defaults.headers = {
                    'Content-Type': 'application/json',
                    'Access-Control-Allow-Origin': '*',
                    'X-CSRF-TOKEN': metas['csrf-token'].getAttribute('content')
                };
                axios.get("{{Route('product.type.get_all')}}")
                    .then(res => {
                        this.productTypes = [];
                        this.productTypes = res.data;
                    }).catch(err => {

                    });
            },
            getSizes() {
                const metas = document.getElementsByTagName('meta');
                axios.defaults.headers = {
                    'Content-Type': 'application/json',
                    'Access-Control-Allow-Origin': '*',
                    'X-CSRF-TOKEN': metas['csrf-token'].getAttribute('content')
                };
                axios.get("{{Route('size.get_all')}}").then(res => {
                    this.sizes = [];
                    this.sizes = res.data;
                }).catch(err => {

                });
            },
            getData() {
                axios.get("{{Route('cutting.inner_factory_edit_data', $id)}}").then(res => {
                    console.log(res);
                    this.cutting_order = res.data.cutting_order;
                    this.products = res.data.products;
                    for (i = 0; i < this.products.length; i++) {
                        if (i > 0) {
                            this.errors.push({
                                product_type_id: '',
                                size_id: '',
                                qty: ''
                            });
                        }
                    }
                    console.log(this.errors);

                }).catch(err => {

                });
            },
            itemsValidation() {
                if (!this.cutting_order.user_id) {
                    this.employee_error = "* You must Choose Employee";
                } else {
                    this.employee_error = '';
                }
                if (!this.cutting_order.layers) {
                    this.layer_error = "* You must Add Layers";
                } else {
                    this.layer_error = '';
                }
                for (i = 0; i < this.products.length; i++) {

                    if (!this.products[i].type) {
                        this.have_error = true;
                        this.errors[i].product_type_id = '* Select Product type'
                    } else {
                        this.errors[i].product_type_id = ''
                    }

                    if (!this.products[i].size) {
                        this.have_error = true;
                        this.errors[i].size_id = '* Select Size'
                    } else {
                        this.errors[i].size_id = ''
                    }

                    if (!this.products[i].qty) {
                        this.have_error = true;
                        this.errors[i].qty = '* Add Qty'
                    } else {
                        this.errors[i].qty = ''
                    }
                    if (this.employee_error || this.layer_error) {
                        this.have_error = true;
                    }
                }
            },

            createOrder() {
                let data = {};
                if (!this.cutting_order.spreading_out_material_order_id) {
                    this.have_error = true;
                    this.spreading_order_error = "You Must Choose Spreading Order"
                } else {
                    this.spreading_order_error = ""
                }

                this.have_error = false;
                this.itemsValidation();
                data.products = this.products;
                data.user_id = this.cutting_order.user_id;
                data.extra_returns_weight = this.cutting_order.extra_returns_weight;
                data.layers = this.cutting_order.layers;
                data.cutting_order_id = this.cutting_order.id;
                data.spreading_out_material_order_id = this.cutting_order.spreading_out_material_order_id;
                if (!this.have_error) {
                    this.submited = true;
                    const metas = document.getElementsByTagName('meta');
                    axios.defaults.headers = {
                        'Content-Type': 'application/json',
                        'Access-Control-Allow-Origin': '*',
                        'X-CSRF-TOKEN': metas['csrf-token'].getAttribute('content')
                    };
                    axios.post("{{Route('cutting_order.update_inneer')}}", data).then(res => {

                        window.location.href = '{{Route("cutting.material.list")}}';

                    }).catch(err => {
                        this.submited = false
                    });
                } else {
                    console.log(this.have_error)
                }
            }
        }
    })
</script>