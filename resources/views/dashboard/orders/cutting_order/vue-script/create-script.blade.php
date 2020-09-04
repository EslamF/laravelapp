<script src="https://cdn.jsdelivr.net/npm/vue"></script>
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<script>
    var app = new Vue({
        el: '#app',
        data: {
            type: '',
            users: [],
            productTypes: [],
            sizes: [],
            factories: [],
            errors: [{
                product_id: '',
                size_id: '',
                qty: ''
            }],
            error: '',
            have_error: false,
            extra_returns_weight: '',
            layers: '',
            factory_error: '',
            factory_id: '',
            factoryTypes: [],
            spreading_orders: [],
            spreading_out_material_order_id: '',
            employee_error: '',
            layer_error: '',
            spreading_order_error: '',
            extra_return_error: '',
            items: [{
                product_type_id: '',
                size_id: '',
                qty: ''
            }],
            factory_type_url: '{{Route("factory.type_all")}}',
            employee_url: '{{route("employee.get_all")}}',
            employee_id: '',
            factory_type_id: ''
        },
        mounted() {
            this.getSpreadingOrders();
        },
        methods: {
            getOrderBy() {
                if (this.type == 'employee') {

                    this.getBy(this.employee_url);
                    this.getProductType();
                    this.getSizes();
                } else {
                    this.getBy(this.factory_type_url);
                }
            },
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
                axios.get(url).then(res => {
                    if (this.type == 'employee') {
                        this.users = res.data;
                    } else {
                        this.factoryTypes = res.data;

                    }
                }).catch(err => {

                });
            },
            addRow() {
                this.items.push({
                    product_type_id: '',
                    size_id: '',
                    qty: ''
                });
                this.errors.push({
                    product_type_id: '',
                    size_id: '',
                    qty: ''
                });
            },
            getFactory(id) {
                const metas = document.getElementsByTagName('meta');
                axios.defaults.headers = {
                    'Content-Type': 'application/json',
                    'Access-Control-Allow-Origin': '*',
                    'X-CSRF-TOKEN': metas['csrf-token'].getAttribute('content')
                };
                axios.get("{{url('/factory/get')}}" + '/' + id).then(res => {
                    this.factories = [];
                    this.factories = res.data;
                }).catch(err => {

                });
            },
            deleteRow(index) {
                if (this.items.length > 1) {
                    this.items.splice(index, 1);
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
            itemsValidation() {
                if (!this.employee_id) {
                    this.employee_error = "* You must Choose Employee";
                } else {
                    this.employee_error = '';
                }
                if (!this.layers) {
                    this.layer_error = "* You must Add Layers";
                } else {
                    this.layer_error = '';
                }
                for (i = 0; i < this.items.length; i++) {

                    if (!this.items[i].product_type_id) {
                        this.have_error = true;
                        this.errors[i].product_type_id = '* Select Product type'
                    } else {
                        this.errors[i].product_type_id = ''
                    }

                    if (!this.items[i].size_id) {
                        this.have_error = true;
                        this.errors[i].size_id = '* Select Size'
                    } else {
                        this.errors[i].size_id = ''
                    }

                    if (!this.items[i].qty) {
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
            factoryValidation() {
                if (!this.factory_id) {
                    this.factory_error = 'Must Choose Company';
                    this.have_error = true;
                }
            },
            createOrder() {
                let data = {};
                if (!this.spreading_out_material_order_id) {
                    this.have_error = true;
                    this.spreading_order_error = "You Must Choose Spreading Order"
                } else {
                    this.spreading_order_error = ""
                }
                if (this.type == 'employee') {
                    this.have_error = false;
                    this.itemsValidation();
                    data.items = this.items;
                    data.user_id = this.employee_id;
                    data.extra_returns_weight = this.extra_returns_weight;
                    data.layers = this.layers;
                    data.spreading_out_material_order_id = this.spreading_out_material_order_id;
                    if (!this.have_error) {
                        const metas = document.getElementsByTagName('meta');
                        axios.defaults.headers = {
                            'Content-Type': 'application/json',
                            'Access-Control-Allow-Origin': '*',
                            'X-CSRF-TOKEN': metas['csrf-token'].getAttribute('content')
                        };
                        axios.post("{{Route('cutting.material.store')}}", data).then(res => {

                            window.location.href = '{{Route("cutting.material.list")}}';
                        }).catch(err => {});
                    } else {
                        console.log(this.have_error)
                    }
                }
                if (this.type == 'company') {
                    this.factoryValidation();
                    data.factory_id = this.factory_id;
                    data.spreading_out_material_order_id = this.spreading_out_material_order_id;
                    if (!this.have_error) {

                        const metas = document.getElementsByTagName('meta');
                        axios.defaults.headers = {
                            'Content-Type': 'application/json',
                            'Access-Control-Allow-Origin': '*',
                            'X-CSRF-TOKEN': metas['csrf-token'].getAttribute('content')
                        };
                        axios.post("{{Route('cutting.material.store')}}", data).then(res => {

                            window.location.href = '{{Route("cutting.material.list")}}';
                        }).catch(err => {});
                    }
                }
            }
        }
    })
</script>