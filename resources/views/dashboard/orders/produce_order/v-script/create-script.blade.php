<script src="https://cdn.jsdelivr.net/npm/vue"></script>
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<script>
    var app = new Vue({
        el: '#app',
        data: {
            cutting_orders: [],
            factories: [],
            factory_id: '',
            cutting_order_id: '',
            receiving_date: '',
            error: {
                factory_id: '',
                cutting_order_id: '',
                receiving_date: ''
            },
            have_error: false
        },
        mounted() {
            this.getCuttingOrders();
            this.getAllFactory();
        },
        methods: {
            getCuttingOrders() {
                const metas = document.getElementsByTagName('meta');
                axios.defaults.headers = {
                    'Content-Type': 'application/json',
                    'Access-Control-Allow-Origin': '*',
                    'X-CSRF-TOKEN': metas['csrf-token'].getAttribute('content')
                };
                axios.get('{{Route("cutting_order.all")}}').then(res => {
                    this.cutting_orders = res.data;
                }).catch(err => {

                });
            },
            getFactoryByCuttingId(id) {
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
            getAllFactory() {
                const metas = document.getElementsByTagName('meta');
                axios.defaults.headers = {
                    'Content-Type': 'application/json',
                    'Access-Control-Allow-Origin': '*',
                    'X-CSRF-TOKEN': metas['csrf-token'].getAttribute('content')
                };
                axios.get('{{Route("factory_get_all")}}').then(res => {
                    this.factories = res.data;
                }).catch(err => {

                });
            },
            store() {
                var data = {};
                data.factory_id = this.factory_id;
                data.cutting_order_id = this.cutting_order_id;
                data.receiving_date = this.receiving_date;
                this.validations();
                if (!this.have_error) {
                    const metas = document.getElementsByTagName('meta');
                    axios.defaults.headers = {
                        'Content-Type': 'application/json',
                        'Access-Control-Allow-Origin': '*',
                        'X-CSRF-TOKEN': metas['csrf-token'].getAttribute('content')
                    };
                    axios.post('{{Route("produce.order.store")}}', data).then(res => {
                        window.location.href = "{{Route('produce.order.list')}}"
                    }).catch(err => {

                    });
                }
            },
            validations() {
                this.have_error = false;
                this.error = {
                    factory_id: '',
                    cutting_order_id: '',
                    receiving_date: ''
                }
                if (!this.cutting_order_id) {
                    this.error.cutting_order_id = "* this field is required";
                    this.have_error = true;
                }

                if (!this.factory_id) {
                    this.error.factory_id = "* this field is required";
                    this.have_error = true;
                }

                if (!this.receiving_date) {
                    this.error.receiving_date = "* this field is required";
                    this.have_error = true;
                }
            }
        }

    })
</script>