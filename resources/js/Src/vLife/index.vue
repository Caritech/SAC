<template>
    <main-layout>
        <router-view></router-view>
    </main-layout>
</template>

<script>
import MainNavComponent from "./components/MainLayoutComponent"
import VueRouter from "vue-router"
import HomePage from "./pages/HomePage"
import MyContactListsPage from "./pages/MyContactListsPage"

import MyContactIndexPage from "./pages/MyContact/IndexPage"
//FORM PAGE
import AddContactFormPage from "./pages/MyContact/Forms/AddContactFormPage"
import EditContactFormPage from "./pages/MyContact/Forms/EditContactFormPage"
import CashFlowIncomeFormPage from "./pages/MyContact/Forms/CashFlowIncomeFormPage"
import AssetInvestmentFormPage from "./pages/MyContact/Forms/AssetInvestmentFormPage"
import InsuranceFormPage from "./pages/MyContact/Forms/InsuranceFormPage"

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
        component: MyContactListsPage,
    },

    {
        path: "/my_contact/:id/edit/:tab",
        component: MyContactIndexPage,
    },
    {
        path: "/my_contact/:id/edit/:tab/:sub_tab",
        component: MyContactIndexPage,
    },
    {
        path: "/my_contact/profile/create",
        component: AddContactFormPage,
    },
    {
        path: "/my_contact/profile/:contact_id/edit",
        component: EditContactFormPage,
    },
    {
        path: "/my_contact/cashflow/income/:id/edit",
        component: CashFlowIncomeFormPage,
    },
    {
        path: "/my_contact/cashflow/income/:contact_id/create",
        component: CashFlowIncomeFormPage,
    },
    {
        path: "/my_contact/asset_investment/:contact_id/create",
        component: AssetInvestmentFormPage,
    },
    {
        path: "/my_contact/asset_investment/:id/edit",
        component: AssetInvestmentFormPage,
    },
    //insurance (existing & Recommendation)
    {
        path: "/my_contact/insurance/:contact_id/create", //id is contact id
        component: InsuranceFormPage,
    },
    {
        path: "/my_contact/insurance/:insurance_id/edit", //id is insurance id
        component: InsuranceFormPage,
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
