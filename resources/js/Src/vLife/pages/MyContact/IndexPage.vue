<template>
    <div>
        <b-breadcrumb>
            <b-breadcrumb-item href="/vlife">Home</b-breadcrumb-item>
            <b-breadcrumb-item href="/vlife/my_contact">My Contact</b-breadcrumb-item>
            <b-breadcrumb-item active>Edit</b-breadcrumb-item>
        </b-breadcrumb>
        <div class="row mt-3">
            <div class="col-md-12">
                <ul class="nav nav-pills">
                    <li class="nav-item">
                        <a
                            class="nav-link"
                            :class="{active:tab_index == 'profile'}"
                            data-toggle="pill"
                            @click="navigationLink('profile')"
                        >Profile</a>
                    </li>
                    <li class="nav-item">
                        <a
                            class="nav-link"
                            :class="{active:tab_index == 'cashflow'}"
                            data-toggle="pill"
                            @click="navigationLink('cashflow')"
                        >Cashflow</a>
                    </li>
                    <li class="nav-item">
                        <a
                            class="nav-link"
                            :class="{active:tab_index == 'needs_calculator'}"
                            data-toggle="pill"
                            @click="navigationLink('needs_calculator')"
                        >Needs Calculator</a>
                    </li>
                    <li class="nav-item">
                        <a
                            class="nav-link"
                            :class="{active:tab_index == 'asset_investment'}"
                            data-toggle="pill"
                            @click="navigationLink('asset_investment')"
                        >Asset & Investment</a>
                    </li>
                    <li class="nav-item">
                        <a
                            class="nav-link"
                            :class="{active:tab_index == 'insurance'}"
                            data-toggle="pill"
                            @click="navigationLink('insurance')"
                        >Insurance</a>
                    </li>
                    <li class="nav-item">
                        <a
                            class="nav-link"
                            :class="{active:tab_index == 'summary'}"
                            data-toggle="pill"
                            @click="navigationLink('summary')"
                        >Summary</a>
                    </li>
                    <li class="nav-item">
                        <a
                            class="nav-link"
                            :class="{active:tab_index == 'reports'}"
                            data-toggle="pill"
                            @click="navigationLink('reports')"
                        >Reports</a>
                    </li>
                </ul>

                <!-- Tab panes -->
                <div class="tab-content">
                    <div
                        class="tab-pane container"
                        :class="{'active':tab_index == 'profile'}"
                        id="profile"
                    >
                        <contact-profile></contact-profile>
                    </div>

                    <div
                        class="tab-pane container"
                        :class="{'active':tab_index == 'cashflow'}"
                        id="cashflow"
                    >
                        <contact-cashflow></contact-cashflow>
                    </div>

                    <div
                        class="tab-pane container"
                        :class="{'active':tab_index == 'needs_calculator'}"
                        id="needs_calculator"
                    >
                        <contact-needs-calculator></contact-needs-calculator>
                    </div>

                    <div
                        class="tab-pane container"
                        :class="{'active':tab_index == 'asset_investment'}"
                        id="asset_investment"
                    >
                        <contact-asset-investment></contact-asset-investment>
                    </div>

                    <div
                        class="tab-pane container"
                        :class="{ 'active':tab_index == 'insurance'}"
                        id="insurance"
                    >
                        <MyContactFormInsurancePage></MyContactFormInsurancePage>
                    </div>

                    <div
                        class="tab-pane container"
                        :class="{ 'active':tab_index == 'summary'}"
                        id="summary"
                    >
                        <MyContactFormSummaryPage></MyContactFormSummaryPage>
                    </div>

                    <div
                        class="tab-pane container"
                        :class="{ 'active':tab_index == 'reports'}"
                        id="reports"
                    >
                        <MyContactFormReportPage></MyContactFormReportPage>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import MyContactFormProfilePage from "./Tabs/ProfileViewPage"
import MyContactFormCashflowPage from "./Tabs/CashflowViewPage"
import MyContactFormNeedsCalculatorPage from "./Tabs/NeedsCalculatorViewPage"
import MyContactFormAssetInvestmentPage from "./Tabs/AssetInvestmentViewPage"
import MyContactFormInsurancePage from "./Tabs/InsuranceViewPage"
import MyContactFormSummaryPage from "./Tabs/SummaryViewPage"
import MyContactFormReportPage from "./Tabs/ReportViewPage"

export default {
    props: ["tab"],
    components: {
        "contact-profile": MyContactFormProfilePage,
        "contact-cashflow": MyContactFormCashflowPage,
        "contact-needs-calculator": MyContactFormNeedsCalculatorPage,
        "contact-asset-investment": MyContactFormAssetInvestmentPage,
        MyContactFormInsurancePage,
        MyContactFormSummaryPage,
        MyContactFormReportPage,
    },
    data() {
        return {
            tab_index: null,
            id: "",
            asset_investment_api: "",
            login_user: {},
            contact_nc_data: {},
            add_asset_investment_btn: "",
            vlife_setting: {},
            pagination: {
                wrapperClass: "pagination float-right",
                activeClass: "active",
                disabledClass: "disabled",
                pageClass: "page-item page-link",
                linkClass: "page-link",
                paginationClass: "pagination",
                paginationInfoClass: "float-left",
                dropdownClass: "form-control",
                icons: {
                    first: "fa fa-angle-double-left",
                    prev: "fa fa-angle-left",
                    next: "fa fa-angle-right",
                    last: "fa fa-angle-double-right",
                },
            },
            asset_investment_fields: [
                {
                    name: "actions",
                    title: "Actions",
                },
                {
                    name: "checkbox",
                    title: "Incl?",
                },
                {
                    name: "description",
                    title: "Description",
                    sortField: "description",
                },
                {
                    name: "type",
                    title: "Type",
                    sortField: "type",
                },
                {
                    name: "start_age",
                    title: "Start",
                    sortField: "start_age",
                },
                {
                    name: "age_to_liquidate",
                    title: "Age To Liquidate",
                    sortField: "age_to_liquidate",
                },
                {
                    name: "project_growth",
                    title: "Project Growth",
                    sortField: "project_growth",
                },
                {
                    name: "current_value",
                    title: "Current Value",
                    sortField: "current_value",
                },
            ],
            medical: {
                personal_medical: [
                    {
                        description:
                            "To have at least RM500,000 medical limit.",
                        total_amount: "500000",
                    },
                ],
            },
            critical_illness: {
                income_replacement: [
                    {
                        description:
                            "To replace 3x years basic living expenses.",
                        amount: "9000",
                        year: "3",
                        return_percent: "4.0",
                        inflation: "4.0",
                        total_amount: "324000",
                    },
                ],
                others: [
                    {
                        description:
                            "To hire a maid to take care the necessily.",
                        amount: "2000",
                        year: "3",
                        return_percent: "0",
                        inflation: "10.0",
                        total_amount: "79200",
                    },
                ],
            },
            death_tpd: {
                final_expenses: [
                    {
                        description: "To pay for final expenses.",
                        total_amount: "30000",
                    },
                ],
                parents_allowance: [
                    {
                        description: "RM1k/mth for mother till her age 80",
                        amount: "1000",
                        year: "16",
                        return_percent: "4.0",
                        inflation: "4.0",
                        total_amount: "192000",
                    },
                ],
                spouse_allowance: [
                    {
                        description: "RM1k/mth till youngest child age 25",
                        amount: "1000",
                        year: "23",
                        return_percent: "4.0",
                        inflation: "4.0",
                        total_amount: "276000",
                    },
                ],
                children_allowance: [
                    {
                        description: "Phak Jin: RM1k/mth till age 25",
                        amount: "1000",
                        year: "21",
                        return_percent: "4.0",
                        inflation: "4.0",
                        total_amount: "252000",
                    },
                    {
                        description: "Khai Jin: RM1k/mth till age 25",
                        amount: "1000",
                        year: "23",
                        return_percent: "4.0",
                        inflation: "4.0",
                        total_amount: "276000",
                    },
                ],
                children_education: [
                    {
                        description:
                            "Phak Jin: To have at least RM100000 at age 18",
                        total_amount: "100000",
                    },
                    {
                        description:
                            "Khai Jin: To have at least RM100000 at age 18",
                        total_amount: "100000",
                    },
                ],
                children_competition_capital: [],
                mortgage_loan: [
                    {
                        description: "PEN Jay Series (Own Stay)",
                        installment: "1800",
                        year: "25",
                        interest: "4.5",
                        total_amount: "300000",
                    },
                    {
                        description: "KUL Summer Suites",
                        installment: "1800",
                        year: "25",
                        interest: "4.5",
                        total_amount: "300000",
                    },
                ],
                car_loan: [
                    {
                        description: "Toyota Vios PPA 1234",
                        installment: "",
                        year: "",
                        interest: "",
                        total_amount: "30000",
                    },
                ],
                study_loan: [],
                credit_card: [],
                personal_loan: [],
                business_personal_guarantor_loan: [
                    {
                        description: "Toyota Vios PPA 1234",
                        installment: "",
                        year: "",
                        interest: "",
                        total_amount: "30000",
                    },
                ],
                other_loan: [],
                special_wish: [
                    {
                        description: "One-Off RM100k for dad.",
                        installment: "",
                        year: "",
                        interest: "",
                        total_amount: "100000",
                    },
                ],
            },
        }
    },
    methods: {
        navigationLink(tab) {
            this.$router.replace({
                path: "/my_contact/" + this.$route.params.id + "/edit/" + tab,
            })
            this.tab_index = tab
            if (tab == "summary") {
                this.$store.commit("updateViewState")
            }
        },
    },
    created() {
        this.tab_index = this.$route.params.tab
    },
}
</script>
