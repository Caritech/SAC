<template>
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-md-10">
                    <span class="title-cyan">DEATH / TPD</span> - To sustain dependent(s) & payoff debt(s).
                </div>

                <div class="col-md-2">
                    <div class="btn btn-block btn-outline-primary disabled text-right btn-label">{{moneyFormat(TotalDeathTpd)}}</div>

                </div>
            </div>
        </div>

        <div class="card-body">
            <h5><strong>How much do you think is sufficient?</strong></h5>

            <!-- Follow Industry Standard -->
            <b-card v-if="NCPreference!=null">
                <my-checkbox
                    v-model="NCPreference.nc_death_tpd_follow"
                    @input="setBenchmarkAmount"
                >
                    Industry’s Recommendation (ROT - 5 years of annual income). ( {{ moneyFormat(VLifeSetting.nc_death_tpd) }} )
                </my-checkbox>
            </b-card>

            <hr>

            <div v-if="NCFollowBenchmark==0">
                <h5>I want</h5>
                <b-card
                    no-body
                    class="mb-4"
                    v-for="(type_data,death_tpd_type) in DeathTpdBreakdown"
                >
                    <!-- Start Header -->
                    <div class="card-header">
                        <h5 class="title-cyan">
                            <b-btn
                                size="sm"
                                variant="outline-primary"
                                class="float-left"
                                v-b-toggle="'collapse-death-tpd'+death_tpd_type"
                            >
                                <i class="fa fa-chevron-down"></i>
                            </b-btn>
                            <span class="ml-2">{{getName(death_tpd_type)}}</span>
                            <b-btn
                                size="sm"
                                variant="primary"
                                class="float-right"
                                @click="addField(death_tpd_type)"
                            >
                                <i class="fas fa-plus"></i> Add
                            </b-btn>
                        </h5>
                    </div>
                    <!-- End Header -->
                    <!-- Start Body loop-->
                    <b-collapse
                        visible
                        :id="'collapse-death-tpd'+death_tpd_type"
                    >
                        <table class="table table-bordered table-sm">
                            <tbody>
                                <template v-for="death_tpd in type_data">
                                    <NCIncputField
                                        v-if="death_tpd.deleted != 1"
                                        :props-form="death_tpd"
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
        VLifeSetting() {
            if (this.state.vlife_setting == null) return {}
            return this.state.vlife_setting
        },
        NCDeathTpdData() {
            let data = this.NCData.death_tpd
            return data
        },
        NCFollowBenchmark() {
            if (this.NCPreference == null) return 0
            return this.NCPreference.nc_death_tpd_follow
        },
        /* End of Renaming  */

        TotalDeathTpd() {
            let total = 0
            if (this.NCDeathTpdData == null) return "Pending Data"

            if (this.NCFollowBenchmark == 0) {
                this.NCDeathTpdData.forEach(function (v, k) {
                    let is_deleted = v.deleted ?? 0
                    if (!is_deleted) {
                        total += parseFloat(v.total_amount)
                    }
                })
            } else {
                total = this.NCPreference.nc_death_tpd
            }

            return total
        },
        DeathTpdBreakdown() {
            let breakdown = {
                final_expenses: [],
                estate_execution: [],
                parents_allowance: [],
                spouse_allowance: [],
                spouse_retirement: [],
                children_allowance: [],
                children_education: [],
                children_competition_capital: [],
                mortgage_loan: [],
                car_loan: [],
                study_loan: [],
                credit_card: [],
                personal_loan: [],
                business_loan: [],
                other_loan: [],
                special_wish: [],
            }
            if (this.NCDeathTpdData == null) return breakdown
            this.NCDeathTpdData.forEach(function (v, k) {
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
                nc_type: "death_tpd",
                nc_sub_type: nc_sub_type,
            }
            this.$store.dispatch("needs_calculator/addNCDataField", params)
        },
        deleteField(data) {
            let params = {
                nc_type: "death_tpd",
                data: data,
            }
            this.$store.commit("needs_calculator/setNCDataFieldDeleted", params)
        },
        saveNC() {
            this.$store.dispatch("needs_calculator/saveNC")
        },
        setBenchmarkAmount() {
            let params = {
                nc_type: "nc_death_tpd",
            }
            this.$store.commit("needs_calculator/setNCFollowBenchmark", params)
        },
    },
    created() {
        this.id = this.$route.params.id
    },
}
</script>