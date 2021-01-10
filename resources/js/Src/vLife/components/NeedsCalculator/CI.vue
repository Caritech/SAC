<template>
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-md-10">
                    <span class="title-cyan">CRITICAL ILLNESS</span> - To replace income to maintain lifestyle & basic living..
                </div>

                <div class="col-md-2">
                    <div class="btn btn-block btn-outline-primary disabled text-right btn-label">{{moneyFormat(TotalCI)}}</div>

                </div>
            </div>
        </div>

        <div class="card-body">
            <h5><strong>How much do you think is sufficient?</strong></h5>

            <!-- Follow Industry Standard -->
            <b-card v-if="NCPreference!=null">
                <my-checkbox
                    v-model="NCPreference.nc_critical_illness_follow"
                    @input="setBenchmarkAmount"
                >
                    Industry’s Recommendation (ROT - 5 years of annual income). ( {{ moneyFormat(IndustryRecommendation.critical_illness) }} )
                </my-checkbox>
            </b-card>

            <hr>

            <div>
                <h5>I want</h5>
                {{CIBreakdown}}
                <b-card
                    no-body
                    class="mb-4"
                    v-for="(type_data,ci_type) in CIBreakdown"
                    :key="ci_type"
                >

                    <!-- Start Header -->
                    <div class="card-header">
                        <h5 class="title-cyan">
                            <b-btn
                                size="sm"
                                variant="outline-primary"
                                class="float-left"
                                v-b-toggle="'collapse-ci'+ci_type"
                            >
                                <i class="fa fa-chevron-down"></i>
                            </b-btn>
                            <span class="ml-2">{{getName(ci_type)}}</span>
                            <b-btn
                                size="sm"
                                variant="primary"
                                class="float-right"
                                @click="addField(ci_type)"
                            >
                                <i class="fas fa-plus"></i> Add
                            </b-btn>
                        </h5>
                    </div>
                    <!-- End Header -->
                    <!-- Start Body loop-->
                    <b-collapse
                        visible
                        :id="'collapse-ci'+ci_type"
                    >
                        <table class="table table-bordered table-sm">
                            <tbody>
                                <template v-for="ci in type_data">
                                    <NCIncputField
                                        v-if="ci.deleted != 1"
                                        :props-form="ci"
                                        @delete-field="deleteField"
                                    ></NCIncputField>
                                </template>
                            </tbody>
                        </table>

                    </b-collapse>
                    <!-- End Body loop-->

                </b-card>

            </div>
            <div class=" text-right">
                <button
                    class="btn btn-success"
                    @click="saveNC"
                >
                    <i class="fa fa-save"></i>
                    Save
                </button>

            </div>

        </div>
    </div>
</template>

<script>
import MixinNeedsCalculator from "../../../../Mixins/MyContact/needs_calculator"
import NCIncputField from "../NeedsCalculator/NCInputField"

export default {
    mixins: [MixinNeedsCalculator],
    components: { NCIncputField },
    computed: {
        /* Start Renaming  */
        state() {
            return this.$store.state.needs_calculator
        },
        NCData() {
            return this.state.nc_data
        },
        NCPreference() {
            if (this.NCData == null) return {}
            return this.NCData.preference
        },
        IndustryRecommendation() {
            if (this.state.industry_recommendation == null) return {}
            return this.state.industry_recommendation
        },
        NCCIData() {
            let data = this.NCData.critical_illness
            return data
        },
        NCFollowBenchmark() {
            if (this.NCPreference == null) return 0
            return this.NCPreference.nc_critical_illness_follow
        },
        /* End of Renaming  */

        TotalCI() {
            let total = 0
            if (this.NCCIData == null) return "Pending Data"

            this.NCCIData.forEach(function (v, k) {
                let is_deleted = v.deleted ?? 0
                if (!is_deleted) {
                    total += parseFloat(v.total_amount)
                }
            })

            return total
        },
        CIBreakdown() {
            let breakdown = {
                income_replacement: [],
                others: [],
            }
            if (this.NCCIData == null) return breakdown
            this.NCCIData.forEach(function (v, k) {
                let type = v.type
                if (breakdown[type] == null) {
                    breakdown[type] = []
                }

                breakdown[type].push(v)
            })
            return breakdown
        },
    },
    methods: {
        addField(nc_sub_type) {
            let params = {
                nc_type: "critical_illness",
                nc_sub_type: nc_sub_type,
            }
            this.$store.dispatch("needs_calculator/addNCDataField", params)
        },
        deleteField(data) {
            let params = {
                nc_type: "critical_illness",
                data: data,
            }
            this.$store.commit("needs_calculator/setNCDataFieldDeleted", params)
        },
        saveNC() {
            this.$store.dispatch("needs_calculator/saveNC")
        },
        setBenchmarkAmount(event) {
            if (event == 1) {
                let params = {
                    nc_type: "critical_illness",
                }
                this.$store.dispatch(
                    "needs_calculator/onChangeNCFollowBenchmark",
                    params
                )
            }
        },
    },
    created() {
        this.id = this.$route.params.id
    },
}
</script>