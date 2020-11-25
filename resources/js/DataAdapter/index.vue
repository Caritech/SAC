<template>
  <main-layout>
    <router-view></router-view>
  </main-layout>
</template>

<script>
import MainNavComponent from "./components/MainLayoutComponent";
import VueRouter from "vue-router";

import HomePage from "./pages/HomePage.vue";
import ContactPage from "./pages/ContactPage.vue";
import ServicesPage from "./pages/ServicesPage.vue";

/*
    Nested Route
*/
const routes = [
  { path: "/", component: HomePage },
  { path: "/contactinformation", component: ContactPage },
  { path: "/services", component: ServicesPage },
];

/*
    Remember to set Base
*/
const router = new VueRouter({
  base: "/data_adapter",
  mode: "history",
  routes, // short for `routes: routes`
});

/*
    Export the component
*/
export default {
  components: {
    "main-layout": MainNavComponent,
  },
  router: router,
};
</script>
