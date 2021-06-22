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
        "image": true,
        // "table": true,
        // "removeFormat": true
    },
});

import VueConfirmDialog from 'vue-confirm-dialog';
Vue.use(VueConfirmDialog);
Vue.component('vue-confirm-dialog', VueConfirmDialog.default);

import VTooltip from 'v-tooltip';
Vue.use(VTooltip);

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

Vue.prototype.$currentUser = currentUser;

 var momenttz = require('moment-timezone');
 var moment = require('moment');

Vue.prototype.$baseAPI = '/api';

Vue.prototype.$baseAvatarPath = 'https://goo-goo-data.s3-us-west-2.amazonaws.com/avatars';

Vue.prototype.$baseChildImage = '/img/base_child_image.png';

Vue.prototype.$avatarOrDefault = function(path) {
    if (path) {
        return `${Vue.prototype.$baseAvatarPath}/${path}?${performance.now()}`;
    }

    return Vue.prototype.$baseChildImage;
}

Vue.prototype.$browserTimezone = Intl.DateTimeFormat().resolvedOptions().timeZone;

Vue.prototype.$dateToMoment = function(date) {
    return moment(date + ' 12:00:00');
};

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

Vue.prototype.$dateToMySQL = function(datetime) {
    return momenttz.utc(datetime).tz(Vue.prototype.$browserTimezone).format("YYYY-MM-DD");
};

Vue.prototype.$wholeOrDecimal = function(value) {
    let valueFormatted = value;
    if (valueFormatted % 1 === 0) {
      valueFormatted = Math.floor(valueFormatted);
    }
    return valueFormatted;
}

// console.log(Math.floor(moment().diff(moment('2020-03-26'), 'months', true)));

Vue.filter('dateFormat', (datetime) => {
    return momenttz.utc(datetime).tz(Vue.prototype.$browserTimezone).format("M/D/yy h:mm a");
});

Vue.filter('dateFormatMDY', (datetime) => {
    return momenttz.utc(datetime).tz(Vue.prototype.$browserTimezone).format("M/D/Y");
});

Vue.filter('dateFormatBirthday', (datetime) => {
    return moment(datetime).format("M/D/yy");
});

Vue.filter('dateFormatTime', (datetime) => {
    return momenttz.utc(datetime).tz(Vue.prototype.$browserTimezone).format("h:mm a");
});

Vue.prototype.$childBirthdayInMonths = function(birthdate) {
    const months = Math.floor(moment().diff(moment(birthdate), 'months', true));
    if (months < 1) {
        return '< 1 month old';
    }

    if (months <= 23) {
        return `${months} months old`;
    }

    return `${Math.floor(months/12)} years old`;
}

Vue.prototype.$keepElSquare = function(elementId) {
    let targetEl = document.getElementById(elementId);
    if (targetEl) {
        targetEl.style.height = `${targetEl.offsetWidth}px`;
    }

    window.addEventListener('resize', function(event) {
        let targetEl = document.getElementById(elementId);
        targetEl.style.height = `${targetEl.offsetWidth}px`;
    }, true);
}

import EntryAmount from './entryAmount';
import OunceEntry from './ounces';
import DollarEntry from './dollars';

let mockEntries = [
    {
        category_group: "Feeding",
        category_id: 48,
        category_name: "Milk",
        child_id: 36,
        created_at: "2021-06-16 20:52:03",
        entry_datetime: "2021-06-17 20:51:24",
        value: "4.50",
        prefix: null,
        suffix: "oz"
    },
    {
        category_group: "Expense",
        category_id: 25,
        category_name: "Food",
        child_id: 36,
        created_at: "2021-06-16 20:52:03",
        entry_datetime: "2021-06-17 20:51:24",
        value: "8.99",
        prefix: "$",
        suffix: null
    }
]; 

/* Polyfills */
Array.prototype.max = function() {
    return Math.max.apply(null, this);
};

Array.prototype.min = function() {
    return Math.min.apply(null, this);
};

Array.prototype.minGreaterThanZero = function() {
    console.log(this);
    // console.log(this.map(value => { if (value !== 0) { return value; } }));
    return Math.min.apply(null, this.filter(value => value !== 0));
};

const app = new Vue({
    el: '#app',
});


