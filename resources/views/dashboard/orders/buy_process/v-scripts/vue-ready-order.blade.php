<script src="https://cdn.jsdelivr.net/npm/vue"></script>
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<script>
    var app = new Vue({
        el: '#app',
        data: {
            orders: []
        },
        mounted() {
            this.getOrder();
        },
        methods: {
            getOrder() {
                axios.get('{{url("orders/process/ready-order")}}' + '/' + "{{$id}}")
                    .then(res => {
                        this.orders = res.data;
                    }).catch(err => {

                    });
            }
        }
    })
</script>