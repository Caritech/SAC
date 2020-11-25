<template>
    <router-view></router-view>
</template>

<script>
import VueRouter from "vue-router";
import Dashboard from "./pages/DashboardPage";

/*
    Nested Route
*/
const routes = [
    { path: "/", component: Dashboard },
    { path: "/dashboard", component: Dashboard }
];

/*
    Remember to set Base
*/
const router = new VueRouter({
    base: "/",
    mode: "history",
    routes // short for `routes: routes`
});

/*
    Export the component
*/
export default {
    components: {},
    router: router
};
</script>
