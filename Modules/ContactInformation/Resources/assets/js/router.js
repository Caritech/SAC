import VueRouter from 'vue-router'
import HomePage from './pages/HomePage.vue';
import WorkerPage from './pages/WorkerPage.vue';
import ClientPage from './pages/ClientPage.vue';
import AllContactPage from './pages/AllContactPage.vue';

const routes = [
    { path: '/', component: HomePage },
    { path: '/worker', component: WorkerPage },
    { path: '/client', component: ClientPage },
    { path: '/all_contact', component: AllContactPage },
]

const router = new VueRouter({
    base: '/contactinformation',
    mode: 'history',
    routes // short for `routes: routes`
})

export default router;
