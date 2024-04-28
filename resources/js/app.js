/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import moment from "moment";
import VueTimers from 'vue-timers';
import mixin from './mixins.js';
import VueToastr from 'vue-toastr';

require('./bootstrap');

window.Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

const files = require.context('./', true, /\.vue$/i)
files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

//Vue.component('example-component', require('./components/ExampleComponent.vue').default);
// Vue.component('admin-component', require('./components/AdminComponent').default);
// Vue.component('company-component', require('./components/CompanyComponent').default);
// Vue.component('device-component', require('./components/DeviceComponent').default);
// Vue.component('notice-component', require('./components/NoticeComponent').default);
// Vue.component('history-component', require('./components/HistoryComponent').default);
// Vue.component('history-detail-component', require('./components/HistoryDetailComponent').default);
// Vue.component('setting-history-component', require('./components/SettingHistoryComponent').default);


// Vue.component('company-detail-component', require('./components/CompanyDetailComponent').default);

Vue.use(VueTimers);
Vue.component('loading', require('./components/Loading').default);
Vue.component('pager', require('./components/Pager').default);

Vue.use(VueToastr, {
    defaultPosition     :   'toast-bottom-center',
    defaultStyle: {
        'background-color'  : "#4EFF2F",
    },
});

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
});
