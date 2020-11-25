import VueRouter from 'vue-router'

import HomePage from './ContactInformation/index.vue';

const routes = [
    { path: '/', component: HomePage },
]

const router = new VueRouter({
    base: '/',
    mode: 'history',
    routes // short for `routes: routes`
})

export default router;
