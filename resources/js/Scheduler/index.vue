<template>
  <main-layout>
    <router-view></router-view>
  </main-layout>
</template>

<script>
import MainNavComponent from "./components/MainLayoutComponent";

import VueRouter from "vue-router";
import HomePage from "./pages/HomePage.vue";
import ServiceAgreementPage from "./pages/ServiceAgreementPage.vue";
import ServiceAgreementFormPage from "./pages/ServiceAgreementFormPage.vue";
import ServicePlanPage from "./pages/ServicePlanPage.vue";
import ServiceAssignmentPage from "./pages/ServiceAssignmentPage.vue";
import BudgetPlanPage from "./pages/BudgetPlanPage.vue";
import BudgetPlanClientPage from "./pages/BudgetPlanClientPage.vue";
import BudgetPlanFormPage from "./pages/BudgetPlanFormPage.vue";

/*
    Nested Route
*/
const routes = [
  { path: "/", component: HomePage },
  { path: "/service_agreement", component: ServiceAgreementPage },
  { path: "/service_agreement/create", component: ServiceAgreementFormPage },
  {
    path: "/service_agreement/:agreementId/edit",
    component: ServiceAgreementFormPage,
  },
  { path: "/service_plan", component: ServicePlanPage },
  { path: "/service_assignment", component: ServiceAssignmentPage },
  { path: "/budget_plan", component: BudgetPlanPage },
  { path: "/budget_plan/client/:clientId", component: BudgetPlanClientPage },
  { path: "/budget_plan/:budgetPlanId/edit", component: BudgetPlanFormPage },
];

/*
    Remember to set Base
*/
const router = new VueRouter({
  base: "/service",
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
