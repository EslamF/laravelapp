<script src="https://cdn.jsdelivr.net/npm/vue"></script>
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<script>
    var app = new Vue({
        el: '#app',
        data: {
            type: '',
            clicked: false
        },
        mounted() {
            this.loader();
        },
        methods: {
            submitForm() {
                this.clicked = true;
                this.$refs.form.submit();
            },
            loader() {
                document.getElementById('loader').style.display = 'block';
            }
        }

    })
</script>