<script src="https://cdn.jsdelivr.net/npm/vue"></script>
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<script>
    Vue.createApp({
        data() {
            return {
                orders: [],
                order_code: '',
                delivery_date: '',
            }
        },
        mounted() {
            this.getOrder();
        },
        methods: {
            getOrder() {
                axios.get('{{url("orders/process/ready-order")}}' + '/' + "{{$id}}")
                    .then(res => {
                        this.orders = res.data;

                        this.order_code = this.orders[0].order_code;
                        this.delivery_date = this.orders[0].delivery_date;
                        // document.getElementsByClassName('card')[0].style.display = 'block';
                    }).catch(err => {

                    });
            }
        }
    }).mount("#app")
</script>