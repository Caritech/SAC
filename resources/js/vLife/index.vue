<template>
    <main-layout>
        <router-view></router-view>
    </main-layout>
</template>

<script>
import MainNavComponent from "./components/MainLayoutComponent"
import VueRouter from "vue-router"
import HomePage from "./pages/HomePage"
import MyContactPage from "./pages/MyContactPage"
import MyContactFormPage from "./pages/MyContactFormPage"
import MyContactProfilePage from "./pages/MyContactProfilePage"
import MyContactCashFlowIncomePage from "./pages/MyContactCashFlowIncomePage"
import MyContactFormCashflowPage from "./pages/MyContactFormCashflowPage"
import MyContactAssetInvestmentPage from "./pages/MyContactAssetInvestmentPage"
import MyContactAddNewPage from "./pages/MyContactAddNewPage"
//insurance page
import MyContactInsurancePage from "./pages/MyContactInsurancePage"
//summary page
/*
    Nested Route
*/
const routes = [
    {
        path: "/",
        component: HomePage,
    },
    {
        path: "/my_contact",
        component: MyContactPage,
    },
    {
        path: "/my_contact/cashflow",
        component: MyContactFormCashflowPage,
    },
    {
        path: "/my_contact/:id/edit/:tab",
        component: MyContactFormPage,
    },
    {
        path: "/my_contact/:id/edit/:tab/:sub_tab",
        component: MyContactFormPage,
    },
    {
        path: "/my_contact/profile/create",
        component: MyContactAddNewPage,
    },
    {
        path: "/my_contact/profile/:contact_id/edit",
        component: MyContactProfilePage,
    },
    {
        path: "/my_contact/cashflow/income/:id/edit",
        component: MyContactCashFlowIncomePage,
    },
    {
        path: "/my_contact/cashflow/income/:contact_id/create",
        component: MyContactCashFlowIncomePage,
    },
    {
        path: "/my_contact/asset_investment/:contact_id/create",
        component: MyContactAssetInvestmentPage,
    },
    {
        path: "/my_contact/asset_investment/:id/edit",
        component: MyContactAssetInvestmentPage,
    },
    //insurance (existing & Recommendation)
    {
        path: "/my_contact/insurance/:contact_id/create", //id is contact id
        component: MyContactInsurancePage,
    },
    {
        path: "/my_contact/insurance/:insurance_id/edit", //id is insurance id
        component: MyContactInsurancePage,
    },
    // {
    //     path: "/my_contact/asset_investment/:id/edit",
    //     component: MyContactAssetInvestmentPage,
    // },
]
/*
    Remember to set Base
*/
const router = new VueRouter({
    base: "/vlife",
    mode: "history",
    routes, // short for `routes: routes`
})
/*
    Export the component
*/
export default {
    components: {
        "main-layout": MainNavComponent,
    },
    router: router,
}
</script>
