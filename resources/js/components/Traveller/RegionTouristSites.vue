<template>

    <div class="container-fluid">
        <!--<ul class="nav nav-tabs">
            <li class="nav-item">
                <router-link :to="'/user/my-trips'" class="nav-link">
                    My Trips
                </router-link>
            </li>

            <li class="nav-item">
                <router-link :to="{name:'user.sites'}" class="nav-link">
                    ALL Tourist Sites
                </router-link>

            </li>

            <li class="nav-item">
                <router-link :to="{name:'user.regions'}" class="nav-link">
                    Tourist Sites By Region
                </router-link>

            </li>
        </ul>-->

        <traveller-nav></traveller-nav>


        <div id="BrowseTouristSitesByRegion" v-if="showingTouristSitesByRegion">

            <hr>
            <div class="row">

                <div v-if="regionalTouristSites.length === 0 && activeRegion">
                    <div class="alert  alert-dark alert-dismissible my-3">
                        <h3 class="alert-heading">There is no Tourist Site for {{activeRegion.name}} at the moment.</h3>
                    </div>
                </div>

                <div class="col-sm-12 col-md-6 col-lg-6"
                     v-for="touristSites in regionalTouristSites"
                     :key="touristSites.id">

                    <!--<div class="card mb-3 btn" @click="changeActiveTouristSite(touristSites.addressable)">
                        <img :src="touristSites.addressable.thumbnail" class="card-img-top"
                             :alt="touristSites.addressable.name + 'thumbnail'">
                        <div class="card-body">
                            <h6 class="card-title">{{touristSites.addressable.name}}</h6>
                        </div>
                    </div>-->

                    <site-mini :site="touristSites.addressable" @site-clicked="viewSiteFull(touristSites.addressable)"></site-mini>



                </div>
            </div>
        </div>
    </div>

</template>

<script>
    export default {
        name: "RegionTouristSites",
        props:{
            pActiveRegion:Object,
        },
        data() {
            return {

                showingTouristSitesByRegion: false,




                loading: false,



                appError: false,
                errorParam: undefined,
                errorMessage: "",
                appStateCode: 0,


                activeRegion:undefined,
                activeTouristSite: undefined,


                regionalTouristSites: [],


            }
        },
        methods: {
            appState(StateId) {
                let vm = this;

                this.showingTouristSitesByRegion = false;

                switch (StateId) {

                    // Showing Tourist Sites By Region
                    case 5:
                        vm.showingTouristSitesByRegion = true;
                        break;


                    default:
                        break;

                }
            },

            loadTouristSitesByRegion(region) {
                // AppCode 490

                this.activeRegion = region;
                let vm = this;
                this.startLoading();
                axios.post('/data/trip',
                    {
                        mode: "load-by-region",
                        offset: vm.tourSiteByRegionOffset,
                        region_id: region.id,
                    })
                    .then(response => {
                        // vm.regionalTouristSites  = Object.assign({},vm.regionalTouristSites, response.data);
                        vm.regionalTouristSites = response.data;
                        vm.appState(5);
                    })
                    .catch(error => {
                        if (error.response.status === 419) {
                            let message = "Please you have been logged out because you were inactive."
                            vm.registerError(419, null, message)

                        } else {
                            let message = "The was problem loading tourist Sites for " + region.name;
                            vm.registerError(490, region, message)

                        }

                    });
                this.stopLoading();
            },

            loadRegion(regionId) {
                // AppCode 490


                let vm = this;
                this.startLoading();
                axios.post('/data/trip',
                    {
                        mode: "load-region",
                        region_id: regionId,
                    })
                    .then(response => {
                        // vm.regionalTouristSites  = Object.assign({},vm.regionalTouristSites, response.data);
                        this.activeRegion = response.data;
                        this.makeAction(490, this.activeRegion);

                        // vm.appState(5);
                    })
                    .catch(error => {

                        // console.log(error.response.status);

                        if (error.response.status === 419) {
                            let message = "Please you have been logged out because you were inactive."
                            vm.registerError(419, null, message)

                        } else {
                            let message = "The was problem loading Region data.";
                            vm.registerError(388, regionId, message)

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

                    case 490:
                        vm.loadTouristSitesByRegion(param);
                        break;

                    case 388:
                        vm.loadRegion(param);
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

            viewSiteFull(site){
                this.$router.push({
                    name:'site.show',
                    params:{
                        siteName:site.url_name,
                        siteId:site.id,
                        pTouristSite:site
                    },
                });
            },


        },
        mounted() {

            let vm = this;

            // console.log(this.$route.params.regionId)

            let region;

            if (this.pActiveRegion){
                this.activeRegion = this.pActiveRegion;
                this.makeAction(490, this.activeRegion);
                // console.log(this.$route.params.regionId);
            }else {
                // console.log(this.$route.params.regionId);
                this.makeAction(388, this.$route.params.regionId);

            }





            /*if(this.pActiveRegion){
               region = this.pActiveRegion;
                // this.activeRegion = this.pActiveRegion;
            }else {

                let regionName = this.$route.params.regionName;
                let regionId = vm.$route.$attrs.regionId;
                // let regionId = 1;
                region = {id:regionId, name:regionName};

                // this.makeAction(388, regionId);

            }


            this.makeAction(490, region);*/


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

            // toast.fire({
            //     title: 'Are you sure?',
            //     icon: 'warning',
            // });
        },
        watch:{
            appError:function (val) {
                let vm = this;
                if (val){
                    Swal.fire({
                        title: 'Error Occurred',
                        text: vm.errorMessage,
                        icon: 'error',
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
