<template>
    <div class="container-fluid">
        <ul class="nav nav-tabs">
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
        </ul>


        <div class="row" v-if="showingRegions" id="Regions">

            <div class="col-sm-12 col-md-6 col-lg-3 text-center" v-for="region in regions">

                <div class="btn btn-primary animate__animated animate__zoomInDown"  @click="makeAction(490,region)">
                    <img
                        src="/region_back.jpg" alt=""
                        class="img-fluid  ">
                    <div class="caption ">
                        <h5 class="p-3 text-white animate__animated animate__zoomInDown">{{region.name}}</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>

</template>

<script>
    import Helpers from '../../Helpers';
    export default {
        name: "Regions",
        data() {
            return {

                showingRegions: true,


                regionHover: null,
                regionHoverAnimation: '',

                loading: false,


                appError: false,
                errorParam: undefined,
                errorMessage: "",
                appStateCode: 0,


                regions: [],

                activeTouristSite: undefined,


            }
        },
        methods: {
            appState(StateId) {
                let vm = this;

                this.showingRegions = false;


                switch (StateId) {

                    // Showing Regions
                    case 4:
                        vm.showingRegions = true;
                        vm.showingTouristSitesByRegion = true;
                        break;

                    default:
                        break;

                }
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
                        // vm.appStateCode(4);
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

                * Code 489 => LoadRegions
                *
                * */
                let vm = this;
                switch (code) {

                    case 419:
                        //  the page should reload
                        this.errorCode = 0;
                        Helpers.reloadPage();
                        this.errorParam = undefined;
                        break;

                    case 489:
                        // alert('here ooo');
                        vm.loadRegions();
                        break;

                    case 490:
                        // alert('here ooo');
                        vm.openRegionSites(param);
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
                location.assign(location.href);
            },
            openRegionSites(region){
                // this.$router.push({path: `/tourist-site/details/${row.id}`});
                this.$router.push({
                    name:'user.region.sites',
                    params:{
                        regionName:region.url_name,
                        regionId:region.id,
                        pActiveRegion:region
                    },
                    props:{
                        pActiveRegion:region
                    }

                });



            }


        },
        created() {
            this.makeAction(489);

            // Helpers.reloadPage();

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

            /*toast.fire({
                title: 'Are you sure?',
                icon: 'warning',
            });*/
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
