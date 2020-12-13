/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./Components/ExampleComponent.vue -> <example-component></example-component>
 */

Vue.component('vlife', require('./Src/vLife/index.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

import router from './Routes/router'


import VueTagsInput from '@johmun/vue-tags-input';

import { BootstrapVue, IconsPlugin } from 'bootstrap-vue'

import 'vue-cool-select/dist/themes/bootstrap.css';
import VeeValidate from 'vee-validate';

// Install BootstrapVue
Vue.use(BootstrapVue)
// Optionally install the BootstrapVue icon components plugin
Vue.use(IconsPlugin)


Vue.use(VeeValidate, { fieldsBagName: 'formFields' })

Vue.component('vue-tags-input', VueTagsInput)


import VueSweetalert2 from 'vue-sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';
Vue.use(VueSweetalert2);

import fab from 'vue-fab'
Vue.component('fab', fab)


import vueNumeralFilterInstaller from 'vue-numeral-filter';
Vue.use(vueNumeralFilterInstaller, { locale: 'en-au' });



import MyDatepicker from './Components/InputComponent/Datepicker';
Vue.component('date-picker', MyDatepicker)
Vue.component('my-datepicker', MyDatepicker)

import MyVueTable from './Components/MyVueTable';
Vue.component('my-vuetable', MyVueTable)

import Vue from 'vue';
Vue.prototype.$eventBus = new Vue();

import Checkbox from './Components/InputComponent/Checkbox';
//Vue.component('checkbox', Checkbox)
Vue.component('my-checkbox', Checkbox)

import MySelect from './Components/InputComponent/Select';
Vue.component('my-select', MySelect)
import MyFormGroup from './Components/InputComponent/FormGroup';
Vue.component('my-form-group', MyFormGroup)
import MyMultipleInput from './Components/InputComponent/MultipleInput';
Vue.component('my-multiple-input', MyMultipleInput)
import MyRangeInput from './Components/InputComponent/RangeInput';
Vue.component('my-range-input', MyRangeInput)

import mixin from './Mixins/index'
import store from './Stores/index'
import VueRouter from "vue-router"
Vue.use(VueRouter)

const app = new Vue({
    el: '#app',
    router,
    store,
    data: function () {
        return {
            sidebarToggle: false,
            navbarFixedTop: true,
        }
    },
    methods: {
        toggleSidebar: function () {
            this.sidebarToggle = this.sidebarToggle ? false : true;
        },
    },
    mounted() {
        if (window.innerWidth <= 768) {
            this.sidebarToggle = true;
        }
    }
});
