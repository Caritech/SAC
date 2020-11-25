<template>
  <main-layout>
    <router-view></router-view>
  </main-layout>
</template>

<script>
import MainNavComponent from "./components/MainLayoutComponent";
import VueRouter from "vue-router";

import HomePage from "./pages/HomePage.vue";
import LocationSelectionPage from "./pages/LocationSelectionPage.vue";
import AttendancePage from "./pages/AttendancePage.vue";
import AttendanceFormPage from "./pages/AttendanceFormPage.vue";

/*
    Nested Route
*/
const routes = [
  { path: "/", component: HomePage },
  { path: "/attendance", component: LocationSelectionPage },
  { path: "/attendance/:locationId", component: AttendancePage },
  { path: "/attendance/:locationId/create", component: AttendanceFormPage },
];

/*
    Remember to set Base
*/
const router = new VueRouter({
  base: "/centre",
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
