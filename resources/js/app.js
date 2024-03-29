/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import carousel from 'vue-owl-carousel';

require('./bootstrap');
window.Vue = require('vue');


import Slick from 'vue-slick';
import Viewer from 'v-viewer';


import Vuetify from 'vuetify';
Vue.use(Vuetify);

import {RotateSquare2} from 'vue-loading-spinner';
import Multiselect from 'vue-multiselect'
window.RotateSquare2 = RotateSquare2;

import Helpers from "./Helpers";
import VueCurrencyFilter from 'vue-currency-filter';

Vue.use(VueCurrencyFilter,
    {
        symbol : 'GH₵',
        thousandsSeparator: ',',
        fractionCount: 2,
        fractionSeparator: '.',
        symbolPosition: 'front',
        symbolSpacing: true
    });

Vue.use(VueRouter);
window.helpers = Helpers;

require('@fortawesome/fontawesome-free/js/all.js');
require('bootstrap-table/dist/bootstrap-table.min.css');
require('bootstrap-table/dist/bootstrap-table.js');

require('tableexport.jquery.plugin');
require('bootstrap-table/dist/extensions/export/bootstrap-table-export.min.js');
require('bootstrap-table/dist/extensions/print/bootstrap-table-print.min.js');

require('bootstrap-table/dist/extensions/filter-control/bootstrap-table-filter-control.min.css');
require('bootstrap-table/dist/extensions/filter-control/bootstrap-table-filter-control.min.js');





/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/Home.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

//Vue.Component('Home', require('./components/Home.vue').default);
let routes = [

    // This was used to test the moment Js
    // {path:'/ernest/ernest', component: require('./MomentTest').default},



    //general home
    {path:'/home', component: require('./components/Home.vue').default},
    {path:'/password/update', component: require('./components/Password.vue').default},

    //admin
    {path:'/admin/dashboard', component: require('./components/Admin/Dashboard.vue').default},
    {path:'/manage/hotel', component: require('./components/Admin/Hotel.vue').default},
    {path:'/manage/tourist-sites', component: require('./components/Admin/TouristSite.vue').default},
    {path:'/manage/traveller', component: require('./components/Admin/Traveller.vue').default},
    {path:'/manage/transport', component: require('./components/Admin/Transport.vue').default},
    {path:'/manage/admin', component: require('./components/Admin/Admin.vue').default},
    {path:'/admin/profile', component: require('./components/Admin/Profile.vue').default},

    {path:'/tourist-site/details/:id', component: require('./components/Admin/TouristSiteDetails').default, name:'tourist-site-details'},

    //hotel
    {path:'/hotel/profile', component: require('./components/Hotel/Profile.vue').default},
    {path:'/hotel/rooms', component: require('./components/Hotel/Rooms.vue').default},
    {path:'/hotel/:hotelName/:hotelId',
        component: require('./components/Traveller/HotelShowFull').default,
        name:'hotel.show',
        props: true
    },

    {path:'/hotel/bookings', component: require('./components/Hotel/Bookings.vue').default},
    {path:'/hotel/dashboard', component: require('./components/Hotel/Dashboard.vue').default},
    {path:'/hotel/nearby-sites', component: require('./components/Hotel/NearBySites.vue').default},
    {path:'/room/details/:id', component: require('./components/Hotel/RoomDetails').default, name:'room-details'},

    //traveller
    {path:'/user/profile', component: require('./components/Traveller/Profile.vue').default},
    {path:'/user/trips', component: require('./components/Traveller/Trips.vue').default},
    {path:'/user/my-trips', component: require('./components/Traveller/MyTrips.vue').default, name:'user.my.trips'},
    {path:'/user/sites-by-regions', component: require('./components/Traveller/Regions.vue').default, name: 'user.regions'},
    {path:'/tourist-site/:siteName/:siteId',
        component: require('./components/Traveller/SiteShowFull.vue').default,
        name: 'site.show',
        props: true},

    {path:'/user/:regionName/tourist-sites/:regionId',
        component: require('./components/Traveller/RegionTouristSites.vue').default,
        name: 'user.region.sites',
        props: true,
    },

    {path:'/room/:roomName/:roomId',
        component: require('./components/Traveller/RoomShowFull.vue').default,
        name: 'user.room.show',
        props: true,
    },

    {path:'/user/all-tourist-sites', component: require('./components/Traveller/AllTouristSites.vue').default, name: 'user.sites'},
    {path:'/user/add-trip', component: require('./components/Traveller/AddTrip.vue').default},
    {path:'/user/bookings', component: require('./components/Traveller/Bookings.vue').default, name: 'user.bookings'},

    //driver
    {path:'/transport/profile', component: require('./components/Transport/Profile.vue').default},

    ];

const router = new VueRouter({
    mode:'history',
    routes

});

window.Fire = new Vue();

import VueRouter from 'vue-router';
import axios from "axios";
import { VuejsDatatableFactory } from 'vuejs-datatable';

Vue.use(VueRouter, axios, VuejsDatatableFactory);






import * as VueGoogleMaps from 'vue2-google-maps';

Vue.use(VueGoogleMaps, {
    load: {
        key: 'AIzaSyB-pi4UMAgGCCIm8V6zsvNmNrlK_rGjFOg',
        // key: 'YOUR_API_TOKEN',
        libraries: 'places', // This is required if you use the Autocomplete pluginF
        // OR: libraries: 'places,drawing'
        // OR: libraries: 'places,drawing,visualization'
        // (as you require)

        //// If you want to set the version, you can do so:
        // v: '3.26',

        //// If you want to manually install components, e.g.
        //// import {GmapMarker} from 'vue2-google-maps/src/components/marker'
        //// Vue.component('GmapMarker', GmapMarker)
        //// then set installComponents to 'false'.
        //// If you want to automatically install all the components this property must be set to 'true':
        installComponents: true

    },});


//import {Form, HasError, AlertError} from 'vform';
import {
    Form,
    HasError,
    AlertError,
    AlertErrors,
    AlertSuccess
} from 'vform';

window.Form = Form;
Vue.component(HasError.name, HasError);
Vue.component(AlertError.name, AlertError);
Vue.component(AlertErrors.name, AlertErrors);
Vue.component(AlertSuccess.name, AlertSuccess);


Vue.component('my-map', require('./components/Slots/Map').default);
Vue.component('room-mini', require('./components/Traveller/RoomShowMini').default);
Vue.component('site-mini', require('./components/Traveller/SiteShowMini').default);
Vue.component('traveller-nav', require('./components/Traveller/TravellerNav').default);
Vue.component('hotel-mini', require('./components/Traveller/HotelShowMini').default);
Vue.component('v-select', Multiselect);
Vue.component('slick', Slick);

/*Vue.component(HasError.name, HasError);
Vue.component(AlertError.name, AlertError);*/

import VueProgressBar from 'vue-progressbar'

Vue.use(VueProgressBar, {
    color: 'rgb(143, 255, 199)',
    failedColor: 'red',
    height: '2px'
});

Vue.use(Viewer);



// Import this component
import datePicker from 'vue-bootstrap-datetimepicker';
window.datePicker = datePicker;

jQuery.extend(true, jQuery.fn.datetimepicker.defaults,{
    icons:{
        time: 'far fa-clock',
        date: 'far fa-calendar',
        up: 'fas fa-arrow-up',
        down: 'fas fa-arrow-down',
        previous: 'fas fa-chevron-left',
        next: 'fas fa-chevron-right',
        today: 'fas fa-calendar',
        clear: 'far fa-trash-alt',
        close: 'far fa-times-circle',

    }
});


import Swal from 'sweetalert2';
window.Swal = Swal;


const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    onOpen: (toast) => {
        toast.addEventListener('mouseenter', Swal.stopTimer);
        toast.addEventListener('mouseleave', Swal.resumeTimer);
    }
});
window.toast = Toast;

import VueSweetalert2 from 'vue-sweetalert2';
Vue.use(VueSweetalert2);

import moment from 'moment';
Vue.filter('uptext', function(text){
    return text.charAt(0).toUpperCase() + text.slice(1);
});
Vue.filter('myDate', function(text){
    return moment(text).format('MMMM Do YYYY');
});

Vue.filter('fromdate', function(text){
    return moment(text).fromNow();
});


router.beforeResolve((to, from, next)=>{
    if(to.path){

    }
    next();
});

router.afterEach(()=>{

});

import VueLazyload from 'vue-lazyload';

Vue.use(VueLazyload);

import VueCropper from 'vue-cropperjs';
import 'cropperjs/dist/cropper.css';
Vue.component(VueCropper);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    router,
    vuetify: new Vuetify(),
    data: () => ({
        pageLoader: true,
        userId: '',
    }),
    mounted() {
        setTimeout(val => {
            this.pageLoader = false;
        }, 4000);

        Echo.channel('newUser').listen('NewUser', function(e){
            //this.index();
            // console.log(e);
        });
    },
    created(){
        this.userId = $('meta[name = "user-id"]').attr('content')
        //Vue.prototype.$userId = document.querySelector("meta[name='user-id']").getAttribute('content');
    },

});


/*


if ("geolocation" in navigator) {
    // check if geolocation is supported/enabled on current browser
    navigator.geolocation.getCurrentPosition(
        function success(position) {
            // for when getting location is a success
            console.log('latitude', position.coords.latitude,
                'longitude', position.coords.longitude);
        },
        function error(error_message) {
            // for when getting location results in an error
            console.error('An error has occured while retrieving location', error_message);
        })
} else {
    // geolocation is not supported
    // get your location some other way
    console.log('geolocation is not enabled on this browser')
}

*/
