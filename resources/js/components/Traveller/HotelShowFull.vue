<template>
    <div >
        <div v-if="showingHotelImages">

            <viewer  ref="viewer" :trigger="activeHotel.images"  :options="viewerOptions">
                <slick   :options="slickOptions"  ref="slick">
                    <img v-for="image in activeHotel.images"
                         :src="image.thumbnail" :data-src="image.source"
                         :key="image.id" class="p-3">
                </slick>
            </viewer>
            <div class="card">
                <div class="card-header">
                    <h5>Rooms In this Hotel</h5>
                </div>

                <div class="card-body">
                    <div class="row" v-for="room in hotelRooms">
                        <div class="col-sm-12 col-md-4 col-lg-3">
                            <room-mini :room="room" @hotel-clicked="showRoom(room)"></room-mini>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</template>
\
<script>
    export default {
        name: "HotelShowFull",
        props:{
            pHotel:Object,
        },
        data() {
            return {
                appError: false,
                errorParam: undefined,
                errorMessage: "",
                appStateCode: 0,
                loading: false,

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

                showingHotelImages:false,
                activeHotel:{},
                hotelRooms:{},
            }
        },
        methods:{
            appState(StateId) {
                let vm = this;

                this.show = false;
                this.showingHotelImages = false;


                switch (StateId) {


                    // Showing the Hotel Rooms
                    case 1:
                        vm.showingHotelImages = true;
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

                    case 233:
                        vm.loadHotel(param);
                        break;

                    case 344:
                        vm.loadHotelRooms(param);
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
                let vm = this;
                return new Promise(function (resolve, reject) {

                    /*alert("am loading something.");
                    let data = {
                        mode: "add-to-near-site",
                        errorMessage:"",
                        errorCode:"",
                         url:"",

                    }*/
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
                            reject(error);
                        });
                });
            },

            loadHotel(hotelId){

                let vm = this;

                let data = {
                    mode: "load-hotel",
                    errorMessage: "The was problem loading Hotel.",
                    errorCode: "233",
                    url: "/data/hotel/master",
                    hotel_id: hotelId,
                }
                this.loadSomething(data).then((response) => {
                    vm.activeHotel = response;

                })
            },
            loadHotelRooms(hotelId){
                let vm = this;

                let data = {
                    mode: "load-hotel-rooms",
                    errorMessage: "The was problem loading Hotel Rooms.",
                    errorCode: "344",
                    url: "/data/hotel/master",
                    hotel_id: hotelId,
                }
                this.loadSomething(data).then((response) => {
                    vm.hotelRooms = response;

                })
            },

            showRoom(room){
                this.$router.push({
                    name:'room.show',
                    params:{
                        roomName:room.url_name,
                        roomId:room.id,
                        pRoom:room
                    },
                });
            },

        },
        created() {
            if (this.pHotel){
                this.activeTouristSite = this.pHotel;
                this.hotelRooms = this.pHotel.rooms;
                this.makeAction(344, this.pHotel.id);
                this.appState(6);

            }else{
                let hotelId = this.$route.params.hotelId;
                this.makeAction(233, hotelId);
                this.makeAction(344, hotelId);

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
            }
        },

    }
</script>

<style scoped>

</style>
