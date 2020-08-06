<template>
    <div class="container-fluid">
        <div class="container-fluid">
            <div class="input-group mb-3">
                <input type="text" v-model="searchTxt" class="form-control" placeholder="Search Booking by Booking Code" aria-label="Search Booking by Booking Code" aria-describedby="button-addon2">
                <div class="input-group-append">
                    <button class="btn btn-outline-secondary"
                            type="button"
                            id="button-addon2" @click="makeAction(600)">
                        <i class="fas fa-search"></i>
                        Search
                    </button>
                </div>

                <div class="container-fluid m-4 border border-primary shadow p-1" v-if="showSearchedBooking">
                    <div class="row">
                        <div class="col-sm-12 col-md-6">
                            <div class="p-2">
                                <hotel-mini :hotel="activeBook.hotel"></hotel-mini>
                            </div>
                        </div>

                        <div class="col-sm-12 col-md-6">
                            <room-mini :room="activeBook.room"></room-mini>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <table class="table">
            <caption>List of your bookings</caption>
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Booking Code</th>
                <th scope="col">Start Date</th>
                <th scope="col">End Date</th>
                <th scope="col">Created At</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="(book,index) in bookings" :key="book.id">
                <th scope="row">{{index+1}}</th>
                <td><a href="#" @click="searchTxt=book.booking_code">{{book.booking_code}}</a></td>
                <td>{{book.start_date| niceDate}}</td>
                <td>{{book.end_date| niceDate}}</td>
                <td>{{book.created_at | timeFromNow}}</td>
            </tr>

            </tbody>
        </table>
    </div>
</template>

<script>
    import moment from 'moment';
    export default {
        name: "Bookings",
        props:{
            pRoom:Object,
        },
        data() {
            return {
                appError: false,
                errorParam: undefined,
                errorMessage: "",
                appStateCode: 0,
                loading: false,

                controllerUrl: "/data/hotel/master",

                bookings:[],
                searchTxt:"",
                activeBook:{
                    code:'',
                    startDate:'',
                    endDate:'',
                    room:{
                        roomId:2,
                        roomNumber:"",
                    },
                    hotel:{}
                },
                showSearchedBooking:false,
            }
        },
        methods:{
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

                    case 790:

                        vm.loadBookings(param);
                        break;
                    case 600:
                        vm.findBooking(param);
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

            loadBookings(param = null){
                // alert("here");

                let vm = this;
                let data = {
                        mode: "load-booking",
                        errorMessage:"The was problem loading your booking data.",
                        errorCode:"790",
                        url:vm.controllerUrl
                }

                if (param){
                    data = param;
                }

                this.loadSomething(data).then((response)=>{
                   vm.bookings = response;
                });
            //    Action Code 790
            //     this.makeAction(790,data);
            },

            findBooking: function (param = null) {
                // Action Code 600
                let vm = this;
                if (this.searchTxt || param){
                    vm.showSearchedBooking = false;

                    let data = {
                        mode: "find-booking-by-code",
                        errorMessage:"The was problem searching.",
                        errorCode:600,
                        url:vm.controllerUrl,
                        code:vm.searchTxt

                    }
                    if (param){
                        data = param;
                    }

                    // alert("here");
                    this.loadSomething(data).then((response)=>{
                        vm.activeBook = response;
                        vm.showSearchedBooking = true;
                    });
                }
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
        mounted() {
            this.makeAction(790);
        },
        filters:{
            niceDate: function (val) {
                return moment(val).format("dddd, Do MMMM, YYYY");
                // moment(val).format('dd-mm-yy');
            },
            timeFromNow: function (val) {
                return moment(val).fromNow();
                // moment(val).format('dd-mm-yy');
            }
        }
    }
</script>

<style scoped>

</style>
