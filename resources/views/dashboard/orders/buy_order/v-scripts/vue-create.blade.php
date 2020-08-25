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
            mq_r_code: '',
            products: [],
        },
        mounted() {

        },
        methods: {
            searchOnCustomer() {
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
                    this.products = res.data;
                }).catch(err => {

                });
            }

        }

    })
</script>