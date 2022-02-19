<script src="https://cdn.jsdelivr.net/npm/vue"></script>
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<script>
    Vue.createApp({
        data() {
            return {
                orders: []
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
                        // document.getElementsByClassName('card')[0].style.display = 'block';
                    }).catch(err => {

                    });
            }
        }
    }).mount("#app")
</script>