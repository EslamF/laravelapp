<script src="https://cdn.jsdelivr.net/npm/vue"></script>
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<script>
    Vue.createApp({
        data() {
            return {
                data: [],
                grand_total: '',
                order_status: '',
                status_message: '',
                data: {
                    order: {
                        status: ''
                    }
                },
                errors: [],
                have_error: false
            }
        },
        mounted() {
            this.getOrder();
            //this.getOrderStatus();
        },
        methods: {
            getOrder() {
                axios.get('{{url("orders/buy/show")}}' + '/' + '{{$id}}')
                    .then(res => {
                        this.data = res.data;
                        this.order_status = res.data.order.status;
                        document.getElementById('loader').style.display = 'block'
                        this.getGrandTotal();
                    }).catch(err => {

                    })
            },
            getOrderStatus() {
                axios.get('{{Route("buy.order_status",$id)}}')
                    .then(res => {
                        this.orders = res.data;
                        this.status_message = this.orders.status_message
                        this.order_status = this.orders.status
                    }).catch(err => {

                    })
            },
            getGrandTotal() {
                var total = 0;
                for (i = 0; i < this.data.products.length; i++) {
                    total += this.data.products[i].price * (this.data.products[i].company_qty + this.data.products[i].factory_qty);
                }
                this.grand_total = total;
            },
            removeItem(index, id) {
                let data = {};
                data.id = id;
                axios.post('{{Route("buy.remove_item")}}', data)
                    .then(res => {
                        this.data.products.splice(index, 1);
                        this.getGrandTotal();
                    }).catch(err => {

                    })
            },
            updateData() {
                //this.validatePrice();
                var data = {};
                data.order_id = this.data.order.id;
                //console.log(this.data.order);
                //data.data = this.data;
                data.order_status = this.order_status;
                //data.status_message = this.status_message;
                if (!this.have_error) {
                    axios.post('{{Route("process.update_the_status_of_done_order")}}', data)
                        .then(res => {
                            window.location.href = "{{Route('process.done_orders_page')}}"
                        }).catch(err => {

                        });
                }
            },
            validatePrice() {
                this.have_error = false;
                this.errors = [];
                for (i = 0; i < this.data.products.length; i++) {
                    var error = {};

                    if (!this.data.products[i].price || this.data.products[i].price <= 0) {
                        error.price_err = '* this field is required';
                        this.have_error = true;
                    }
                    this.errors.push(error)
                }
            }
        }

    }).mount("#app")
</script>