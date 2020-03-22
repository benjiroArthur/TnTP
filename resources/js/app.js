/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */



require('./bootstrap');
window.Vue = require('vue');


Vue.use(VueRouter);

require('@fortawesome/fontawesome-free/js/all.js');
require('bootstrap-table/dist/bootstrap-table.min.css');
require('bootstrap-table/dist/bootstrap-table.js');

require('tableexport.jquery.plugin');
require('bootstrap-table/dist/extensions/export/bootstrap-table-export.min.js');
require('bootstrap-table/dist/extensions/print/bootstrap-table-print.min.js');

require('bootstrap-table/dist/extensions/filter-control/bootstrap-table-filter-control.min.css');
require('bootstrap-table/dist/extensions/filter-control/bootstrap-table-filter-control.min.js');

Vue.prototype.$userId = document.querySelector("meta[name='user-id']").getAttribute('content');
Vue.prototype.$status = document.querySelector("meta[name='status']").getAttribute('content');


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
    //general home
    {path:'/home', component: require('./components/Home.vue').default},

    //admin
    {path:'/admin/dashboard', component: require('./components/Admin/Dashboard.vue').default},
    {path:'/manage/hotel', component: require('./components/Admin/Hotel.vue').default},
    {path:'/manage/tourist-sites', component: require('./components/Admin/TouristSite.vue').default},
    {path:'/manage/traveller', component: require('./components/Admin/Traveller.vue').default},
    {path:'/manage/admin', component: require('./components/Admin/Admin.vue').default},
    {path:'/admin/profile', component: require('./components/Admin/Profile.vue').default},

    //hotel
    {path:'/hotel/profile', component: require('./components/Hotel/Profile.vue').default},
    {path:'/hotel/rooms', component: require('./components/Hotel/Profile.vue').default},
    {path:'/hotel/bookings', component: require('./components/Hotel/Profile.vue').default},
    {path:'/hotel/dashboard', component: require('./components/Hotel/Dashboard.vue').default},

    //traveller
    {path:'/user/profile', component: require('./components/Traveller/Profile.vue').default},
    {path:'/user/trips', component: require('./components/Traveller/Trips.vue').default},
    {path:'/user/add-trip', component: require('./components/Traveller/AddTrip.vue').default},
    {path:'/user/bookings', component: require('./components/Traveller/Bookings.vue').default},

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
        key: 'YOUR_API_TOKEN',
        libraries: 'places', // This is required if you use the Autocomplete plugin
        // OR: libraries: 'places,drawing'
        // OR: libraries: 'places,drawing,visualization'
        // (as you require)

        //// If you want to set the version, you can do so:
        // v: '3.26',
    },});


import {Form, HasError, AlertError} from 'vform';


window.Form = Form;
Vue.component(HasError.name, HasError);
Vue.component(AlertError.name, AlertError);

import VueProgressBar from 'vue-progressbar'

Vue.use(VueProgressBar, {
    color: 'rgb(143, 255, 199)',
    failedColor: 'red',
    height: '2px'
});





import Swal from 'sweetalert2';
window.swal = Swal;


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

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    router
});
