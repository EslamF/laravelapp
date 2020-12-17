<script src="https://cdn.jsdelivr.net/npm/vue"></script>
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<script>
    var app = new Vue({
        el: '#app',
        data: {
            items: [],
            products_qty: [],
            prod_code: '',
            products_code: [],
            item: {},
            add_error: '',
            invalid_error: '',
            save_error: '',
            count: 0,
            qty_sum: 0
        },
        mounted() {
            this.getOrderToPrepare();
        },
        methods: {
            getOrderToPrepare() {
                axios.get('{{url("orders/process/get-order")}}' + '/' + '{{$id}}')
                    .then(res => {
                        this.items = res.data;
                        document.getElementById('loader').style.display = 'block';
                        this.addProducts();
                    }).catch(err => {

                    })
            },
            check() {

            },
            addProducts() {
                for (i = 0; i < this.items.length; i++) {
                    this.products_qty.push({
                        qty: 0,
                    });
                    this.products_code.push([]);
                }
            },
            validateProduct() {
                var data = {};
                data.prod_code = this.prod_code;
                this.invalid_error = '';
                this.save_error = '';
                axios.post('{{Route("process.validate_product")}}', data)
                    .then(res => {
                        this.prod_code = '';
                        this.item = res.data;
                        this.addNewProduct();
                    }).catch(err => {
                        this.invalid_error = "Invalid Product";
                    })
            },
            addNewProduct() {
                this.add_error = '';
                var not_found = true;
                if (Object.keys(this.item).length != 0 && this.item.constructor === Object) {
                    for (i = 0; i < this.items.length; i++) {
                        if (this.item.produce_code == this.items[i].produce_code) {
                            not_found = false;
                            if (this.products_qty[i].qty != this.items[i].qty && this.products_qty[i].qty < this.items[i].qty) {
                                if (!this.products_code[i].includes(this.item.id)) {
                                    this.count++;
                                    this.products_qty[i].qty++;
                                    this.products_code[i].push(this.item.id);
                                } else {
                                    this.add_error = "product already exists";
                                }
                            } else {
                                this.add_error = 'You Can\'t add more of this item';
                            }
                        }
                    }

                    if(not_found)
                    {
                        this.invalid_error = "Invalid Product";
                    }
                };
            },
            saveOrder() {
                this.invalid_error = '';
                this.add_error = '';
                this.save_error = '';
                this.items_qty();
                console.log(this.qty_sum);
                if (this.count === this.qty_sum) {
                    var data = {}
                    data.products_code = this.products_code;
                    data.buy_order_id = this.items[0].buy_order_id;
                    axios.post("{{Route('process.save_order')}}", data)
                        .then(res => {
                            window.location.href = "{{Route('process.ready_orders_page')}}";
                        }).catch(err => {

                        });
                } else {
                    this.save_error = 'You must complete the order first';
                }
            },
            items_qty() {
                this.qty_sum = 0;
                for (i = 0; i < this.items.length; i++) {
                    this.qty_sum += this.items[i].qty;
                }
            }
        }
    })
</script>