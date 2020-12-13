<template>
    <main-layout>
        <router-view></router-view>
    </main-layout>
</template>

<script>


import VueRouter from "vue-router";
import HomePage from "./pages/HomePage.vue";
import ServicePage from "./pages/ServicePage.vue";
import ServiceDetailPage from "./pages/ServiceDetailPage.vue";
import PricePlanPage from "./pages/PricePlanPage.vue";
import Error404Page from "./pages/Error404Page.vue";


/*
    Nested Route
*/
const routes = [
    { path: "/", component: HomePage },
    { path: "/services", component: ServicePage },
    { path: "/services/:serviceId", component: ServiceDetailPage },
    { path: "/price_plan/:pricePlanId", component: PricePlanPage },
    { path: "/*", component: Error404Page },
];

/*
    Remember to set Base
*/
const router = new VueRouter({
    base: "/setting",
    mode: "history",
    routes // short for `routes: routes`
});

/*
    Export the component
*/
import MainNavComponent from "./components/MainLayoutComponent";
import ColorPicker from "./components/ColorPicker";
export default {
    components: {
        "main-layout": MainNavComponent,
        'color-picker': ColorPicker
    },
    router: router
};
</script>
