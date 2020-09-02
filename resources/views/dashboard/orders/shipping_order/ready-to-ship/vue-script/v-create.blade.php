<!-- <script src="https://unpkg.com/vue"></script> -->
<script src="https://unpkg.com/vue-input-tag"></script>
<script src="https://cdn.jsdelivr.net/npm/vue"></script>
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>

<script>
    var app = new Vue({
        el: '#app',
        components: {
            InputTag: window.vueInputTag.default
        },
        data: {
            tags: [],
            order: {},
            shipping_order_id: '',
            order: {
                id: ''
            },
            buy_orders: [],
            errors: {},
            have_err: ''
        },
        mounted() {
            this.getOrders()
        },
        methods: {
            getOrders() {
                axios.get('{{Route("shipping.order_to_package", $id)}}')
                    .then(res => {
                        this.order = res.data
                        this.getBuyOrders();
                    }).catch(err => {

                    });
            },
            getBuyOrders() {
                var url = '{{url("orders/buy/by-shipping")}}' + '/' + this.order.id;
                axios.get(url)
                    .then(res => {
                        this.buy_orders = [];
                        this.buy_orders = res.data;
                    }).catch(err => {

                    });
            },
            packageOrders() {
                if (this.arraysEqual(this.tags, this.buy_orders)) {
                    var data = {}
                    data.id = this.order.id;
                    data.status = 1;
                    data.orders = this.buy_orders;
                    axios.post('{{Route("shipping.package_orders")}}', data)
                        .then(res => {
                            window.location.href = "{{Route('shipping.list_packaged_orders')}}";
                        })
                        .catch(err => {

                        });
                } else {
                    console.log(this.errors);
                }
            },
            arraysEqual(_arr1, _arr2) {
                this.errors.order = "";
                this.errors.tags = "";
                this.have_err = false;

                if (!_arr1[0] || !_arr2[0]) {
                    this.errors.order = " يجب اختيار اوردر";
                    this.have_err = true;
                    return false;
                }
                if (!Array.isArray(_arr1) || !Array.isArray(_arr2) || _arr1.length !== _arr2.length) {
                    this.errors.tags = " يوجد اوردر مفقود";
                    this.have_err = true;
                    return false;
                }

                var arr1 = _arr1.concat().sort();
                var arr2 = _arr2.concat().sort();

                for (var i = 0; i < arr1.length; i++) {

                    if (arr1[i] !== arr2[i]) {
                        this.errors.tags = " اوردر خاظئ";
                        this.have_err = true;
                        return false;

                    }


                }

                return true;

            }
        }
    })
</script>