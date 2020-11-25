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
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('contact-information-view', require('./ContactInformation/index.vue').default);
Vue.component('setting-view', require('./Setting/index.vue').default);
Vue.component('service-view', require('./Scheduler/index.vue').default);
Vue.component('core-view', require('./Core/index.vue').default);
Vue.component('centre-view', require('./Centre/index.vue').default);
Vue.component('data-adapter-view', require('./DataAdapter/index.vue').default);
Vue.component('vlife', require('./vLife/index.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

import router from './router'
import VueRouter from 'vue-router'
Vue.use(VueRouter);

import VueTable from "vuetable-2";
import vSelect from 'vue-select'
import VueTagsInput from '@johmun/vue-tags-input';
import VuePagination from './components/VuePagination.vue';
import Verte from 'verte';
import 'verte/dist/verte.css';
import { CoolSelectPlugin } from 'vue-cool-select'
import { BootstrapVue, IconsPlugin } from 'bootstrap-vue'
import { CoolSelect } from 'vue-cool-select'
import 'vue-cool-select/dist/themes/bootstrap.css';
import VuetablePaginationInfo from 'vuetable-2/src/components/VuetablePaginationInfo'
import VeeValidate from 'vee-validate';
//import SuiVue from 'semantic-ui-vue';
//import 'semantic-ui-css/semantic.min.css';
//Vue.use(SuiVue);

// Install BootstrapVue
Vue.use(BootstrapVue)
// Optionally install the BootstrapVue icon components plugin
Vue.use(IconsPlugin)
Vue.use(CoolSelectPlugin)

Vue.use(VeeValidate, { fieldsBagName: 'formFields' })
Vue.component('verte', Verte);
Vue.component('v-select', vSelect)
Vue.component('vuetable', VueTable)

Vue.component('vuetable-pagination-info', VuetablePaginationInfo)
Vue.component('vt-pagination', VuePagination)
Vue.component('vue-tags-input', VueTagsInput)

Vue.component('cool-select', CoolSelect)

import VueSweetalert2 from 'vue-sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';
Vue.use(VueSweetalert2);

import fab from 'vue-fab'
Vue.component('fab', fab)


import vueNumeralFilterInstaller from 'vue-numeral-filter';
Vue.use(vueNumeralFilterInstaller, { locale: 'en-au' });




//CUSTOM Component
// import InputText,{InputCheckbox} from './components/InputComponent';
// Vue.component('input-text',InputText)
// Vue.component('input-checkbox',InputCheckbox)
import MyDatepicker from './components/InputComponent/Datepicker';
Vue.component('date-picker', MyDatepicker)
Vue.component('my-datepicker', MyDatepicker)

import MyVueTable from './components/MyVueTable';
Vue.component('my-vuetable', MyVueTable)

import Vue from 'vue';
Vue.prototype.$eventBus = new Vue();

import Checkbox from './components/InputComponent/Checkbox';
Vue.component('checkbox', Checkbox)

import MySelect from './components/InputComponent/Select';
Vue.component('my-select', MySelect)
import MyFormGroup from './components/InputComponent/FormGroup';
Vue.component('my-form-group', MyFormGroup)
import MyMultipleInput from './components/InputComponent/MultipleInput';
Vue.component('my-multiple-input', MyMultipleInput)

import mixin from './mixins/index'

const app = new Vue({
    el: '#app',
    router,
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
