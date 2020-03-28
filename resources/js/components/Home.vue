<template>
    <div class="container">
        <p class="text-danger" v-if="check === 0">Please Update Your profile</p>
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Example Component</div>

                    <div class="card-body">
                        This is Home Page
                        <div style="width:200px; border:2px solid red;">bbkjjkj</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "Home",
        data(){
            return{
                check:'',
            }
        },
        methods:{
            checkUpdate(){
                this.loading = true;
                axios
                    .get('/checkUpdate')
                    .then(response => {
                        this.loading = false;
                        this.check = response.data;
                        console.log(response.data)

                    }).catch(error => {
                    this.loading = false;
                    this.error = error.response.data.message || error.message;
                });
            },
        },
        created(){
            this.checkUpdate();
        },

    }
</script>
