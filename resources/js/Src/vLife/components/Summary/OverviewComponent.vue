<template>
    <div class="">
        <h1 class="title-cyan">Overview</h1>

        <!--  Income-->
        <div class="card mb-4">
            <div class="card-body">
                <h2 class="text-center font-weight-bold">Income</h2>
                <div class="row">
                    <div class="col">
                        <IncomeChart :setting="incomePieChartData"></IncomeChart>
                    </div>
                    <div class="col">

                        <table class="table table-hover table-striped h4">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Type</th>
                                    <th class="text-right">Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(income,income_type) in income_data">
                                    <td class="fit"><span :style="'display:inline-block;margin-right:5px;width:20px;height:20px;background:'+income.color"></span></td>
                                    <td>{{income_type}}</td>
                                    <td align="right">{{moneyFormat(income.amount)}}</td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td class="font-weight-bold">Total</td>
                                    <td align="right">
                                        <b>{{ moneyFormat(incomeDataTotal.amount)}}</b><br>
                                        <i>({{moneyFormat(incomeDataTotal.monthly_amount)}} monthly)</i>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                </div>
                <ProgressBar :data="incomeProgressBarData"></ProgressBar>
            </div>
        </div>
        <!--  ./ Income-->

        <!--  Asset & Investment-->
        <div class="card mb-4">
            <div class="card-body">
                <h2 class="text-center font-weight-bold">Asset & Investment</h2>
                <div class="row">
                    <div class="col">
                        <IncomeChart :setting="assetsInvestmentPieChartData"></IncomeChart>
                    </div>
                    <div class="col">

                        <table class="table table-hover table-striped h4">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Type</th>
                                    <th class="text-right">Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(d,type) in assets_investment_data">
                                    <td class="fit"><span :style="'display:inline-block;margin-right:5px;width:20px;height:20px;background:'+d.color"></span></td>
                                    <td>{{type}}</td>
                                    <td align="right">{{moneyFormat(d.amount)}}</td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td class="font-weight-bold">Total</td>
                                    <td align="right">
                                        <b>{{ moneyFormat(assetsInvestmentDataTotal.amount)}}</b><br>
                                        <i>({{moneyFormat(assetsInvestmentDataTotal.monthly_amount)}} monthly)</i>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                </div>
                <ProgressBar :data="assetsInvestmentProgressBarData"></ProgressBar>
            </div>
        </div>
        <!--  ./ Asset & Investment-->

        <!--  Insurance Policy Summary-->
        <div class="card mb-4">
            <div class="card-body">
                <h2 class="text-center font-weight-bold">
                    Insurance Policy Summary
                </h2>
                <div class="row">
                    <div class="col">
                        <AgeLineChart
                            :setting="insuranceLineChartSetting"
                            :chartKey="chartKey"
                        ></AgeLineChart>
                    </div>

                </div>
            </div>
        </div>
        <!--  ./ <!--  Insurance Policy Summary-->

        <!--  Insurance Policy Summary-->
        <div class="card mb-4">
            <div class="card-body">
                <h2 class="text-center font-weight-bold">
                    Premium
                </h2>
                <div class="row">
                    <div class="col">
                        <AgeLineChart
                            :setting="premiumLineChartSetting"
                            :chartKey="chartKey"
                        ></AgeLineChart>
                    </div>

                </div>
            </div>
        </div>
        <!--  ./ <!--  Insurance Policy Summary-->

    </div>
</template>
<script>
import IncomeChart from "./Chart/IncomeChart"
import AgeLineChart from "./Chart/AgeLineChart"
import ProgressBar from "../Misc/ProgressBar"
export default {
    components: { IncomeChart, AgeLineChart, ProgressBar },
    data() {
        return {
            contact_id: null,
            chart_key: null,
            income_data: [],
            assets_investment_data: [],
            insurance_policy_summary_data: [],
            insurance_policy_premium_data: [],
        }
    },
    computed: {
        chartKey() {
            return this.$store.state.view_state
        },
        //INCOME
        incomePieChartData() {
            let label = []
            let color = []
            let amount = []

            for (let key in this.income_data) {
                let data = this.income_data[key]
                label.push(key)
                color.push(data.color)
                amount.push(data.amount)
            }

            return {
                color: color,
                label: label,
                data: amount,
            }
        },
        incomeDataTotal() {
            let total = {
                title: "Total",
                amount: 0,
                monthly_amount: 0,
            }
            for (let key in this.income_data) {
                let data = this.income_data[key]
                total.amount += parseFloat(data.amount)
            }
            total.monthly_amount = total.amount / 12
            return total
        },
        incomeProgressBarData() {
            let result = [
                { title: "Active", value: 0 },
                { title: "Passive", value: 0 },
            ]

            for (let key in this.income_data) {
                let data = this.income_data[key]
                if (["Gross Income", "Rental"].includes(key)) {
                    result[0].value += parseFloat(data.amount)
                } else {
                    result[1].value += parseFloat(data.amount)
                }
            }

            return result
        },

        //END OF INCOMCE

        //ASSets IOnvestment
        assetsInvestmentPieChartData() {
            let label = []
            let color = []
            let amount = []

            for (let key in this.assets_investment_data) {
                let data = this.assets_investment_data[key]
                label.push(key)
                color.push(data.color)
                amount.push(data.amount)
            }

            return {
                color: color,
                label: label,
                data: amount,
            }
        },
        assetsInvestmentDataTotal() {
            let total = {
                title: "Total",
                amount: 0,
                monthly_amount: 0,
            }
            for (let key in this.assets_investment_data) {
                let data = this.assets_investment_data[key]
                total.amount += parseFloat(data.amount)
            }
            total.monthly_amount = total.amount / 12
            return total
        },
        assetsInvestmentProgressBarData() {
            let result = [
                { title: "Probate", value: 0 },
                { title: "Non-Probate", value: 0 },
            ]

            for (let key in this.assets_investment_data) {
                let data = this.assets_investment_data[key]
                if (["Property", "EPF", "Unit Trust"].includes(key)) {
                    result[0].value += parseFloat(data.amount)
                } else {
                    result[1].value += parseFloat(data.amount)
                }
            }

            return result
        },
        //END ASSets IOnvestment

        insuranceLineChartSetting() {
            let label = []
            let i = 0
            for (let k in this.insurance_policy_summary_data) {
                let data = this.insurance_policy_summary_data[k]
                let items = data.items
                let values = []

                for (let item_key in items) {
                    if (i == 0) {
                        label.push(item_key)
                    }
                    values.push(items[item_key].amount / 1000)
                }
                this.insurance_policy_summary_data[k].values = values
                i++
            }
            return {
                xLabel: "Age",
                yLabel: "SumAssured('000)",
                label: label,
                dataSet: this.insurance_policy_summary_data,
            }
        },
        premiumLineChartSetting() {
            let label = []
            let i = 0
            for (let k in this.insurance_policy_premium_data) {
                let data = this.insurance_policy_premium_data[k]
                let items = data.items
                let values = []

                for (let item_key in items) {
                    if (i == 0) {
                        label.push(item_key)
                    }
                    values.push(items[item_key].amount)
                }
                this.insurance_policy_premium_data[k].values = values
                i++
            }
            return {
                xLabel: "Age",
                yLabel: "Premium",
                label: label,
                dataSet: this.insurance_policy_premium_data,
                suggestedMax: 12000,
                stepSize: 2000,
            }
        },
    },
    methods: {
        getIncome() {
            axios
                .get("/vlife/my_contact/summary/get_income_by_type", {
                    params: {
                        contact_id: this.contact_id,
                    },
                })
                .then((res) => {
                    this.income_data = res.data
                })
        },
        getAssetsInvestment() {
            axios
                .get(
                    "/vlife/my_contact/summary/get_assets_investment_by_type",
                    {
                        params: {
                            contact_id: this.contact_id,
                        },
                    }
                )
                .then((res) => {
                    this.assets_investment_data = res.data
                })
        },
        getInsurancePolicySummary() {
            axios
                .get("/vlife/my_contact/summary/get_insurance_policy_summary", {
                    params: {
                        contact_id: this.contact_id,
                    },
                })
                .then((res) => {
                    this.insurance_policy_summary_data = res.data
                })
        },
        getInsurancePolicyInsurance() {
            axios
                .get("/vlife/my_contact/summary/get_insurance_policy_premium", {
                    params: {
                        contact_id: this.contact_id,
                    },
                })
                .then((res) => {
                    this.insurance_policy_premium_data = res.data
                })
        },
    },
    created() {
        let contact_id = this.$route.params.id
        this.contact_id = contact_id
        this.getIncome()
        this.getAssetsInvestment()
        this.getInsurancePolicySummary()
        this.getInsurancePolicyInsurance()
    },
}
</script>