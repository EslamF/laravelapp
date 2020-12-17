<script src="https://cdn.jsdelivr.net/npm/vue"></script>
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>

<script>
    var app = new Vue({
        el: '#app',
        data: {
            errors: {} ,
            products: [],
            codes: [],
            prod_code: '',
            status: '',
            sort_order_id: '{{$sort_order_id}}' ,
            error: {
                
            },
            have_error: false,
            have_value: false
        },

        mounted() {
            
        },
      
        methods: {
            checkIfCanSorted() {

                this.errors.code = '';

                if (!this.status) {
                    this.errors.status = "*  يجب إدخال حالة الفرز أولاً";
                    this.have_error = true;
                    this.prod_code = '';
                }

                else 
                {
                    this.errors.status = "";
                    
                    var data = {};
                    data.prod_code = this.prod_code.trim();
                    axios.post('{{Route("product.sort.checkProduct")}}', data)
                        .then(res => {
                            this.have_error = false;
                            if (res.data == 'success') {
                                if (!this.codes.includes(this.prod_code.trim())) {
                                    this.codes.push(this.prod_code.trim());
                                    this.products.push({ code: this.prod_code.trim() });
                                    
                                } else {
                                    this.have_error = true;
                                    this.errors.code = '* لا يمكن إضافة هذا المنتج مره اخري'
                                }
                            } else {
                                this.have_error = true;
                                this.errors.code = '* لا يمكن إضافة هذا المنتج'
                            }

                            this.prod_code = '';
                        })
                        .catch(err => {

                        })
                }

                
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
                    sendData.products = this.codes;
                    sendData.damage_type = this.status;
                    sendData.sort_id = this.sort_order_id;
                    console.log(sendData);
                    axios.post("{{Route('sort.product')}}", sendData)
                        .then(res => {
                            window.location.href = "{{Route('sort.order.list')}}"
                        }).catch(err => {

                        });
                }
            },
            removeProduct(i) {
                this.codes.splice(i, 1)
                this.products.splice(i, 1)
            },
            validateAll() {

                this.have_error = false;

                if (!this.status) {
                    this.errors.status = "* يجب إدخال حالة الفرز";
                    this.have_error = true;
                }

                if (!this.products[0]) {
                    this.errors.code = '* يجب إضافة منتجات'
                    this.have_error = true;
                    this.have_value = false;
                }

                
            }
        }
    })
</script>