<script src="https://cdn.jsdelivr.net/npm/vue"></script>
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>

<script>
    var app = new Vue({
        el: '#app',
        data: {
            errors: {} ,
            ids: [],
            products: [],
            codes: [],
            prod_code: '',
            receiving_order_id: '{{$receiving_order_id}}' ,
            number_of_products: '{{$number_of_products}}',
            error: {
                
            },
            have_error: false,
            have_value: false
        },

        mounted() {
            
        },
      
        methods: {
            checkIfCanReceived() {

                this.errors.code = '';
                this.errors.number_of_products = '';
                
                var data = {};
                data.prod_code = this.prod_code.trim();
                data.receiving_order_id = this.receiving_order_id;

                axios.post('{{Route("receiving_product.check_product_before_received")}}', data)
                    .then(res => {
                        this.have_error = false;
                        if (res.data != 'error') {
                            if (!this.codes.includes(this.prod_code.trim())) 
                            {
                                this.codes.push(this.prod_code.trim());
                                this.products.push(res.data);
                                this.ids.push(res.data.id);
                                
                            } else 
                            {
                                this.have_error = true;
                                this.errors.code = '* لا يمكن إضافة هذا المنتج مره اخري'
                            }
                        } else 
                        {
                            this.have_error = true;
                            this.errors.code = '* لا يمكن إضافة هذا المنتج'
                        }

                        this.prod_code = '';
                    })
                    .catch(err => {

                    })
            },
            send() {
                this.have_error = false;
                this.errors = {};
                this.validateAll();
                if (this.codes.length > 0 && !this.have_error) {
                    //disable the submit button
                    $("#btnSubmit").attr("disabled", true);
                    document.getElementById('loader').style.display = 'block';
                    var sendData = {};
                    sendData.receiving_order_id = this.receiving_order_id;
                    sendData.ids = this.ids;
                    console.log(sendData);
                    axios.post("{{Route('receiving_product.receive_products_after_printing')}}", sendData)
                        .then(res => {
                            console.log(res.data);
                            window.location.href = "{{Route('receiving.product.list')}}"
                        }).catch(err => {

                        });
                }
            },
            removeProduct(i) {
                this.codes.splice(i, 1);
                this.products.splice(i, 1);
                this.ids.splice(i, 1);
            },
            validateAll() {

                this.have_error = false;
                this.have_value = true;

                if (!this.products[0]) 
                {
                    this.errors.code = '* يجب إضافة منتجات'
                    this.have_error = true;
                    this.have_value = false;
                }

                if (this.ids.length != this.number_of_products ) 
                {
                    this.errors.number_of_products = 'يجب إضافة ' + this.number_of_products + ' منتجات';
                    this.have_error = true;
                }
            }
        }
    })
</script>