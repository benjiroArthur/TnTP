<template>
    <div >
        <div class="container-fluid">
            <h3>{{activeHotel.name}} | <strong>{{activeHotel.email}}</strong></h3>

            <div class="row">
               <div class="col-sm-12 col-md-6">
                   <!-- About Hotel -->
                   <div class="card card-primary">
                       <div class="card-header">
                           <h3 class="card-title">About {{activeHotel.full_name}}</h3>
                       </div>
                       <!-- /.card-header -->
                       <div class="card-body">
                           <!--                    <strong><i class="fas fa-book mr-1"></i> Education</strong>-->

                           <!--                    <p class="text-muted">-->
                           <!--                        B.S. in Computer Science from the University of Tennessee at Knoxville-->
                           <!--                    </p>-->

                           <!--                    <hr>-->

                           <strong><i class="fas fa-map-marker-alt mr-1"></i> Location</strong>

                           <p class="text-muted">{{activeHotel.map ? activeHotel.map.region : "Unknown"}}</p>

                           <hr>

                           <!--                    <strong><i class="fas fa-pencil-alt mr-1"></i> Skills</strong>-->

                           <!--                    <p class="text-muted">-->
                           <!--                        <span class="tag tag-danger">UI Design</span>-->
                           <!--                        <span class="tag tag-success">Coding</span>-->
                           <!--                        <span class="tag tag-info">Javascript</span>-->
                           <!--                        <span class="tag tag-warning">PHP</span>-->
                           <!--                        <span class="tag tag-primary">Node.js</span>-->
                           <!--                    </p>-->

                           <!--                    <hr>-->

                           <strong><i class="far fa-file-alt mr-1"></i>Telephone</strong>

                           <p class="text-muted">{{activeHotel.phone_number ? activeHotel.phone_number : "Unknown" }}</p>

                           <hr>

                           <strong><i class="far fa-file-alt mr-1"></i>Registration Date</strong>

                           <p class="text-muted">{{activeHotel.registered ? activeHotel.registered : "Unknown" }}</p>

                           <hr>

                           <strong><i class="fas fa-mail-bulk mr-1"></i>Email</strong>

                           <p class="text-muted">{{activeHotel.email ? activeHotel.email : "Unknown" }}</p>
                       </div>
                       <!-- /.card-body -->
                   </div>
                   <!-- /.card -->
               </div>

                <div class="col-sm-12 col-md-6">
                    <!-- Profile Image -->
                    <div class="card card-primary card-outline">
                        <div class="card-body box-profile">
                           <ul class="list-group list-group-unbordered mb-3">
                                <li class="list-group-item">
                                    <b>Total Rooms</b> <a class="float-right">{{activeHotel.rooms_count}}</a>
                                </li>
                                <li class="list-group-item">
                                    <b>Total Bookings</b> <a class="float-right">{{activeHotel.bookings_count}}</a>
                                </li>
                                <li class="list-group-item">
                                    <b>Hotel Code</b> <a class="float-right">{{activeHotel.code}}</a>
                                </li>
                            </ul>

<!--                            <a href="#" class="btn btn-primary btn-block"><b>Follow</b></a>-->
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
            </div>




<!--            <h5>{{activeTouristSite.price|currency}}</h5>-->
        </div>
        <div v-if="showingHotelImages">
            <viewer  ref="viewer" :trigger="activeHotel.images"  :options="viewerOptions">
                <slick   :options="slickOptions"  ref="slick">
                    <img v-for="image in activeHotel.images"
                         :src="image.thumbnail" :data-src="image.source"
                         :key="image.id" class="p-3">
                </slick>
            </viewer>
        </div>

        <hr>


        <my-map v-if="activeHotel.map" :map="activeHotel.map"></my-map>
        <h3 v-else>No map information for this Hotel. </h3>

        <hr>

        <div v-if="showingHotelIRooms">
            <div class="card" >
                <div class="card-header" >
                    <h5>Rooms In this Hotel</h5>
                </div>

                <div  class="card-body">
                    <h3 v-if="hotelRooms.length<1">This Hotel have no room to book.</h3>
                    <div class="row" v-for="room in hotelRooms">
                        <div class="col-sm-12 col-md-4 col-lg-3">
                            <room-mini :room="room" @room-clicked="showRoom(room)"></room-mini>
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
                showingHotelIRooms:false,


                activeHotel:{},
                hotelRooms:{},
            }
        },
        methods:{
            appState(StateId) {
                let vm = this;

                this.show = false;
                vm.showingHotelImages = false;
                vm.showingHotelIRooms = false;


                switch (StateId) {

                    // Showing the Hotel Images
                    case 1:
                        setTimeout(()=>{
                            vm.showingHotelImages = true;
                            vm.showingHotelIRooms = true;
                        },500);

                        break;
                    // Showing Hotel Rooms
                    case 2:
                        // vm.showingHotelIRooms = true;
                        // vm.showingHotelImages = true;
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
                // this.$router.push({
                //     name:'hotel.show',
                //     params:{
                //         hotelName:hotel.url_name,
                //         hotelId:hotel.id,
                //         pHotel:hotel
                //     },
                // });


                this.$router.push({
                    name:'user.room.show',
                    params:{
                        roomName:room.url_name,
                        roomId:room.id,
                        pRoom:room
                    },
                });
            },

        },
        created() {
            let vm = this;
            if (vm.pHotel){
                vm.activeHotel = vm.pHotel;
                vm.hotelRooms = vm.pHotel.rooms;
                vm.makeAction(344, vm.pHotel.id);
                vm.appState(1);
            }else{
                let hotelId = vm.$route.params.hotelId;
                vm.makeAction(233, hotelId);
                vm.makeAction(344, hotelId);
                vm.appState(1);
                // vm.appState(2);
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
