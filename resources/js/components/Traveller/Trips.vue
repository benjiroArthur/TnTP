<template>

    <div class="container-fluid ">

        <div v-if="appError">
            <p>{{errorMessage}}</p>
            <button @click="tryAgain">Try Again</button>
        </div>


        <ul class="nav nav-tabs">
            <li class="nav-item">
                <router-link :to="'/user/my-trips'" class="nav-link">
                    My Trips
                </router-link>
<!--                <button class="nav-link" :class="showingMyTrips ? 'active':''">My Trips</button>-->
            </li>

            <li class="nav-item">
                <button @click="appState(3)" class="nav-link" :class="showingTouristSites ? 'active':''">ALL Tourist
                    Sites
                </button>
            </li>

            <li class="nav-item">
                <button @click="appState(4)"
                        class="nav-link"
                        :class="showingTouristSitesByRegion || showingRegions ? 'active':''"
                >Tourist Sites By Region
                </button>
            </li>

            <li class="nav-item">
                <button @click="appState(6)"
                        class="nav-link"
                        :class="showingTouristSite ? 'active':''">View Site
                </button>
            </li>

        </ul>


        <div v-if="loading" class="text-center p-5">
            <div class="spinner-border " style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>

        <div class="row" v-if="showingRegions" id="Regions">
            <div class="col-sm-12 col-md-6 col-lg-3 text-center" v-for="region in regions">

                <div class="btn  btn-primary animate__animated animate__zoomInDown"  @click="makeAction(490,region), showingRegions = false">
                    <img
                         src="/region_back.jpg" alt=""
                         class="img-fluid  ">
                    <div class="caption ">
                        <h5 class="p-3 text-white animate__animated animate__zoomInDown">{{region.name}}</h5>
                    </div>
                </div>




            </div>
        </div>


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

                    <div class="card mb-3 btn" @click="changeActiveTouristSite(touristSites.addressable)">
                        <img :src="touristSites.addressable.thumbnail" class="card-img-top"
                             :alt="touristSites.addressable.name + 'thumbnail'">
                        <div class="card-body">
                            <h6 class="card-title">{{touristSites.addressable.name}}</h6>
                        </div>
                    </div>


                    <!--                    <div class="card" @click="changeActiveTouristSite(touristSites.addressable)">-->
                    <!--                        <div class="card-body">-->
                    <!--                            <h4>{{touristSites.addressable.name}} {{touristSites.id}}</h4>-->
                    <!--                        </div>-->
                    <!--                    </div>-->
                </div>
            </div>
            <!--                <button class="btn btn-primary" @click="makeAction(490, activeRegion)">Load More Sites</button>-->
        </div>


        <div id="BrowseTouristSites" v-if="showingTouristSites">

            <div class="row">
                <template v-for="touristSites in masterTouristSites">
                    <div v-for="site in touristSites" class="col-sm-12 col-md-4 col-lg-3" :key="site.id">
                        <div class="card mb-3 btn" @click="changeActiveTouristSite(site)">
                            <img :src="site.thumbnail" class="card-img-top" :alt="site.name + 'thumbnail'">
                            <div class="card-body">
                                <h5 class="card-title">{{site.name}}</h5>
                            </div>
                        </div>
                    </div>
                </template>
            </div>

            <button class="btn btn-primary my-5" @click="makeAction(488)">Load More Sites</button>

        </div>


        <div id="MyTrips">

        </div>

        <div id="viewTouristSite" v-if="showingTouristSite && activeTouristSite">

            <div class="row">
                <div v-for="image in activeTouristSite.images" class="col">
                    <!--                    <img :src="" alt="">-->
                </div>

            </div>
            <div v-if="activeTouristSite">
                <h4>{{activeTouristSite.name}}</h4>
                <h4>{{activeTouristSite.address.region}}</h4>
            </div>
        </div>
    </div>

</template>

<script>
    export default {
        name: "trip",
        data() {
            return {
                creatingTrip: false,
                showingMyTrips: false,
                showingRegions: true,
                showingTouristSites: false,
                showingTouristSite: false,
                showingTouristSitesByRegion: false,


                regionHover: null,
                regionHoverAnimation: '',

                loading: false,

                tourSiteOffset: 0,
                tourSiteByRegionOffset: 0,

                activeRegion: undefined,

                appError: false,
                errorParam: undefined,
                errorMessage: "",
                appStateCode: 0,

                myTrips: {},
                regions: [],

                activeTouristSite: undefined,

                masterTouristSites: [],
                regionalTouristSites: [],
                tripObj: {
                    name: 'Trip Name',
                    site_id: 1,
                    user_id: 9,
                    start: null,
                    end: null
                }

            }
        },
        methods: {
            appState(StateId) {
                let vm = this;
                this.showingMyTrips = false;
                this.showingRegions = false;
                this.creatingTrip = false;
                this.showingTouristSites = false;
                this.showingTouristSite = false;
                this.showingTouristSitesByRegion = false;

                switch (StateId) {
                    //Creating Trip
                    case 1:
                        vm.creatingTrip = true;
                        break;

                    //  Showing my trips
                    case 2:
                        vm.showingMyTrips = true;
                        break;

                    // Showing available tourist sites
                    case 3:
                        vm.showingTouristSites = true;
                        break;

                    // Showing Regions
                    case 4:
                        vm.showingRegions = true;
                        vm.showingTouristSitesByRegion = true;
                        break;

                    // Showing Tourist Sites By Region
                    case 5:
                        vm.showingTouristSitesByRegion = true;
                        vm.showingRegions = false;
                        break;

                    // Showing Tourist site information
                    case 6:
                        vm.showingTouristSite = true;

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
            loadMyTrips() {

                this.appState(2);
            },
            loadRegions() {
                //load Regions AppCode 489
                let vm = this;
                this.startLoading();
                axios.post('/data/trip',
                    {
                        mode: "load-regions",
                    })
                    .then(response => {
                        vm.regions = response.data;
                        vm.appStateCode(4);
                        // alert("App Code 4");

                    })
                    .catch(error => {
                        if (error.response.status === 419) {
                            let message = "Please you have been logged out because you were inactive."
                            vm.registerError(419, null, message)

                        } else {
                            let message = "The was problem loading regions."
                            vm.registerError(489, null, message)
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
                    case 489:
                        // alert('here ooo');
                        vm.loadRegions();

                        break;
                    case 490:
                        vm.loadTouristSitesByRegion(param);
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

            changeActiveTouristSite(site) {
                this.activeTouristSite = site;
                this.appState(6);
            }
        },
        created() {
            this.makeAction(489);

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

            toast.fire({
                title: 'Are you sure?',
                icon: 'warning',
            });
        }


    }
</script>

<style>
    .thumbnail {
        position: relative;
    }

    .caption {
        position: absolute;
        top: 45%;
        left: 0;
        width: 100%;
    }
</style>

<!--

Create a trip
view his trips

Load Tourist Sites

DB Trip Table
tourist_site_id
user_id
start_date
end_date

-->
