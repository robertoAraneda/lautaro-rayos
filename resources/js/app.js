import Vue from 'vue';
import Vuetify from 'vuetify';
import es from 'vuetify/es5/locale/es';
import App from './App.vue';
import '@mdi/font/css/materialdesignicons.css';

//support vuex
import store from './store';
import router from './router';

Vue.use(Vuetify);

window.swal = require('sweetalert2');

const toast = swal.mixin({
    toast: true,
    showConfirmButton: false,
    timer: 3000,
    position: 'top-end',
});

window.toast = toast;

require('./services/subscriber');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('app', App);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

store.dispatch('auth/attempt', localStorage.getItem('access_token'));

const app = new Vue({
    el: '#app',
    store,
    router,
    vuetify: new Vuetify({
        lang: {
            locales: { es },
            current: 'es',
        },
        theme: {
            themes: {
                light: {
                    burdeo: '#731739', //'#027087'
                    celeste: '#77ABD9',
                    verde: '#1B8CA6',
                },
            },
        },
        icons: {
            iconfont: 'mdi', // default - only for display purposes
        },
    }),
});
