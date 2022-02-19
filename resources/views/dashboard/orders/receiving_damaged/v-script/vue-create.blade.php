<script src="https://cdn.jsdelivr.net/npm/vue"></script>
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>

<script>
    Vue.createApp({
        data() {
            return {
                errors: {} ,
                codes: [],
                products: [],
                prod_code: '',
                damage_type: '',
                error: {
                    damage_type: '',
                },
                have_error: false
            }
          
        },

        mounted() {
            
        },
      
        methods: {

            checkIfExists() {
                var data = {};
                data.prod_code = this.prod_code.trim();
                axios.post('{{Route("receiving.damaged_product.checkIfExists")}}', data)
                    .then(res => {
                        this.have_error = false;
                        if (res.data) {
                            if (!this.codes.includes(this.prod_code.trim())) {
                                this.codes.push(this.prod_code.trim());
                                // push to products array (product_code , factory)
                                this.products.push({
                                    product_code: this.prod_code.trim() ,
                                    factory: res.data,
                                });
                                
                            } else {
                                this.have_error = true;
                                this.errors.exists = '* لا يمكن إضافة هذا المنتج مره اخري'
                            }
                        } else {
                            this.have_error = true;
                            this.errors.exists = '* (قد يكون صالح أو لم يخرج على أنه تالف) لا يمكن إضافة هذا المنتج';
                            this.errors.exists = 'لا يمكن إضافة هذا المنتج (قد يكون صالح أو لم يخرج على أنه تالف )';
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
                    $("#btnSubmit").attr("disabled", true);
                    document.getElementById('loader').style.display = 'block';
                    var sendData = {};
                    sendData.products = this.codes;
                    sendData.damage_type = this.damage_type;
                    console.log(sendData);
                    axios.post("{{Route('receiving.damaged_product.store')}}", sendData)
                        .then(res => {
                            window.location.href = "{{Route('product.list')}}"
                        }).catch(err => {

                        });
                }
            },
            removeCode(i) {
                this.codes.splice(i, 1);
                this.products.splice(i, 1)
            },
            validateAll() {
                if (!this.codes[0]) {
                    this.errors.exists = '* يجب إضافة منتجات'
                    this.have_error = true;
                }

                /*if (!this.damage_type) {
                    this.error.damage_type = "* يجب إدخال الحالة";
                    this.have_error = true;
                }*/

              
            }
        }
    }).mount("#app")
</script>