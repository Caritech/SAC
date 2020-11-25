import VueRouter from 'vue-router'

Vue.use(VueRouter)
Vue.component('example-component', require('./components/ExampleComponent.vue').default);

import Vue from 'vue'
import store from './store/index';
import router from './router';

const app = new Vue({
    el: '#app-example',
    store,
    router
});

export default app
