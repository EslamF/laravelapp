<script src="https://cdn.jsdelivr.net/npm/vue"></script>
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<script>
    var app = new Vue({
        el: '#app',
        data: {
            produce_order_id: '',
            produce_orders: [],
            products: [],
            product: {
                product_type: {
                    name: ''
                },
                size: {
                    name: ''
                },
                qty: ''
            },
            received_products: [],
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
            changeStatus(status, id, index) {
                var data = {};
                data.id = id;
                data.status = status;
                const metas = document.getElementsByTagName('meta');
                axios.defaults.headers = {
                    'Content-Type': 'application/json',
                    'Access-Control-Allow-Origin': '*',
                    'X-CSRF-TOKEN': metas['csrf-token'].getAttribute('content')
                };
                axios.post('{{route("receiving_product.change_status")}}', data).then(res => {
                    if (status == 1) {
                        this.received_products.push(this.products[index]);
                        this.products.splice(index, 1);
                    } else {
                        this.products.push(this.received_products[index]);
                        this.received_products.splice(index, 1);
                    }
                }).catch(err => {

                });
            },
            goToProduceOrderList() {
                var data = {};
                data.produce_order_id = this.produce_order_id;
                const metas = document.getElementsByTagName('meta');
                axios.defaults.headers = {
                    'Content-Type': 'application/json',
                    'Access-Control-Allow-Origin': '*',
                    'X-CSRF-TOKEN': metas['csrf-token'].getAttribute('content')
                };
                axios.post('{{route("order_status")}}', data).then(res => {

                    window.location.href = "{{Route('receiving.product.list')}}";
                }).catch(err => {

                });
            }
        }

    })
</script>