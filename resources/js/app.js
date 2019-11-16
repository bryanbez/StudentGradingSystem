
require('./bootstrap');

window.Vue = require('vue');
window.Axios = require('axios');


import VueRouter from 'vue-router';
Vue.use(VueRouter);

Vue.component('app', require('./components/App.vue').default);
Vue.component('AppNavbar', require('./components/Layouts/App-Navbar').default);

import AllRoutes from './routes.js';

const router = new VueRouter({
    mode: 'history',
    routes: AllRoutes
});

const app = new Vue({
    router: router,
    el: '#app',
});
