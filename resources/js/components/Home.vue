<template>
    <div class="container-fluid ">
        <p class="text-danger" v-if="check === 0">Please Update Your profile</p>

        <div class="row ">
            <div class="p-1 col-sm-12 col-md-4 ">
                <div class="info-box mb-3 bg-primary">
                    <span class="info-box-icon"><i class="fas fa-tag"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">Total Hotels</span>
                        <span class="info-box-number">{{stats.hotels}}</span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
            </div>

            <div class="p-1 col-sm-12 col-md-4 ">
                <div class="info-box mb-3 bg-danger">
                    <span class="info-box-icon"><i class="far fa-heart"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">Total Tourist Sites</span>
                        <span class="info-box-number">{{stats.tsites}}</span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
            </div>

            <div class="p-1 col-sm-12 col-md-4 ">
                <div class="info-box mb-3 bg-success">
                    <span class="info-box-icon"><i class="fas fa-cloud-download-alt"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">Total Rooms</span>
                        <span class="info-box-number">{{stats.rooms}}</span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
            </div>

        </div>
        <div class="row my-4 justify-content-center">
            <div class="col-md-12">

                <h2>Nearby Sites and landmarks</h2>
                <div v-if="nearBy.length > 0">
                    <GmapMap
                        :center="{lat:nearBy[0].map.lat, lng:nearBy[0].map.long}"
                        :zoom="6"
                        map-type-id="terrain"
                        style="width: 100%; height: 450px"
                    >
                        <GmapMarker
                            :key="index"
                            v-for="(site, index) in nearBy"
                            :position="{lat:site.map.lat, lng: site.map.long}"
                            :clickable="true"
                            :draggable="true"
                            @click="center={lat:site.map.lat,long:site.map.long}"
                        />
                    </GmapMap>

                    <p v-if="nearBy.length < 1">No Sites Found In Your Region</p>


                </div>
            </div>
        </div>
        <hr>
        <br>
        <div class="my-4">
            <h2>Tourist Sites</h2>
<!--            This is show a random tourist Sites-->
            <slick v-if="showingSitesSlick" :options="slickOptions">
                <site-mini :class="slickClasses" v-for="site in sites"  :key="site.id" :site="site" @site-clicked="viewSiteFull(site)"></site-mini>
            </slick>
            <button class="btn btn-block btn-primary">Show All</button>
        </div>
        <hr>
        <br>

        <div class="my-4">
            <h2>Hotels</h2>
<!--            This is show a random Hotels-->
            <slick v-if="showingHotelSlick" :options="slickOptions">
                <hotel-mini :class="slickClasses" v-for="hotel in hotels"  :key="hotel.id" :hotel="hotel" @hotel-clicked="viewHotelFull(hotel)"></hotel-mini>
            </slick>

        </div>

    </div>
</template>

<script>
    export default {
        name: "Home",
        data() {
            return {
                appError: false,
                errorParam: undefined,
                errorMessage: "",
                appStateCode: 0,
                loading: false,



                showingHotelSlick: false,
                showingSitesSlick: false,

                stats: {
                    hotels: 100,
                    tsites: 69,
                    rooms: 456,

                },

                slickClasses:"p-4 ",
                slickOptions2:{
                    dots: true,
                    infinite: true,
                    speed: 300,
                    slidesToShow: 4,
                    centerMode: false,
                    variableWidth: false
                },
                slickOptions: {
                    variableWidth: true,
                    adaptiveHeight: true,
                    fullscreen:false,
                    keyboard:true,
                    dots: true,
                    title:false,
                    autoplay:true,
                    infinite: true,

                    slidesToShow: 4,
                    // slidesToScroll: 3,
                    responsive: [
                        {
                            breakpoint: 1024,
                            settings: {
                                slidesToShow: 4,
                                slidesToScroll: 2,
                                infinite: true,
                                dots: true,
                                centerMode: false,

                            }
                        },
                        {
                            breakpoint: 600,
                            settings: {
                                slidesToShow: 4,
                                slidesToScroll: 1,
                                centerMode: false,

                            }
                        },
                        {
                            breakpoint: 480,
                            settings: {
                                slidesToShow: 2,
                                slidesToScroll: 1,
                                centerMode: true,
                            }
                        }
                    ]
                    // dots: true,
                    // infinite: true,
                    // slidesToShow: 3,
                    // slidesToScroll: 3
                    // Any other options that can be got from plugin documentation
                },

                controllerUrl: "/data/home/info",
                check: '',
                sites: [],
                region: '',
                nearBy: {},
                hotels:[],
            }
        },
        methods: {

            appState(StateId) {
                let vm = this;

                this.showingRoomImages = false;
                // this.showingNearSites = false;


                switch (StateId) {


                    // Showing the room Images
                    // case 1:
                    //     setInterval(()=>{
                    //         vm.showingRoomImages = true;
                    //     },500);

                    // break;
                    // Showing Tourist Sites in that Region
                    // case 2:
                    //     vm.showingRegionTouristSites = true;
                    //     break;
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
                // alert("Making Action "+ code);
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

                    case 452:
                        vm.loadStats(param);
                        break;
                    case 566:
                        // Load Random Hotels
                        vm.loadRandomHotels(param);
                        break;
                    // case 665:
                    //     vm.checkBookingAvailability(param);
                    //     break;

                }
            },
            registerError(code, param, message) {
                this.appStateCode = code;
                this.errorParam = param;
                this.errorMessage = message;
                this.appError = true;
            },
            tryAgain() {
                this.appError = false;
                let vm = this;
                vm.makeAction(vm.appStateCode, vm.errorParam);
                // setTimeout(()=>{
                //     vm.makeAction(vm.appStateCode, vm.errorParam);
                // },500);

            },
            reloadPage() {
                location.assign(location.href);
            },
            alertSuccess(message = "Successfully") {
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: true,
                    timer: 10000,
                    timerProgressBar: true,
                    onOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer);
                        toast.addEventListener('mouseleave', Swal.resumeTimer);
                    },
                    icon: 'success',
                    title: message
                });
            },
            loadSomething(param) {
                let vm = this;
                return new Promise(function (resolve, reject) {

                    /*alert("am loading something.");
                    let data = {
                        mode: "add-to-near-site",
                        errorMessage:"",
                        errorCode:999,
                         url:"",

                    }*/
                    let problem = true;
                    vm.startLoading();
                    axios.post(param.url, param)
                        .then(response => {
                            problem = false;
                            vm.stopLoading();
                            resolve(response.data);
                            // this.alertSuccess();
                        })
                        .catch(error => {
                            if (error.response.status === 419) {
                                let message = "Please you have been logged out because you were inactive."
                                vm.registerError(419, null, message)

                            } else {
                                vm.registerError(param.errorCode, param, param.errorMessage)
                            }
                            reject(error);
                        });
                });
            },


            checkUpdate() {
                this.loading = true;
                axios
                    .get('/checkUpdate')
                    .then(response => {
                        this.loading = false;
                        this.check = response.data;
                        // console.log(response.data)

                    }).catch(error => {
                    this.loading = false;
                    this.error = error.response.data.message || error.message;
                });
            },
            getSite() {
                this.loading = true;
                axios
                    .get('/data/get-sites')
                    .then(response => {
                        this.loading = false;
                        let records = response.data;
                        this.sites = records.sites;
                        this.region = records.region;
                        this.nearBy = records.nearby;

                        this.showingSitesSlick = true;

                    }).catch(error => {
                    this.loading = false;
                    this.error = error.response.data.message || error.message;
                });
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
            viewHotelFull(hotel){
                this.$router.push({
                    name:'hotel.show',
                    params:{
                        hotelName:hotel.url_name,
                        hotelId:hotel.id,
                        pHotel:hotel
                    },
                });
            },

            loadStats(param = null) {
                let vm = this;
                let data = {
                    mode: "load-stats",
                    errorMessage: "An unknown Error Occurred.",
                    errorCode: 452,
                    url: vm.controllerUrl,
                }
                if (param) {
                    data = param;
                }
                this.loadSomething(data).then((response) => {
                    vm.stats = response;
                });
            },

            loadRandomHotels(param = null) {
                let vm = this;
                let data = {
                    mode: "load-random-hotels",
                    errorMessage: "An unknown Error Occurred when loading some Hotels.",
                    errorCode: 566,
                    url: vm.controllerUrl,
                }
                if (param) {
                    data = param;
                }
                this.loadSomething(data).then((response) => {
                    vm.hotels = response;
                    vm.showingHotelSlick = true;
                });
            },


        },
        mounted() {
            // this.controllerUrl = "data/home/info";
            this.checkUpdate();
            this.getSite();
            this.makeAction(452);
            this.makeAction(566);
        },

    }
</script>
