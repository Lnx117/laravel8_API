/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue').default;

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

//Vue.component('appliactions-component', require('./components/Applications/ApplicationsComponent.vue').default);
// Vue.component('appliactions-item-component', require('./components/Applications/ApplicationItemComponent.vue').default);

import ApplicationsComponent from './components/Applications/New/ApplicationsComponent.vue';
import ApplicationsInProgressComponent from './components/Applications/inProgress/ApplicationsInProgressComponent.vue';
import ApplicationsDoneComponent from './components/Applications/Done/ApplicationsDoneComponent.vue';
import ApplicationsCreateComponent from './components/Applications/Create/ApplicationsCreateComponent.vue';
import UsersComponent from './components/Users/UsersComponent.vue';

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    components: {
        ApplicationsComponent,
        UsersComponent,
        ApplicationsInProgressComponent,
        ApplicationsDoneComponent,
        ApplicationsCreateComponent,
    },
});
