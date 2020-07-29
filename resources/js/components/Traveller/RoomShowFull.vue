<template>
    <div>
        <div>
            <div class="modal animate__animated animate__backInDown" tabindex="-1" role="dialog" id="BookRoomModal">
                <div class="modal-dialog">
                    <div class="modal-content ">
                        <div class="modal-header">
                            <h5 class="modal-title">Book This Room</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
<!--                            <label for="name">Trip Name</label>-->
<!--                            <input type="text" id="name" class="form-control" placeholder="Nice Trip Name" v-model="tripName">-->

                            <div class="row">
                                <div class="col">
<!--                                    <label for="startDate">Start Date</label>-->
                                    <date-picker
                                        @dp-change="makeIsAvailableFalse"
                                        id="startDate"
                                        :config="options"
                                        v-model="StartDate"
                                        name="dob"
                                        placeholder="Select Start Date"
                                        class="form-control"
                                    ></date-picker>

<!--                                    <input type="date" id="startDate" class="form-control" v-model="StartDate">-->
                                </div>
                                <div class="col">
<!--                                    <label for="endDate">End Date</label>-->

                                    <date-picker
                                        @dp-change="makeIsAvailableFalse"
                                        id="endDate"
                                        :config="options"
                                        v-model="EndDate"
                                        name="dob"
                                        class="form-control"
                                        placeholder="Select End Date"

                                    ></date-picker>


<!--                                    <input type="date" id="endDate" class="form-control" v-model="EndDate">-->
                                </div>

                            </div>

                            <div v-if="!checkingAvailability" class="m-4 alert" :class="checkingAvailabilityClass">
                                {{checkingAvailabilityMessage}}
                            </div>

                        </div>
                        <div class="modal-footer">
<!--                            v-if="canCheckAvailability"-->
                            <button @click="makeAction(665)" class="btn btn-success animate__animated  "  :class="canCheckAvailability ?'animate__slideInLeft':'animate__slideOutLeft' " >
                                <span v-if="checkingAvailability" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                <span v-if="checkingAvailability" class="sr-only">Loading...</span>
                                Check Availability
                            </button>

                            <button type="button" @click="prepareBooking" v-if="isAvailable" class="btn btn-primary animate__animated animate__heartBeat" data-dismiss="modal"> Confirm</button>
                            <button type="button"  class="btn btn-outline-info" v-if="StartDate||EndDate" @click="clearForm">Clear</button>
                            <button type="button"  class="btn btn-secondary"  data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">{{activeRoom.room_number}}</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Rooms</a></li>
                        <li class="breadcrumb-item active">{{activeRoom.room_number}}</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div>

        <div class="container-fluid" v-if="showingRoomImages">
            <viewer  ref="viewer" :trigger="activeRoom.images"  :options="viewerOptions">
                <slick   :options="slickOptions"  ref="slick">
                    <img v-for="image in activeRoom.images"
                         :src="image.thumbnail" :data-src="image.source"
                         :key="image.id" class="p-3">
                </slick>
            </viewer>
        </div>

        <div class="container-fluid">
            <h5 class="mb-3">Price: {{activeRoom.price|currency}}</h5>
            <button class="btn btn-lg btn-primary" data-toggle="modal" data-target="#BookRoomModal">Book this room</button>
        </div>
    </div>

</template>

<script>
    import DatePicker from "vue-bootstrap-datetimepicker/src/component";
    import moment from 'moment';
    export default {
        name: "RoomShowFull",
        components: {DatePicker},
        props:{
            pRoom:Object,
        },

        computed:{
            canCheckAvailability(){
                if(!this.isAvailable && this.StartDate && this.EndDate ){
                   let startDate = moment(this.StartDate,'YYYY-MM-DD');
                   let endDate = moment(this.EndDate,'YYYY-MM-DD');
                   let today = moment();

                   // Start date is less than today or End date is less than today
                   // and end date should not be less than start date
                   return !(startDate.isBefore(today) || endDate.isBefore(today) || endDate.isBefore(startDate));
                }else {
                    return false;
                }
            },
        },
        data() {
            return {
                appError: false,
                errorParam: undefined,
                errorMessage: "",
                appStateCode: 0,
                loading: false,

                controllerUrl: "/data/hotel/master",

                StartDate:null,
                EndDate:null,

                isAvailable:false,
                checkingAvailability:false,
                checkingAvailabilityMessage:"",
                checkingAvailabilityClass:'alert-white',

                showingRoomImages:false,

                options: {
                    format: 'YYYY-MM-DD',
                    useCurrent:false
                },
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


                activeRoom:{},
                roomImages:{},
            }
        },
        methods:{
            appState(StateId) {
                let vm = this;

                this.showingRoomImages = false;
                // this.showingNearSites = false;


                switch (StateId) {


                    // Showing the room Images
                    case 1:
                        setInterval(()=>{
                            vm.showingRoomImages = true;
                        },500);

                        break;
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

                    case 455:
                        vm.loadRoom(param);
                        break;
                    case 456:
                        vm.submitBooking(param);
                        break;
                    case 665:
                        vm.checkBookingAvailability(param);
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
            alertSuccess(message = "Successfully"){
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: true,
                    timer: 10000,
                    timerProgressBar: true,
                    onOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer);
                        toast.addEventListener('mouseleave', Swal.resumeTimer);},
                    icon: 'success',
                    title: message
                });
            },

            clearForm(){
              this.StartDate = this.EndDate = null;
              this.checkingAvailabilityMessage = "";
              this.checkingAvailabilityClass = "alert-white";
              this.makeIsAvailableFalse();

            },

            makeIsAvailableFalse(){
              this.isAvailable = false;
            },

            checkBookingAvailability: function (param = null) {

                if (this.checkingAvailability){
                    return;
                }

                let vm = this;
                let data = {
                    mode: "check-booked-room",
                    errorMessage: "There was problem checking.",
                    errorCode: 665,
                    url: vm.controllerUrl,
                    start_date: vm.StartDate,
                    end_date: vm.EndDate,
                    room_id: vm.activeRoom.id

                }
                // alert("am loading something.");
                if (param) {
                    data = param;
                }

                this.checkingAvailability = true;

                vm.loadSomething(data).then((response) => {
                    vm.checkingAvailability = false;
                    if (response.available) {
                        vm.checkingAvailabilityMessage ="The room is available.";
                        vm.checkingAvailabilityClass = "alert-success";
                        vm.isAvailable = true;
                    } else {
                        vm.checkingAvailabilityMessage ="Please select different date or select different room.";
                        vm.checkingAvailabilityClass = "alert-danger";

                    }
                });

                // vm.makeAction(665,data);
            },

            prepareBooking(){
            //    make action submit booking
                let vm = this;
                if (vm.EndDate && vm.StartDate){

                    // alert("am loading something.");
                    let data = {
                        mode: "book-room",
                        errorMessage:"There was problem booking room.",
                        errorCode:456,
                        url:vm.controllerUrl,
                        start_date:vm.StartDate,
                        end_date:vm.EndDate,
                        room_id:vm.activeRoom.id

                    }

                    vm.makeAction(456,data);
                }
            },
            submitBooking(param){
                // Action code = 456
                let vm = this;

                vm.loadSomething(param).then((response)=>{
                    vm.alertSuccess("Room Booked Successfully. Booking Code: "+response.booking_code)
                    vm.clearForm();
                    // console.log(response.booking_code);
                })

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
                                vm.registerError(param.errorCode, param, param.errorMessage)
                            }
                            reject(error);
                        });
                });
            },
            loadRoom(roomId){

                let vm = this;

                let data = {
                    mode: "load-room",
                    errorMessage: "The was problem loading Room Info.",
                    errorCode: 455,
                    url: "/data/hotel/master",
                    room_id: roomId,
                }
                this.loadSomething(data).then((response) => {
                    vm.activeRoom = response;
                });
            },

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
                        }else {
                            vm.appError = false;
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
        created() {
            if (this.pRoom){
                this.activeRoom = this.pRoom;
                this.appState(1);
            }else{
                let roomId = this.$route.params.roomId;
                this.makeAction(455, roomId);
                this.appState(1);

            }
        },

    }
</script>

<style scoped>

</style>
