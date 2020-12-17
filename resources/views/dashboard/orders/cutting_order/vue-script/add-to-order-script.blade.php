<script src="https://cdn.jsdelivr.net/npm/vue"></script>
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<script>
    var app = new Vue({
        el: '#app',
        data: {
            items: [{
                product_type_id: '',
                size_id: '',
                qty: ''
            }],
            errors: [{
                product_id: '',
                size_id: '',
                qty: ''
            }],
            productTypes: [],
            product_type_id: '',
            sizes: [],
            size_id: '',
            qty: '',
            have_error: false,
            layers: '',
            extra_returns_weight: ''
        },
        mounted() {
            this.getProductType();
            this.getSizes();
        },
        methods: {
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
                        document.getElementById('loader').style.display = 'block';
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
                console.log(this.items);
            },
            deleteRow(index) {
                if (this.items.length > 1) {
                    this.items.splice(index, 1);
                }
            },
            addToOrder() {
                var data = {}
                data.items = this.items;
                data.layers = this.layers;
                data.extra_returns_weight = this.extra_returns_weight;
                //data.cutting_order_id = '{{$order->id}}';
                this.have_error = false;
                this.itemsValidation();
                if (!this.have_error) {
                    const metas = document.getElementsByTagName('meta');
                    axios.defaults.headers = {
                        'Content-Type': 'application/json',
                        'Access-Control-Allow-Origin': '*',
                        'X-CSRF-TOKEN': metas['csrf-token'].getAttribute('content')
                    };
                    axios.post("{{Route('cutting_order.store_extra')}}", data).then(res => {
                        window.location.href = '/orders/cutting/get-order-products/' + '{{$order->id}}'
                    }).catch(err => {

                    });
                }
            },
            itemsValidation() {
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
                }
            },
        }
    })
</script>