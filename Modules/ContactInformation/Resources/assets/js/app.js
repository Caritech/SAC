import VueRouter from 'vue-router';
Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('main-layout', require('./components/MainLayoutComponent.vue').default);
Vue.component('contact-information-table', require('./components/ContactInformationVueTable.vue').default);
Vue.use(VueRouter);

//import Vue from 'vue' //DO not import Vue, else it will override the Main bod Vue

import store from './store/index';
import router from './router';

const app = new Vue({
    el: '#app-contactinformation',
    store,
    router
});

export default app
