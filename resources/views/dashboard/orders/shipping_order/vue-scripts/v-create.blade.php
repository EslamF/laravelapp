<script src="https://cdn.jsdelivr.net/npm/vue"></script>
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<script src="https://unpkg.com/vue-multiselect@2.1.0"></script>
<link rel="stylesheet" href="https://unpkg.com/vue-multiselect@2.1.0/dist/vue-multiselect.min.css">

<script>
    var app = new Vue({
        el: '#app',
        components: {
            Multiselect: window.VueMultiselect.default
        },
        data: {
            value: [],
            options: [],
            data: [],
            shipping_companies: [],
            shipping_company_id: '',
            shipping_date: '',
            errors: {},
            have_error: false,
            have_value: false
        },
        mounted() { 
            this.getOrderToShip();
            this.getShippingCompanies();
        },
        methods: {
            getOrderToShip() {
                axios.get('{{Route("shipping.ready_orders")}}')
                    .then(res => {
                        this.options = res.data;
                        var el = document.getElementsByClassName('loader')[0];
                        el.style.display = 'flex';
                    }).catch(err => {

                    });
            },
            getOrders() 
            {
                axios.get('{{url("shipping/getOrders")}}' + '/' + this.shipping_company_id).then(res => {
                    console.log('res.data');
                    console.log(res.data);
                    this.value = res.data;
                }).catch(err => {

                });

             
            },

            dateWithAddress({
                delivery_date,
                address
            }) {
                return `${delivery_date} — ${address}`
            },
            getShippingCompanies() {
                axios.get('{{Route("shippingcompany.get_all")}}')
                    .then(res => {
                        this.shipping_companies = res.data;
                    }).catch(err => {

                    });
            },
            saveOrder() {
                this.validations();
                console.log(this.have_error);
                if (!this.have_error) {
                    var data = {}
                    data.shipping_date = this.shipping_date;
                    data.shipping_company_id = this.shipping_company_id;
                    data.orders = this.value;

                    axios.post('{{Route("shipping.save_to_order")}}', data)
                    .then(res => {
                        window.location.href = "{{Route('shipping.get_list')}}"
                    })
                    .catch(err => {

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

                if (!this.shipping_company_id) {
                    this.errors.company = 'You must choose company';
                    this.have_error = true;
                }

                if (!this.shipping_date) {
                    this.errors.shipping_date = "You must add date of shipping"
                    this.have_error = true;
                }

            }
        }
    })
</script>