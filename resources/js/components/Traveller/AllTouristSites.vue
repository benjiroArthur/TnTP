<template>
    <div class="container-fluid">
        <ul class="nav nav-tabs row">
            <li class="nav-item col-sm-4 col-md-4 col-lg-4">
                <router-link :to="'/user/my-trips'" class="nav-link">
                    My Trips
                </router-link>
            </li>

            <li class="nav-item col-sm-4 col-md-4 col-lg-4">
                <router-link :to="{name:'user.sites'}" class="nav-link">
                    ALL Tourist Sites
                </router-link>

            </li>

            <li class="nav-item col-sm-4 col-md-4 col-lg-4">
                <router-link :to="{name:'user.regions'}" class="nav-link">
                    Tourist Sites By Region
                </router-link>

            </li>
        </ul>

        <div id="BrowseTouristSites" v-if="showingTouristSites">

            <div class="row">
                <template v-for="touristSites in masterTouristSites">


                    <div v-for="site in touristSites" class="col-sm-12 col-md-4 col-lg-3" :key="site.id">
                        <site-mini :site="site" @site-clicked="viewSiteFull(site)"></site-mini>

                        <!--<div class="card mb-3 btn" @click="changeActiveTouristSite(site)">
                            <img :src="site.thumbnail" class="card-img-top" :alt="site.name + 'thumbnail'">
                            <div class="card-body">
                                <h5 class="card-title">{{site.name}}</h5>
                            </div>
                        </div>-->
                    </div>
                </template>
            </div>

            <button class="btn btn-primary my-5" @click="makeAction(488)">Load More Sites</button>

        </div>

    </div>


</template>

<script>
    export default {
        name: "AllTouristSites",
        data() {
            return {


                showingTouristSites: false,



                loading: false,

                tourSiteOffset: 0,




                appError: false,
                errorParam: undefined,
                errorMessage: "",
                appStateCode: 0,




                masterTouristSites: [],



            }
        },
        methods: {
            appState(StateId) {
                let vm = this;

                this.showingTouristSites = false;


                switch (StateId) {


                    // Showing available tourist sites
                    case 3:
                        vm.showingTouristSites = true;
                        break;


                    default:
                        break;

                }
            },
            loadTouristSites() {
                // AppCode 488
                let vm = this;
                this.startLoading();
                axios.post('/data/trip',
                    {
                        mode: "load-tourist-sites",
                        offset: vm.tourSiteOffset,
                    })
                    .then(response => {
                        vm.masterTouristSites.push(response.data);
                        vm.tourSiteOffset += 5;
                        vm.appState(3);

                    })
                    .catch(error => {
                        if (error.response.status === 419) {
                            let message = "Please you have been logged out because you were inactive."
                            vm.registerError(419, null, message)

                        } else {
                            let message = "The was problem loading Your trips."
                            vm.registerError(488, null, message)

                        }

                    });
                this.stopLoading();
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
                * Code 488 => LoadTouristSites
                * Code 489 => LoadRegions
                * Code 490 => loadTouristSitesByRegion
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
                    case 488:
                        vm.loadTouristSites();
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

            viewSiteFull(site) {
                this.$router.push({
                    name:'site.show',
                    params:{
                        siteName:site.url_name,
                        siteId:site.id,
                        pTouristSite:site
                    },
                });
            }
        },
        created() {
            this.makeAction(488);



            /*Swal.fire({
                toast: true,
                position: 'top-end',
                showConfirmButton: true,
                timer: 5000,
                timerProgressBar: true,
                onOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer);
                    toast.addEventListener('mouseleave', Swal.resumeTimer);},
                icon: 'success',
                title: 'Tourist Site Added Successfully'
            });*/

            /*Swal.fire({
                title: 'Are you sure?',
                text: '<h2>Hello World!</h2>',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.value){
                    alert("Nice you pressed Yes, delete it!");
                }else {
                    alert("You pressed Cancel");
                }
            });*/

            /*toast.fire({
                title: 'Are you sure?',
                icon: 'warning',
            });*/
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
