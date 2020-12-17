<script src="https://cdn.jsdelivr.net/npm/vue"></script>
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>

<script>
    var app = new Vue({
        el: '#app',
        data: {
            employees: [],
            user_id: '{{ $order->user_id }}',
            bar_code: '{{ $order->code }} ',
            errors: {},
            codes:  []  ,
            product_code: '',
            have_error: false,
            order_id: "{{ $order->id }}",
            error: ''
          
        },
        mounted() {
            this.getEmployees() ,
            this.getProducts()
        },
        methods: {
            getEmployees() {
                axios.get('{{Route("employee.get_all")}}')
                    .then(res => {
                        this.employees = res.data;
                    }).catch(err => {

                    });
            },

            getProducts() {
                var data = {};
                data.save_order_id = this.order_id;

                axios.post('{{Route("send.end_product.getProducts")}}' , data)
                    .then(res => {
                        this.codes = res.data;
                    }).catch(err => {

                    });
            },
            checkIfSorted() {
                var data = {};
                data.product_code = this.product_code.trim();
                data.save_order_id = this.order_id;
                console.log('data : ' + data.product_code);
                axios.post('{{Route("send_end_product.check_if_sorted")}}', data)
                    .then(res => {
                        this.have_error = false;
                        console.log(res.data);
                        if (res.data) {
                            if (!this.codes.includes(this.product_code.trim())) {
                                this.codes.push(this.product_code.trim());
                                this.product_code = '';
                            } else {
                                this.have_error = true;
                                this.errors.exists = '* لا يمكن إضافة هذا المنتج مره اخري'
                            }
                        } else {
                            this.have_error = true;
                            this.errors.exists = '* لا يمكن إضافة هذا المنتج'
                        }
                    })
                    .catch(err => {

                    })
            },
            send() {
                this.have_error = false;
                this.validateUser();
                if (this.codes.length > 0 && !this.have_error) {
                    //disable the submit button
                    $("#btnSubmit").attr("disabled", true);
                    document.getElementById('loader').style.display = 'block';
                    var sendData = {};
                    sendData.products = this.codes;
                    sendData.user_id = this.user_id;
                    sendData.code = this.bar_code;
                    sendData.save_order_id = this.order_id;
                    axios.post("{{Route('send.end_product.update')}}", sendData)
                        .then(res => {
                            console.log(res.data.error);
                            if(  res.data.error   )
                            {
                                this.error = res.data['error'];
                            }

                            else 
                            {
                                this.error = '';
                                window.location.href = "{{Route('send.end_product.list')}}" ;
                            }
                            
                            
                        }).catch(err => {

                        });
                }
            },
            removeCode(i) {
                this.codes.splice(i, 1)
            },
            validateUser() {
                if (!this.user_id) {
                    this.errors.user = "* يجب إضافة موظف";
                    this.have_error = true;
                }

                if (!this.bar_code) {
                    this.errors.bar_code = "* يجب إضافة البار كود";
                    this.have_error = true;
                }

                if (!this.codes[0]) {
                    this.errors.exists = '* يجب إضافة منتجات'
                    this.have_error = true;
                }
            }
        }
    })
</script>