<template>
    <div>

    <h1 class="title-cyan">Insurance Policy Summary</h1>
            <!-- Total Insurance-->
        
                <div class="card">
                    <div class="card-body">
                        <my-vuetable
                            :api-url="'/vlife/get_contact_insurance/' + $route.params.id"
                            :per-page="50"
                            :fields="total_benefit_insurance_fields"
                            ref="myVuetable_total_benefit"
                            :transform="transformTotalBenefit"
                        >
                            <template
                                slot="policy_no_plan_name"
                                slot-scope="props"
                            >
                                <template v-if="props.rowData.insurance_type=='existing'">
                                    <span class="font-weight-bold">
                                        {{props.rowData.policy_no}}
                                    </span><br>
                                    {{props.rowData.plan_name}}
                                </template>
                                <template v-if="props.rowData.insurance_type=='recommendation'">
                                    <span class="font-weight-bold">
                                        {{props.rowData.insurer}}
                                    </span><br>
                                    {{props.rowData.plan_name}}
                                </template>
                            </template>
                            <template
                                slot="incept_mature"
                                slot-scope="props"
                            >
                                <div
                                    v-if="props.rowData.id"
                                    class="text-right"
                                >
                                    {{props.rowData.start_age}}/{{props.rowData.maturity_age}}
                                </div>
                                <div
                                    class="font-weight-bold text-right"
                                    v-else
                                >
                                    {{props.rowData.incept_mature}}
                                </div>

                            </template>
                            <template
                                slot="sum_death_tpd"
                                slot-scope="props"
                            >
                                <div
                                    v-if="props.rowData.id"
                                    class="text-right"
                                >
                                    {{moneyFormat(props.rowData.sum_death_tpd)}}
                                </div>
                                <div
                                    class="font-weight-bold text-right"
                                    v-else
                                >
                                    {{moneyFormat(props.rowData.sum_death_tpd)}}
                                </div>

                            </template>
                            <template
                                slot="sum_critical_illness"
                                slot-scope="props"
                            >
                                <div
                                    v-if="props.rowData.id"
                                    class="text-right"
                                >
                                    {{moneyFormat(props.rowData.sum_critical_illness)}}
                                </div>
                                <div
                                    class="font-weight-bold text-right"
                                    v-else
                                >
                                    {{moneyFormat(props.rowData.sum_critical_illness)}}
                                </div>
                            </template>
                            <template
                                slot="sum_accidental_dealth_tpd"
                                slot-scope="props"
                            >
                                <div
                                    v-if="props.rowData.id"
                                    class="text-right"
                                >
                                    {{moneyFormat(props.rowData.sum_accidental_dealth_tpd)}}
                                </div>
                                <div
                                    class="font-weight-bold text-right"
                                    v-else
                                >
                                    {{moneyFormat(props.rowData.sum_accidental_dealth_tpd)}}
                                </div>
                            </template>
                            <template
                                slot="medical_benefit_annual_limit"
                                slot-scope="props"
                            >
                                <div
                                    v-if="props.rowData.id"
                                    class="text-right"
                                >
                                    {{moneyFormat(props.rowData.medical_benefit_annual_limit)}}
                                </div>
                                <div
                                    class="font-weight-bold text-right"
                                    v-else
                                >
                                    {{moneyFormat(props.rowData.medical_benefit_annual_limit)}}
                                </div>
                            </template>
                            <template
                                slot="premium_amount"
                                slot-scope="props"
                            >
                                <div
                                    v-if="props.rowData.id"
                                    class="text-right"
                                >
                                    {{moneyFormat(props.rowData.premium_amount)}}
                                </div>
                                <div
                                    class="font-weight-bold text-right"
                                    v-else
                                >
                                    {{moneyFormat(props.rowData.premium_amount)}}
                                </div>
                            </template>

                        </my-vuetable>
                    </div>
                </div>
            

      
    </div>
</template>

<script>
export default {
    data() {
        return {
            total_benefit_insurance_fields: [
                {
                    name: "policy_no_plan_name",
                    title: "Policy No / Plan Name",
                },
                {
                    name: "incept_mature",
                    title: "Incept / Mature",
                },
                {
                    name: "sum_death_tpd",
                    title: "Death / TPD",
                    sortField: "sum_death_tpd",
                },
                {
                    name: "sum_critical_illness",
                    title: "Critical Illness",
                    sortField: "sum_critical_illness",
                },
                {
                    name: "sum_accidental_dealth_tpd",
                    title: "Accidental Death / TPD",
                    sortField: "sum_accidental_dealth_tpd",
                },

                {
                    name: "medical_benefit_annual_limit",
                    title: "Medical",
                    sortField: "medical_benefit_annual_limit",
                },
                {
                    name: "premium_status",
                    title: "Status",
                    sortField: "premium_status",
                },
                {
                    name: "premium_amount",
                    title: "Premium",
                    sortField: "premium_amount",
                },
            ],
            anchor: null,
        }
    },
    methods: {
       
      
        transformTotalBenefit(datas) {
            var transformed = datas
            var cur_data = datas.data
            var sum_death_tpd = 0,
                sum_critical_illness = 0,
                sum_accidental_death_tpd = 0,
                medical_benefit_annual_limit = 0,
                premium_amount = 0

            for (var i = 0; i < cur_data.length; i++) {
                sum_death_tpd += this.castNum(cur_data[i].sum_death_tpd)
                sum_critical_illness += this.castNum(
                    cur_data[i].sum_critical_illness
                )
                sum_accidental_death_tpd += this.castNum(
                    cur_data[i].sum_accidental_death_tpd
                )

                medical_benefit_annual_limit += this.castNum(
                    cur_data[i].medical_benefit_annual_limit
                )

                premium_amount += this.castNum(cur_data[i].premium_amount)
            }

            transformed.data.push({
                incept_mature: "Total",
                sum_death_tpd: sum_death_tpd,
                sum_critical_illness: sum_critical_illness,
                sum_accidental_death_tpd: sum_accidental_death_tpd,
                medical_benefit_annual_limit: medical_benefit_annual_limit,
                premium_amount: premium_amount,
            })

            return transformed
        },
       

      
    },
    created() {
        var vm = this
        vm.id = vm.$route.params.id


        
    },
}
</script>
