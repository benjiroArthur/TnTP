<template>
    <div class="container-fluid">
        <div id="MD">
            <!-- Modal -->
            <div class="modal animate__animated animate__zoomIn"
                 id="creatTripInstruction" data-backdrop="static" data-keyboard="false"
                 tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="staticBackdropLabel">How To create a trip.</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <h4>Step 1</h4>
                            <p>Look for the location (Tourist Site)</p>
                            <h4>Step 2</h4>
                            <p>Schedule a trip to that site.</p>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal" @click="hideInstruction">Hide</button>
                            <button type="button" class="btn btn-primary" @click="findTouristSite">Find Tourist Site</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>



        <div class="row">
            <div class="col-sm-12 col-md-10 col-lg-10">
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
            </div>
            <div class="col-sm-12 col-md-2 col-lg-2">

                <button class="btn btn-block btn-primary btn-block" @click="showInstruction">Create</button>
            </div>
        </div>

        <div class="row ">
            <div class="col-sm-12 col-md-4 col-lg-4 ">
                <h4 class="list-group-item">ALL TRIPS</h4>
            </div>

            <div class="col-sm-12 col-md-8 col-lg-8 ">
                <h4 class="text-center">{{activeTrip.name}}</h4>
            </div>

            <div class="col-sm-12 col-md-4 col-lg-4">
                <div class="list-group" >
                    <button class="list-group-item list-group-item-action animate__animated"
                        v-for="trip in trips"
                        :key="trip.id"
                        @click="changeActiveTrip(trip)"
                        :class="activeTrip.id === trip.id ? 'active animate__pulse':''"
                    >{{trip.name|tripNameFilter}}</button>
                </div>

            </div>
            <div class="col-sm-12 col-md-8 col-lg-8 ">


                <div class="list-group list-group-horizontal-sm ">
                    <button class="list-group-item list-group-item-action animate__animated "
                        :class="showingTripDetails ? 'active animate__pulse':''"
                        @click="appState(1)">DETAILS</button>

                    <button class="list-group-item list-group-item-action animate__animated"
                        :class="showingTripActivitiesList ? 'active animate__pulse':''"
                        @click="appState(2)">ACTIVITIES</button>

                    <button class="list-group-item list-group-item-action animate__animated"
                        :class="showingTripItemsList ? 'active animate__pulse':''"
                        @click="appState(3)">ITEMS LIST</button>
                </div>
                <hr>
                <div class="">
                    <div id="tripInfo" v-if="showingTripDetails">
                        <viewer  ref="viewer" rebuild :trigger="activeTrip.tourist_site.images"  :options="viewerOptions">
                            <slick   :options="slickOptions"  ref="slick">
                                <img v-for="image in activeTrip.tourist_site.images"
                                     :src="image.thumbnail" :data-src="image.source" :key="image.id" class="p-3">
                            </slick>
                        </viewer>

                        <hr>
                        <h4>{{activeTrip.tourist_site.name}}</h4>

                        <h5>Price Per Person {{activeTrip.tourist_site.price | currency }}</h5>
                    </div>


                    <div id="tripActivities" v-if="showingTripActivitiesList">
                        <p>This is the list of activities you will love to do during your trip.</p>
                        <div class="input-group mb-3">
                            <div class="input-group-append">
                                <input class="form-control" type="date" v-model="txtActivityDate">
                            </div>
                            <input type="text" class="form-control"
                                   placeholder="Add new item to list"
                                   aria-label="Item name"
                                   aria-describedby="addBTN"
                                   @keyup.enter="addActivity"
                                   v-model="txtActivityName"
                            >
                            <div class="input-group-append">
                                <button  :disabled="!txtActivityName && !txtActivityDate"
                                         @click="addActivity" class="btn btn-outline-secondary"
                                         type="button" >ADD</button>
                            </div>
                        </div>

                        <ul class="list-group">


                            <li class="list-group-item iistliac"
                                v-for="item in activeTrip.activities"
                                :key="item.id">
                                <div class="icheck-material-blue icheck-inline">
                                    <input :value="item.done" @change="toggleDoneState(item)" id="check" type="checkbox" :id="'CheckboxId'+item.id"  />
                                    <label for="check" :for="'CheckboxId'+item.id"></label>
                                </div>
                                {{item.name}} <span class="badge badge-primary">{{item.nice_date}}</span>
                                <button
                                    class="badge badge-btn badge-primary badge-pill float-right animate__animated"
                                    @click="removeFromActivityList(item)">X</button>
                            </li>

                        </ul>
                    </div>

                    <div id="tripTripItems" v-if="showingTripItemsList">
                        <p>This is the Item lists</p>


                        <div class="input-group mb-3">
                            <input type="text" class="form-control"
                                   placeholder="Add new item to list"
                                   aria-label="Item name"
                                   aria-describedby="addBTN"
                                   @keyup.enter="addItem"
                                   v-model="txtItemName"
                            >
                            <div class="input-group-append">
                                <button  :disabled="!txtItemName"
                                         @click="addItem" class="btn btn-outline-secondary"
                                         type="button" id="addBTN">ADD</button>
                            </div>
                        </div>


                        <ul class="list-group">

                            <li class="list-group-item iistliac"
                                v-for="item in activeTrip.checklist"
                                :key="item.id">
<!--                                <input type="text" class="form-control" v-model="item.name">-->
                                {{item.name}}
                                <button
                                    class="badge badge-btn badge-primary badge-pill float-right animate__animated"
                                    @click="removeFromChecklist(item)">X</button>
                            </li>

                        </ul>
                    </div>


                </div>

            </div>

        </div>
    </div>
</template>

<script>
    import Helpers from "../../Helpers";

    export default {
        name: "MyTrips",
        data() {
            return {
                showingTripDetails:false,
                showingTripItemsList:false,
                showingTripActivitiesList:false,

                loading: false,

                trips:[],
                activeTrip:{
                    tourist_site:{},
                    activities:[
                        {nice_date:""}
                    ]
                },


                appError: false,
                errorParam: undefined,
                errorMessage: "",
                appStateCode: 0,

                txtItemName:null,
                txtActivityName:null,
                txtActivityDate:null,

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

                this.showingTripDetails = false;
                this.showingTripActivitiesList = false;
                this.showingTripItemsList = false;


                switch (StateId) {

                    // Showing trip details
                    case 1:
                        vm.showingTripDetails = true;
                        break;
                    // Showing trip details
                    case 2:
                        vm.showingTripActivitiesList = true;
                        break;
                    // Showing trip details
                    case 3:
                        vm.showingTripItemsList = true;
                        break;

                    default:
                        break;

                }
            },
            makeAction(code, param = null) {
                /*
                *Load Trips Code 100
                * */
                let vm = this;
                switch (code) {

                    case 419:
                        //  the page should reload
                        this.errorCode = 0;
                        Helpers.reloadPage();
                        this.errorParam = undefined;
                        break;

                    case 800:
                        vm.loadTrips();
                        break;

                    case 710:
                        vm.addItemToList(param);
                        break;

                    case 720:
                        vm.addActivityToList(param);
                        break;

                        case 730:
                        vm.toggleActivityDoneState(param);
                        break;


                }
            },

            loadTrips() {
                //load Trips AppCode 800
                let vm = this;
                this.startLoading();
                axios.post('/data/trip',
                    {
                        mode: "load-trips",
                    })
                    .then(response => {
                        vm.trips = response.data;
                        if (vm.trips.length > 1){
                            this.activeTrip = vm.trips[0];

                            this.appState(1);

                        }
                    })
                    .catch(error => {
                        if (error.response.status === 419) {
                            let message = "Please you have been logged out because you were inactive."
                            vm.registerError(419, null, message)

                        } else {
                            let message = "The was problem loading your Trips."
                            vm.registerError(800, null, message)
                        }

                    });
                this.stopLoading();
            },

            hideInstruction(){
                $('#creatTripInstruction').modal('hide');
            },
            showInstruction(){
                $('#creatTripInstruction').modal('show');
            },

            findTouristSite(){

            },

            addItemToList(item ){
                //Add Item To Item list Code 710
                let vm = this;
                this.startLoading();
                axios.post('/data/trip',
                    {
                        mode: "add-item-to-list",
                        trip_id:item.tripId,
                        check_name:item.name,
                    })
                    .then(response => {
                        vm.updateChecklist(item.tripId, response.data);
                    })
                    .catch(error => {
                        if (error.response.status === 419) {
                            let message = "Please you have been logged out because you were inactive."
                            vm.registerError(419, null, message)

                        } else {
                            let message = "The was problem adding item to list."
                            vm.registerError(710, item, message)
                        }

                    });
                this.txtItemName = null;
                this.stopLoading();
            },

            addActivityToList(item ){
                //Add Item To Item list Code 710
                let vm = this;
                this.startLoading();
                axios.post('/data/trip',
                    {
                        mode: "add-activity-to-list",
                        trip_id:item.tripId,
                        name:item.name,
                        date:item.date,
                    })
                    .then(response => {
                        vm.updateActivityList(item.tripId, response.data);
                    })
                    .catch(error => {
                        if (error.response.status === 419) {
                            let message = "Please you have been logged out because you were inactive."
                            vm.registerError(419, null, message)

                        } else {
                            let message = "The was problem adding Activity to list."
                            vm.registerError(720, item, message)
                        }

                    });
                this.txtActivityName = this.txtActivityDate = null;

                this.stopLoading();
            },


            toggleActivityDoneState(item ){
                //Add Item To Item list Code 710
                let vm = this;
                this.startLoading();
                axios.post('/data/trip',
                    {
                        mode: "toggle-activity-done-state",
                        id:item.id
                    })
                    .then(response => {
                        vm.updateActivityList(item.tripId, response.data);
                    })
                    .catch(error => {
                        if (error.response.status === 419) {
                            let message = "Please you have been logged out because you were inactive."
                            vm.registerError(419, null, message)

                        } else {
                            let message = "The was problem saving your change."
                            vm.registerError(730, item, message)
                        }

                    });
                this.txtItemName = null;
                this.stopLoading();
            },



            addItem(){
                if(this.txtItemName){
                    let vm = this;
                    let item = {
                        name:vm.txtItemName,
                        tripId:vm.activeTrip.id,
                    }
                    this.makeAction(710, item);
                }
            },

            addActivity(){
                if(this.txtActivityName && this.txtActivityDate){
                    let vm = this;
                    let item = {
                        name:vm.txtActivityName,
                        tripId:vm.activeTrip.id,
                        date:vm.txtActivityDate
                    }
                    this.makeAction(720, item);
                }
            },

            toggleDoneState(item){
                let activity = {
                    id:item.id
                }
                this.makeAction(730, activity);
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

            registerError(code, param, message) {
                this.appStateCode = code;
                this.errorParam = param;
                this.errorMessage = message + "(Error Code "+ code +" )" ;
                this.appError = true;
            },
            tryAgain() {
                this.makeAction(this.appStateCode, this.errorParam);
                this.appError = false;
            },
            changeActiveTrip(trip){
                this.startLoading();
                this.destroyImageDisplay();
                this.activeTrip = trip;
                this.initImageDisplay();
                this.stopLoading();
            },


            reloadPage() {
                location.assign(location.href);
            },

            initImageDisplay(){
                this.$nextTick(()=>{

                    this.appState(1);

                });

            },

            destroyImageDisplay(){
                this.appState(3);
            },


            updateChecklist(tripId, newChecklist){
                let vm = this;
                for (let i = 0; i < this.trips.length; i++) {

                    if (vm.trips[i].id === tripId ){
                        vm.trips[i].checklist = newChecklist;
                    }
                }
            },

            updateActivityList(tripId, newActivityList){
                let vm = this;
                for (let i = 0; i < this.trips.length; i++) {

                    if (vm.trips[i].id === tripId ){
                        vm.trips[i].activities = newActivityList;
                    }
                }
            },
            removeFromChecklist(item){
                //Add Item To Item list Code 710
                let vm = this;
                this.startLoading();
                axios.post('/data/trip',
                    {
                        mode: "remove-item-from-list",
                        item_id:item.id,
                    })
                    .then(response => {
                        vm.updateChecklist(item.trip_id, response.data);
                    })
                    .catch(error => {
                        if (error.response.status === 419) {
                            let message = "Please you have been logged out because you were inactive."
                            vm.registerError(419, null, message)

                        } else {
                            let message = "The was problem removing item from the list."
                            vm.registerError(710, item, message)
                        }

                    });
                this.txtItemName = null;
                this.stopLoading();
            },

            removeFromActivityList(item){
                //Add Item To Item list Code 710
                let vm = this;
                this.startLoading();
                axios.post('/data/trip',
                    {
                        mode: "remove-activity-from-list",
                        id:item.id,
                    })
                    .then(response => {
                        vm.updateActivityList(item.trip_id, response.data);
                    })
                    .catch(error => {
                        if (error.response.status === 419) {
                            let message = "Please you have been logged out because you were inactive."
                            vm.registerError(419, null, message)

                        } else {
                            let message = "The was problem removing item from the list."
                            vm.registerError(710, item, message)
                        }

                    });
                this.txtItemName = null;
                this.stopLoading();
            },



        },
        created() {
            this.makeAction(800);

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
        filters:{
            tripNameFilter(value){
                let textLength = 50;
                let val = value.slice(0,textLength);
                return  value.length < textLength ? value : val + '...';
            }
        }

    }
</script>

<style scoped>

</style>
