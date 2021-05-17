/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue').default;
import VueToast from 'vue-toast-notification';
Vue.use(VueToast);
import Vue from 'vue';


/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('password', require('./components/Password.vue').default);

Vue.component('staff', require('./components/Administrator/Staff.vue').default);
Vue.component('member', require('./components/Administrator/Member.vue').default);
Vue.component('lgu', require('./components/Administrator/Lgu.vue').default);
Vue.component('application-setting', require('./components/Administrator/Setting.vue').default);
Vue.component('admin-home', require('./components/Administrator/Home.vue').default);

// Vue.component('newasset', require('./components/Member/NewAsset.vue').default);
Vue.component('inventory', require('./components/Member/Asset.vue').default);
Vue.component('asset-create', require('./components/Member/AssetNew.vue').default);
Vue.component('asset-view', require('./components/Member/AssetView.vue').default);
Vue.component('asset-track', require('./components/Member/AssetTrack.vue').default);
Vue.component('member-list', require('./components/Member/List.vue').default);
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
});
