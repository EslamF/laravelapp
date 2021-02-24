<script src="https://cdn.jsdelivr.net/npm/vue"></script>
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>

<script>
    var app = new Vue({
        el: '#app',
        data: {
            employees: [],
            user_id: '',
            errors: {},
            codes: [],
            products: [] ,
            product_code: '',
            have_error: false
        },
        mounted() {
            this.getEmployees()
        },
        methods: {
            getEmployees() {
                axios.get('{{Route("employee.get_all")}}')
                    .then(res => {
                        this.employees = res.data;
                    }).catch(err => {

                    });
            },
            checkIfSorted() {
                var data = {};
                data.product_code = this.product_code.trim();
                axios.post('{{Route("send_end_product.check_if_sorted")}}', data)
                    .then(res => {
                        this.have_error = false;
                        console.log(res.data);
                        if (res.data) {
                            if (!this.codes.includes(this.product_code.trim())) {
                                this.codes.push(this.product_code.trim());
                                this.products.push({
                                    product_code: res.data.prod_code ,
                                    material_code: res.data.material.mq_r_code , 
                                    size: res.data.size.name

                                });
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
                    axios.post("{{Route('send.end_product.store')}}", sendData)
                        .then(res => {
                            window.location.href = "{{Route('send.end_product.list')}}"
                        }).catch(err => {

                        });
                }
            },
            removeCode(i) {
                this.codes.splice(i, 1);
                this.products.splice(i, 1)
            },
            validateUser() {
                if (!this.user_id) {
                    this.errors.user = "* يجب إضافة موظف";
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