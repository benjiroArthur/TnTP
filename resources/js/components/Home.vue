<template>
    <div class="container-fluid">
        <p class="text-danger" v-if="check === 0">Please Update Your profile</p>
        <div class="row justify-content-center">
            <div class="col-md-12">
                <h5>Nearby Sites and landmarks</h5>
                <div>
                    <p v-for="site in nearBy">{{site.name}}</p>
                    <p v-if="nearBy.length < 1">No Sites Found In Your Region</p>
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
                sites:[],
                region:'',
                nearBy:{},
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
            getSite(){
                this.loading = true;
                axios
                    .get('/data/get-sites')
                    .then(response => {
                        this.loading = false;
                        let records = response.data;
                        this.sites = records.sites;
                        this.region = records.region;
                        this.nearBy = records.nearby;


                    }).catch(error => {
                    this.loading = false;
                    this.error = error.response.data.message || error.message;
                });
            },
        },
        created(){
            this.checkUpdate();
            this.getSite();
        },

    }
</script>
