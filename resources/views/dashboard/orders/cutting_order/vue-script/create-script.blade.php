<script src="https://cdn.jsdelivr.net/npm/vue"></script>
<script>
    var app = new Vue({
        el: '#app',
        data: {
            message: 'Hello Vue!',
            type: '',
            users: [],
            factories: [],
            items: [{
                'product_type_id': '',
                'size_id': '',
                'qty': ''
            }],
            factory_url: '',
            employee_url: '',
            employee: ''
        },
        methods: {
            getProductTypes() {
                axios.defaults.headers = {
                    'Content-Type': 'application/json',
                    'Access-Control-Allow-Origin': '*',
                    'X-CSRF-TOKEN': metas['csrf-token'].getAttribute('content')
                };
                axios.get().then(res => {

                }).catch(err => {

                });
            },
            getOrderBy() {
                if (this.type == 'employee') {
                    this.getBy(employee_url);
                } else {
                    this.getBy(factory_url);
                }
            },
            getBy(url) {
                axios.defaults.headers = {
                    'Content-Type': 'application/json',
                    'Access-Control-Allow-Origin': '*',
                    'X-CSRF-TOKEN': metas['csrf-token'].getAttribute('content')
                };
                axios.get(url).then(res => {

                }).catch(err => {

                });
            },
            addRow() {
                this.items.push({
                    'product_type_id': '',
                    'size_id': '',
                    'qty': ''
                });
            },
            deleteRow(index) {
                if (this.items.length > 1) {
                    this.items.splice(index, 1);
                }
            }
        }
    })
</script>