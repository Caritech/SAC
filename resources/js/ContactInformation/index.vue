<template>
<main-layout>
    <router-view></router-view>
</main-layout>
</template>

<script>
import MainNavComponent from "./components/MainLayoutComponent";

import VueRouter from "vue-router";
import HomePage from "./pages/HomePage";
import ClientPage from "./pages/ClientPage";
import WorkerPage from "./pages/WorkerPage";
import WorkerFormPage from "./pages/WorkerFormPage";
import AllPage from "./pages/AllContactPage";

/*
    Nested Route
*/
const routes = [{
        path: "/",
        component: HomePage
    },
    {
        path: "/all",
        component: AllPage
    },
    {
        path: "/support_worker",
        component: WorkerPage
    },
    {
        path: "/support_worker/:id/edit",
        component: WorkerFormPage
    },
    {
        path: "/client",
        component: ClientPage
    }
];

/*
    Remember to set Base
*/
const router = new VueRouter({
    base: "/contactinformation",
    mode: "history",
    routes // short for `routes: routes`
});

/*
    Export the component
*/
export default {
    components: {
        "main-layout": MainNavComponent
    },
    router: router
};
</script>
