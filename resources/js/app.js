
require('./bootstrap');

window.Vue = require('vue');
window.Axios = require('axios');
import VueRouter from 'vue-router';
import VueGraph from 'vue-graph';
import GraphLine3D from 'vue-graph/src/components/line3d.js';
import NoteWidget from 'vue-graph/src/widgets/note.js';
import LegendWidget from 'vue-graph/src/widgets/legends.js';
import VueHtmlToPaper from 'vue-html-to-paper';

 
Vue.use(VueRouter);
Vue.use(VueGraph);

const options = {
    specs: [
        'fullscreen=no',
        'titlebar=no',
        'scrollbars=no'
    ],
    styles: [
       'https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css',
       'https://unpkg.com/kidlat-css/css/kidlat.css'
    ]
};

Vue.use(VueHtmlToPaper, options);

Vue.component(GraphLine3D.name, GraphLine3D);
Vue.component(NoteWidget.name, NoteWidget);
Vue.component(LegendWidget.name, LegendWidget);
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
