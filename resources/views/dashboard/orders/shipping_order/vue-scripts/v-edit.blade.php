<script src="https://cdn.jsdelivr.net/npm/vue"></script>
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<script src="https://unpkg.com/vue-multiselect@2.1.0"></script>
<link rel="stylesheet" href="https://unpkg.com/vue-multiselect@2.1.0/dist/vue-multiselect.min.css">

<script>
     Vue.createApp({
        components: {
            Multiselect: window.VueMultiselect.default
        },
        data() {
            return {
                value: [],
                options: [],
                data: [],
                shipping_companies: [],
                shipping_company_id: '',
                shipping_date: '',
                order: '',
                errors: {},
                have_error: false
            }
            
        },
        mounted() {
            this.getOrderToShip();
            this.getShippingCompanies();
            this.getShippingOrder();
        },
        methods: {
            getOrderToShip() {
                axios.get('{{Route("shipping.ready_orders")}}')
                    .then(res => {
                        this.options = res.data;
                    }).catch(err => {

                    });
            },
            getShippingCompanies() {
                axios.get('{{Route("shippingcompany.get_all")}}')
                    .then(res => {
                        this.shipping_companies = res.data;
                    }).catch(err => {

                    });
            },
            getShippingOrder() {
                axios.get('{{Route("shipping.get_order",$id)}}')
                    .then(res => {
                        this.order = res.data;
                        this.value = this.order.buy_orders;
                    }).catch(err => {

                    })
            },
            update() {
                this.validations()
                if (!this.have_error) {
                    var data = {};
                    data.shipping_date = this.order.shipping_date;
                    data.shipping_company_id = this.order.shipping_company_id;
                    data.orders = this.value;
                    data.shipping_id = this.order.id;

                    axios.post('{{Route("shipping.update_order")}}', data)
                        .then(res => {
                            window.location.href = "{{Route('shipping.get_list')}}"

                        }).catch(err => {

                        });
                }
            },
            validations() {
                this.have_error = false;
                this.errors = {
                    value: '',
                    factory: '',
                    shipping_date: ''
                }
                if (!this.value[0]) {
                    this.errors.value = 'You must choose order';
                    this.have_error = true;
                }

                if (!this.order.shipping_company_id) {
                    this.errors.company = 'You must choose company';
                    this.have_error = true;
                }

                if (!this.order.shipping_date) {
                    console.log(this.order.shipping_company_id)
                    this.errors.shipping_date = "You must add date of shipping"
                    this.have_error = true;
                }

            }
        }
    }).mount("#app")
</script>