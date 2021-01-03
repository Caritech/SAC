<template>
    <div>
        <ul class="nav nav-pills justify-content-center">
            <li
                class="nav-item"
                v-for="type in ['existing','recommendation']"
            >
                <a
                    class="nav-link "
                    :class="{active:anchor==type}"
                    data-toggle="pill"
                    :href="'#'+type"
                    @click="setAnchor(type)"
                >{{capitalize(type)}}</a>
            </li>
            <li class="nav-item">
                <a
                    class="nav-link "
                    :class="{active:anchor=='total_benefit'}"
                    data-toggle="pill"
                    :href="'#total_benefit'"
                    @click="setAnchor('total_benefit')"
                >Total Benefit</a>
            </li>
        </ul>
        <div class="tab-content">
            <div
                v-for="type in ['existing','recommendation']"
                class="tab-pane container"
                :class="{active:anchor==type}"
                :id="type"
            >
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-10">
                                <span class="title-cyan">{{capitalize(type)}}</span>
                            </div>
                            <div class="col text-center">
                                <button
                                    class="btn btn-primary"
                                    @click="addInsurance(type,contact_id)"
                                >
                                    <i class="fas fa-plus "> Add</i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <my-vuetable
                            :api-url="'/vlife/get_contact_insurance/' + $route.params.id+'?insurance_type='+type"
                            :per-page="10"
                            :fields="getVuetableColumn(type)"
                            :ref="'myVuetable_'+type"
                            :transform="transformInsuranceData"
                        >
                            <template
                                slot="actions"
                                slot-scope="props"
                            >
                                <div
                                    v-if="props.rowData.id"
                                    class="text-right"
                                >
                                    <a
                                        class="btn btn-outline-success"
                                        :href="'/vlife/my_contact/insurance/'+props.rowData.id+'/edit'"
                                    >
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    <a
                                        v-if="props.rowData.insurance_type=='recommendation'"
                                        class="btn btn-outline-primary"
                                        @click="moveToExistingInsurance(props.rowData)"
                                    >
                                        <i class="fas  fa-arrow-left"></i>
                                    </a>
                                    <a
                                        class="btn btn-outline-primary"
                                        @click="deleteInsurance(props.rowData)"
                                    >
                                        <i class="fas fa-trash-alt"></i>
                                    </a>
                                </div>

                            </template>

                            <template
                                slot="checkbox"
                                slot-scope="props"
                                v-if="props.rowData.id"
                            >
                                <b-form-checkbox
                                    value="1"
                                    v-model="props.rowData.incl"
                                    @change="inclRecommendation($event,props.rowData)"
                                    size="lg"
                                ></b-form-checkbox>
                            </template>

                            <template
                                slot="plan_no_name"
                                slot-scope="props"
                            >
                                <div
                                    v-if="props.rowData.id"
                                    class=""
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
                                </div>
                                <div
                                    class="font-weight-bold text-right"
                                    v-else
                                >
                                    {{props.rowData.incept_mature}}
                                </div>

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
            <!-- Total Insurance-->
            <div
                class="tab-pane container"
                :class="{active:anchor=='total_benefit'}"
                id="total_benefit"
            >
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-10">
                                <span class="title-cyan">Total Benefit</span>
                            </div>
                            <div class="col text-center"></div>
                        </div>
                    </div>
                    <div class="card-body">
                        <my-vuetable
                            :api-url="'/vlife/get_contact_insurance/' + $route.params.id"
                            :per-page="10"
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

        </div>
    </div>
</template>

<script>
import mixinInsurance from "../../../../../Mixins/MyContact/insurance"
export default {
    mixins: [mixinInsurance],
    data() {
        return {
            contact_id: null,
            existing_insurance_fields: [
                {
                    name: "actions",
                    title: "Actions",
                },
                {
                    name: "plan_no_name",
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
            recommendation_insurance_fields: [
                {
                    name: "actions",
                    title: "Actions",
                },
                {
                    name: "checkbox",
                    title: "Inc.",
                },
                {
                    name: "plan_no_name",
                    title: "Insurer / Plan Name",
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
                    name: "premium_amount",
                    title: "Premium",
                    sortField: "premium_amount",
                },
            ],
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
        getVuetableColumn(type = "") {
            if (type == "existing") {
                return this.existing_insurance_fields
            } else {
                return this.recommendation_insurance_fields
            }
        },
        transformInsuranceData(datas) {
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
        checkEmpty(val) {
            if (!val) {
                val = "-"
            }
            return val
        },

        moveToExistingInsurance(data) {
            let id = data.id
            this.showConfirm(
                "Confirmation",
                "Confirm to change this recommendation to exisiting insurance ?",
                function () {
                    axios
                        .post(
                            "/vlife/my_contact/insurance/update_to_existing",
                            {
                                insurance_id: id,
                            }
                        )
                        .then((res) => {
                            location.reload()
                        })
                }
            )
        },
    },
    created() {
        this.id = this.$route.params.id
        this.contact_id = this.id

        let window_hash = window.location.hash
        let available_hash = ["#existing", "#recommendation"]
        if (available_hash.includes(window_hash)) {
            this.anchor = window.location.hash.replace("#", "")
        }

        if (!available_hash.includes(window_hash)) {
            this.anchor = "existing"
        }
    },
}
</script>
