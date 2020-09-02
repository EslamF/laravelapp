<script src="https://cdn.jsdelivr.net/npm/vue"></script>
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<script>
    var app = new Vue({
        el: '#app',
        data: {
            data: [],
            grand_total: '',
            data: {
                order: {
                    confirmation: ''
                }
            },
            errors: [],
            have_error: false

        },
        mounted() {
            this.getOrder();
        },
        methods: {
            getOrder() {
                axios.get('{{url("orders/buy/show")}}' + '/' + '{{$id}}')
                    .then(res => {
                        this.data = res.data;
                        this.getGrandTotal();
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
                this.validatePrice();
                var data = {};
                data.data = this.data;
                if (!this.have_error) {
                    axios.post('{{Route("buy.update_order")}}', data)
                        .then(res => {
                            window.location.href = "{{Route('buy.list_page')}}"
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

    })
</script>