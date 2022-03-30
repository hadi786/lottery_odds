/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

window.Vue = require('vue').default;

import vuetify from './vuetify'
import router from './router'
import App from './views/App.vue'

Vue.component('example-component', require('./components/ExampleComponent.vue').default);

 new Vue({
    el: '#app',
    vuetify,
    components: { App },
    router
});
