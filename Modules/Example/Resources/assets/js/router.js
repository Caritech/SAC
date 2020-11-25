import VueRouter from 'vue-router'
Vue.use(VueRouter)

import HomePage from './pages/HomePage.vue';

const routes = [
    { path: '/', component: HomePage },
]

const router = new VueRouter({
    base: '/example',
    mode: 'history',
    routes // short for `routes: routes`
})

export default router;
