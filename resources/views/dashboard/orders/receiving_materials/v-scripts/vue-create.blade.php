<script src="https://cdn.jsdelivr.net/npm/vue"></script>
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<script>
    Vue.createApp({
        data() {
            return {
                type: '',
                clicked: false , 
                mq_r_code: '' ,
            }
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

            getMaterialData() {
                console.log('hello');
            }

        }

    }).mount("#app")
</script>