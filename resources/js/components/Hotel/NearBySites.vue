<template>
    <div class="container-fluid">
        <div class="card animate__animated animate__slideInLeft" v-if="showingNearSites">
            <div class="card-header bg-primary animate__slow animate__slideInLeft animate__animated">
                List Of Nearby Tourist Sites
            </div>

            <div class="card-body">
                <div class="row">
                    <template v-for="touristSites in NearBySitesList">
                        <div class="col-sm-12 col-md-4 col-lg-3" >

                            <site-mini :site="touristSites.tsite" @site-clicked="viewSiteFull(touristSites.tsite)"></site-mini>
                            <button class="btn  btn-danger" @click="removeFromNearSite(touristSites.tsite.id)">Remove</button>
                        </div>
                    </template>
                </div>

            </div>

            <div class="card-footer">
                <button @click="appState(2)"><i class="fa fa-edit"></i>Edit List</button>
            </div>
        </div>

        <div class="card animate__animated animate__slideInRight" v-if="showingRegionTouristSites">
            <div class="card-header bg-indigo animate__animated animate__slideInRight animate__slow">
                <h5>Select tourist sites near your hotel. <button @click="appState(1)" class="float-right"><i class="fa fa-angle-left"></i>Back</button></h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-12 col-md-4 col-lg-3" :key="site.addressable.id" v-for="site in RegionTouristSites">

                        <site-mini :site="site.addressable" @site-clicked="viewSiteFull(site.addressable)"></site-mini>
                        <button :disabled="isSelected" class="btn btn-primary mt-0" @click="addToNearSite(site.addressable.id)">Select</button>
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
    import Multiselect from 'vue-multiselect'
    import RegionTouristSites from "../Traveller/RegionTouristSites";

    export default {
        components: {Multiselect},
        data() {
            return {
                appError: false,
                errorParam: undefined,
                errorMessage: "",
                appStateCode: 0,
                loading: false,


                showingRegionTouristSites:false,
                showingNearSites:false,


                RegionTouristSites: [],
                NearBySitesList: [],


            };
        },
        methods: {
            appState(StateId) {
                let vm = this;

                this.showingRegionTouristSites = false;
                this.showingNearSites = false;


                switch (StateId) {


                    // Showing the site selected
                    case 1:
                        vm.showingNearSites = true;
                        break;
                    // Showing Tourist Sites in that Region
                    case 2:
                        vm.showingRegionTouristSites = true;
                        break;
                    default:
                        break;

                }
            },
            startLoading() {
                this.loading = true;
            },
            stopLoading(sec = 1000) {
                setTimeout(() => {
                    this.loading = false;
                    if (this.loading) {
                        this.loading = false;
                    }
                }, sec);
            },
            makeAction(code, param = null) {
                /*
                * code 419 => Reload Page
                * Code 100 => Load Nearby Tourist Sites
                *
                * */
                let vm = this;
                switch (code) {

                    case 419:
                        //  the page should reload
                        this.errorCode = 0;
                        this.reloadPage();
                        this.errorParam = undefined;
                        break;
                    case 100:
                        vm.loadNearbySites();
                        break;

                    case 200:
                        vm.loadRegionSites();
                        break;
                    case 678:
                        vm.loadSomething(param);
                        break;

                    case 890:
                        vm.loadSomething(param);
                        break;


                }
            },
            registerError(code, param, message) {
                this.appStateCode = code;
                this.errorParam = param;
                this.errorMessage = message;
                this.appError = true;
            },
            tryAgain() {
                this.makeAction(this.appStateCode, this.errorParam);
                this.appError = false;
            },
            reloadPage() {
                if (this.errorCode === 419) {
                    location.assign(location.href);
                }
            },
            alertSuccess(message="Successfully"){
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: true,
                    timer: 5000,
                    timerProgressBar: true,
                    onOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer);
                        toast.addEventListener('mouseleave', Swal.resumeTimer);},
                    icon: 'success',
                    title: message
                });
            },



            loadSomething(param) {
                // let data = {
                //     mode: "add-to-near-site",
                //     site_id:id,
                //     errorMessage:"",
                //     errorCode:"",
                //
                // }

                let vm = this;
                this.startLoading();
                axios.post('/data/hotel/master',param
                    )
                    .then(response => {
                        vm.NearBySitesList =  response.data;
                        this.alertSuccess();


                    })
                    .catch(error => {
                        if (error.response.status === 419) {
                            let message = "Please you have been logged out because you were inactive."
                            vm.registerError(419, null, message)

                        } else {

                            vm.registerError(param.errorCode, param, param.errorMessage)

                        }

                    });
                this.stopLoading();

            },

            viewSiteFull(site) {
                this.$router.push({
                    name: 'site.show',
                    params: {
                        siteName: site.url_name,
                        siteId: site.id,
                        pTouristSite: site
                    },
                });
            },
            loadNearbySites() {
                // AppCode 488
                let vm = this;
                this.startLoading();
                axios.post('/data/hotel/master',
                    {
                        mode: "load-nearby-sites",

                    })
                    .then(response => {
                        vm.NearBySitesList = response.data;
                        // this.alertSuccess();
                    })
                    .catch(error => {
                        if (error.response.status === 419) {
                            let message = "Please you have been logged out because you were inactive."
                            vm.registerError(419, null, message);

                        } else {
                            let message = "The was problem loading Your Near by tourist sites."
                            vm.registerError(100, null, message)

                        }

                    });
                this.stopLoading();

            },

            loadRegionSites() {
                // AppCode 488
                let vm = this;
                this.startLoading();
                axios.post('/data/hotel/master',
                    {
                        mode: "load-region-sites",
                    })
                    .then(response => {
                        vm.RegionTouristSites = response.data;
                    })
                    .catch(error => {
                        if (error.response.status === 419) {
                            let message = "Please you have been logged out because you were inactive."
                            vm.registerError(419, null, message)

                        } else {
                            let message = "There was problem loading tourist sites."
                            vm.registerError(200, null, message)

                        }

                    });
                this.stopLoading();

            },

            addToNearSite(id){

                let data = {
                    mode: "add-to-near-site",
                    site_id:id,
                    errorMessage:"There was problem adding tourist site to the list of site near your hotel.",
                    errorCode:678,

                }

                this.NearBySitesList = this.loadSomething(data);

            },
            removeFromNearSite(id){
                let data = {
                    mode: "remove-from-near-site",
                    site_id:id,
                    errorMessage:"There was problem removing tourist site from the list of site near your hotel.",
                    errorCode:890,

                }

                this.NearBySitesList = this.loadSomething(data);
            },




        },
        computed:{
            isSelected:function(site){
                for (let i = 0; i < this.RegionTouristSites.length; i++) {
                    return site.tourist_site_id === this.RegionTouristSites[i].addressable_id;
                }
            }
        },
        created() {
            this.loadNearbySites();
            this.loadRegionSites();
            this.appState(1);
        },
        watch:{
            appError:function (val) {
                let vm = this;
                if (val){
                    Swal.fire({
                        title: 'Error Occurred',
                        text: vm.errorMessage,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Try Again'
                    }).then((result) => {
                        if (result.value) {
                            vm.tryAgain();
                        }
                    });
                }

            },
            loading:function (val) {
                if (val){
                    this.$Progress.start();
                }else {
                    this.$Progress.finish();
                }
            }
        }
    }
</script>

<style scoped>

</style>
