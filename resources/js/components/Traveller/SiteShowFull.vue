<template>
    <div id="viewTouristSite" v-if="showingTouristSite && activeTouristSite">

        <div id="MD">


            <!-- Modal -->
            <div class="modal animate__animated animate__zoomIn" id="tripScheduleForm" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="staticBackdropLabel">Modal title</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <label for="name">Trip Name</label>
                            <input type="text" id="name" class="form-control" placeholder="Nice Trip Name" v-model="tripName">

                            <div class="row">
                                <div class="col">
                                    <label for="startDate">Start At</label>
                                    <input type="date" id="startDate" class="form-control" v-model="tripStartDate">
                                </div>
                                <div class="col">
                                    <label for="endDate">End</label>
                                    <input type="date" id="endDate" class="form-control" v-model="tripEndDate">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal" @click="hide">Cancel</button>
                            <button type="button" class="btn btn-primary" @click="createTrip">Create Trip</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <viewer  ref="viewer" :trigger="activeTouristSite.images"  :options="viewerOptions">
            <slick   :options="slickOptions"  ref="slick">
                <img v-for="image in activeTouristSite.images"
                     :src="image.thumbnail" :data-src="image.source"
                     :key="image.id" class="p-3">
            </slick>
        </viewer>

        <div class="container-fluid">
            <h4>{{activeTouristSite.name}} | {{activeTouristSite.address.region}}</h4>

            <p>{{activeTouristSite.description}}</p>

            <button class="btn btn-primary" @click="show">Schedule a Trip</button>

            <hr>

            <div class="card">
                <div class="card-header">
                    <h5>Hotels Around this Site</h5>
                </div>

                <div class="card-body">
                    <div class="" v-for="hotel in nearbyHotels">
                        <hotel-mini :hotel="hotel.hotel" @hotelClicked="alert('How is life')"></hotel-mini>
                    </div>
                </div>

            </div>
        </div>

    </div>
</template>

<script>
    export default {
        name: "SiteShowFull",
        props:{
            pTouristSite:Object,
        },
        data() {
            return {

                tripName:null,
                tripStartDate:null,
                tripEndDate:null,


                showingTouristSite: false,


                loading: false,


                appError: false,
                errorParam: undefined,
                errorMessage: "",
                appStateCode: 0,

                activeTouristSite: undefined,
                nearbyHotels:[],


                viewerOptions:{
                    url: 'data-src'
                },
                slickOptions: {
                    fullscreen:true,
                    keyboard:true,
                    centerPadding: '40px',
                    dots: true,
                    title:false,
                    autoplay:true,
                    infinite: false,

                    slidesToShow: 3,
                    // slidesToScroll: 3,
                    responsive: [
                        {
                            breakpoint: 1024,
                            settings: {
                                slidesToShow: 3,
                                slidesToScroll: 3,
                                infinite: true,
                                dots: true
                            }
                        },
                        {
                            breakpoint: 600,
                            settings: {
                                slidesToShow: 2,
                                slidesToScroll: 2
                            }
                        },
                        {
                            breakpoint: 480,
                            settings: {
                                slidesToShow: 1,
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

            }
        },
        methods: {
            appState(StateId) {
                let vm = this;

                this.showingTouristSite = false;

                switch (StateId) {


                    // Showing Tourist site information
                    case 6:
                        vm.showingTouristSite = true;

                        break;

                    default:
                        break;

                }
            },
            loadSomething(param) {
                let vm = this;
                return new Promise(function (resolve, reject) {

                    // alert("am loading something.");
                    // let data = {
                    //     mode: "add-to-near-site",
                    //     errorMessage:"",
                    //     errorCode:"",
                    //      url:"",
                    //
                    // }
                    let problem = true;
                    vm.startLoading();
                    axios.post(param.url,param)

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
                                vm.registerError(776, param, param.errorMessage)
                            }
                        });

                });
            },
            loadTouristSite(siteId) {

                let data = {
                    errorMessage:"",
                    errorCode:"",
                    url:"/data/trip",
                    mode: "load-tourist-site",
                    site_id: siteId

                }

                this.loadSomething(data).then((data)=>{
                    this.activeTouristSite = data;
                    this.appState(6);
                });

                // AppCode 677

/*
                let vm = this;
                this.startLoading();
                /!*axios.post('/data/trip',
                    {
                        mode: "load-tourist-site",
                        site_id: siteId,
                    })
                    .then(response => {

                        this.activeTouristSite = response.data;
                        this.appState(6);

                    })
                    .catch(error => {

                        // console.log(error.response.status);

                        if (error.response.status === 419) {
                            let message = "Please you have been logged out because you were inactive."
                            vm.registerError(419, null, message)

                        } else {
                            let message = "The was problem loading Tourist Site data.";
                            vm.registerError(677, siteId, message)

                        }

                    });*!/
                this.stopLoading();*/
            },
            loadNearbyHotel(sideId) {
                let vm = this;
                let data = {
                    mode: "load-nearby-hotels",
                    site_id: sideId,
                    errorMessage: "There was problem loading Nearby Hotels.",
                    url:"/data/hotel/master",
                }
                this.loadSomething(data).then((data)=>{
                    vm.nearbyHotels = data;
                });

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
                * Code 677 => LoadTouristSite
                *
                *
                * */
                let vm = this;
                switch (code) {

                    case 419:
                        //  the page should reload
                        this.errorCode = 0;
                        helpers.reloadPage();
                        this.errorParam = undefined;
                        break;

                    case 677:
                        // alert('here ooo');
                        vm.loadTouristSite(param);
                        // vm.loadNearbyHotel();
                        break;

                    case 776:
                        // alert('here ooo');
                        vm.loadNearbyHotel(param);
                        // vm.loadNearbyHotel();
                        break;

                    case 123:
                        // alert('here ooo');
                        vm.createTrip();
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
            show () {
                $('#tripScheduleForm').modal('show');
            },
            hide () {
                $('#tripScheduleForm').modal('hide');
            },

            createTrip(){
                let vm = this;
                if (this.tripStartDate && this.tripEndDate && this.tripStartDate && this.activeTouristSite){
                    this.startLoading();
                    axios.post('/data/trip',
                        {
                            mode: "create-trip",
                            start_date: this.tripStartDate,
                            end_date: this.tripEndDate,
                            trip_name:this.tripName,
                            site_id:this.activeTouristSite.id
                        })
                        .then(response => {
                            this.hide();
                            this.clearForm();
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
                                title: 'Trip Scheduled Successfully.'
                            });


                        })
                        .catch(error => {

                            // console.log(error.response.status);

                            if (error.response.status === 419) {
                                let message = "Please you have been logged out because you were inactive."
                                vm.registerError(419, null, message)

                            } else {
                                let message = "The was problem scheduling your trip.";
                                vm.registerError(123, null, message)

                            }

                        });
                    this.stopLoading();
                }



            },
            clearForm() {
                this.tripStartDate =
                    this.tripEndDate =
                        this.tripName = null;
            }
        },
        created() {
            if (this.pTouristSite){
                this.activeTouristSite = this.pTouristSite;
                this.appState(6);

            }else{
                let touristSiteId = this.$route.params.siteId;
                this.makeAction(677, touristSiteId);
                this.makeAction(776, touristSiteId);

            }


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
            },

        },

    }
</script>

<style scoped>

</style>
