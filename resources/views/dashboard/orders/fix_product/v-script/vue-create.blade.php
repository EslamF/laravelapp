<script src="https://cdn.jsdelivr.net/npm/vue"></script>
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>

<script>
    Vue.createApp({
        data() {
            return {
                errors: {} ,
                codes: [],
                prod_code: '',

                factories: [],
                factory_types: [],
                factory_id: '',
                factory_type_id: '',
                error: {
                    factory_id: '',
                },
                
                have_error: false
            }
           
        },

        mounted() {
            this.getFactoryTypes();
        },
      
        methods: {

            getFactoryTypes() {
                axios.get('{{Route("factory.type_all")}}')
                    .then(res => {
                        this.factory_types = res.data;
                    }).catch(err => {

                    })
            },

            getFactory() {
                const metas = document.getElementsByTagName('meta');
                axios.defaults.headers = {
                    'Content-Type': 'application/json',
                    'Access-Control-Allow-Origin': '*',
                    'X-CSRF-TOKEN': metas['csrf-token'].getAttribute('content')
                };
                axios.get('{{url("factory/get-by-id")}}' + '/' + this.factory_type_id).then(res => {
                    this.factories = res.data;
                }).catch(err => {

                });
            },

        
            checkIfSortedAndDamaged() {
                var data = {};
                data.prod_code = this.prod_code.trim();
                axios.post('{{Route("fix.product.checkIfSortedAndDamaged")}}', data)
                    .then(res => {
                        this.have_error = false;
                        if (res.data) {
                            if (!this.codes.includes(this.prod_code.trim())) {
                                this.codes.push(this.prod_code.trim());
                                
                            } else {
                                this.have_error = true;
                                this.errors.exists = '* لا يمكن إضافة هذا المنتج مره اخري'
                            }
                        } else {
                            this.have_error = true;
                            this.errors.exists = '* لا يمكن إضافة هذا المنتج'
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
                    sendData.products = this.codes;
                    sendData.factory_id = this.factory_id;
                    console.log(sendData);
                    axios.post("{{Route('fix.product.store')}}", sendData)
                        .then(res => {
                            window.location.href = "{{Route('fix.product.list')}}"
                        }).catch(err => {

                        });
                }
            },
            removeCode(i) {
                this.codes.splice(i, 1)
            },
            validateAll() {
                if (!this.codes[0]) {
                    this.errors.exists = '* يجب إضافة منتجات'
                    this.have_error = true;
                }

                if (!this.factory_id) {
                    this.error.factory_id = "* يجب إدخال المصنع";
                    this.have_error = true;
                }
            }
        }
    }).mount("#app")
</script>