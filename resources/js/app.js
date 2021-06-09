/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

import DatePicker from 'v-calendar/lib/components/date-picker.umd';
import Vue from 'vue';
Vue.component('v-date-picker', DatePicker);

import Toasted from 'vue-toasted';
Vue.use(Toasted, {
    duration: 2000,
    theme: "outline", 
	// position: "bottom-center",
});

import Vuelidate from 'vuelidate';
Vue.use(Vuelidate);

import VueTheMask from 'vue-the-mask';
Vue.use(VueTheMask);

import wysiwyg from "vue-wysiwyg";
Vue.use(wysiwyg, {
    hideModules: { 
        "link": true,
        "code": true,
        "image": true
    },
});

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

const files = require.context('./', true, /\.vue$/i);
files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

// Vue.component('example-component', require('./components/ExampleComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

 var momenttz = require('moment-timezone');
 var moment = require('moment');

Vue.prototype.$baseAPI = '/api';

Vue.prototype.$baseAvatarPath = 'https://goo-goo-data.s3-us-west-2.amazonaws.com/avatars';

Vue.prototype.$browserTimezone = Intl.DateTimeFormat().resolvedOptions().timeZone;

Vue.prototype.$utcToLocal = function(datetime) {
    return momenttz.utc(datetime).tz(Vue.prototype.$browserTimezone).format("M/D/yy h:mm a");
};

Vue.prototype.$tempClass = function(elementId, className) {
    const el = document.getElementById(elementId);
    el.classList.add(className);
    setTimeout(() => {
        el.classList.remove(className);
    }, 5000);
};

Vue.prototype.$addClass = function(elementId, className) {
    const el = document.getElementById(elementId);
    el.classList.add(className);
};

console.log(Math.floor(moment().diff(moment('2020-03-26'), 'months', true)));

Vue.filter('dateFormat', (datetime) => {
    return momenttz.utc(datetime).tz(Vue.prototype.$browserTimezone).format("M/D/yy h:mm a");
});

Vue.filter('dateFormatMDY', (datetime) => {
    return momenttz.utc(datetime).tz(Vue.prototype.$browserTimezone).format("M/D/yy");
});

Vue.filter('dateFormatBirthday', (datetime) => {
    return moment(datetime).format("M/D/yy");
});

Vue.filter('dateFormatTime', (datetime) => {
    return momenttz.utc(datetime).tz(Vue.prototype.$browserTimezone).format("h:mm a");
});

Vue.prototype.$childBirthdayInMonths = function(birthdate) {
    const months = Math.floor(moment().diff(moment(birthdate), 'months', true));
    if (months <= 23) {
        return `${months} months old`;
    }

    return `${Math.floor(months/12)} years old`;
}

const app = new Vue({
    el: '#app',
});


