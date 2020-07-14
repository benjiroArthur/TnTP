<template>
    <div>
        <div v-if="showingRoomImages">
            <viewer  ref="viewer" :trigger="activeRoom.images"  :options="viewerOptions">
                <slick   :options="slickOptions"  ref="slick">
                    <img v-for="image in activeRoom.images"
                         :src="image.thumbnail" :data-src="image.source"
                         :key="image.id" class="p-3">
                </slick>
            </viewer>
        </div>

    </div>

</template>

<script>
    export default {
        name: "RoomShowFull",
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

                showingRoomImages:false,

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

            loadRoom(roomId){

                let vm = this;

                let data = {
                    mode: "load-room",
                    errorMessage: "The was problem loading Room Info.",
                    errorCode: "455",
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

            }
        },

    }
</script>

<style scoped>

</style>
