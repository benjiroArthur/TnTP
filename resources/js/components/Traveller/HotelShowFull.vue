<template>
    <div >

    </div>
</template>

<script>
    export default {
        name: "HotelShowFull",
        props:{
            pTouristSite:Object,
        },
        data() {
            return {
                appError: false,
                errorParam: undefined,
                errorMessage: "",
                appStateCode: 0,
                loading: false,



            }
        },
        methods:{
            appState(StateId) {
                let vm = this;

                this.showingRegionTouristSites = false;
                this.showingNearSites = false;


                switch (StateId) {


                    // Showing the site selected
                    case 1:
                        vm.showingNearSites = true;
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
                    case 100:
                        vm.loadNearbySites();
                        break;

                    case 200:
                        vm.loadRegionSites();
                        break;
                    case 678:
                        vm.loadSomething(param);
                        break;

                    case 890:
                        vm.loadSomething(param);
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
                // let data = {
                //     mode: "add-to-near-site",
                //     site_id:id,
                //     errorMessage:"",
                //     errorCode:"",
                //
                // }

                let vm = this;
                this.startLoading();
                axios.post('/data/hotel/master',param)

                    .then(response => {

                        vm.NearBySitesList =  response.data;
                        this.alertSuccess();

                    })
                    .catch(error => {

                        if (error.response.status === 419) {
                            let message = "Please you have been logged out because you were inactive."
                            vm.registerError(419, null, message)

                        } else {

                            vm.registerError(param.errorCode, param, param.errorMessage);

                        }

                    });
                this.stopLoading();

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
        }
    }
</script>

<style scoped>

</style>
