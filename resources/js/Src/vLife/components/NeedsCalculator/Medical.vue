<template>
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-md-10">
                    <span class="title-cyan">MEDICAL</span> - To pay for unforeseen medical bill(s).
                </div>

                <div class="col-md-2">
                    <div class="btn btn-block btn-outline-primary disabled text-right btn-label">{{moneyFormat(TotalMedical)}}</div>

                </div>
            </div>
        </div>

        <div class="card-body">
            <h5><strong>How much do you think is sufficient?</strong></h5>

            <!-- Follow Industry Standard -->
            <b-card v-if="NCPreference!=null">
                <my-checkbox
                    v-model="NCPreference.medical_follow"
                    @input="setBenchmarkAmount"
                >
                    Follow the recommended industry minimum benchmark ( {{ moneyFormat(IndustryRecommendation.medical) }} )
                </my-checkbox>
            </b-card>

            <hr>

            <div v-if="NCPreference!=null && NCPreference.medical_follow == 0">
                <h5>I want</h5>
                <b-card
                    v-for="(type_data,medical_type) in MedicalBreakdown"
                    no-body
                    class="mb-4"
                    :key="medical_type"
                >

                    <!-- Start Header -->
                    <div class="card-header">
                        <h5 class="title-cyan">
                            <b-btn
                                size="sm"
                                variant="outline-primary"
                                class="float-left"
                                @click="toggleCollapse(medical_type)"
                            >
                                <i
                                    class="fa"
                                    :class="{
                                        'fa-chevron-down':!collapse_medical[medical_type],
                                        'fa-chevron-up':collapse_medical[medical_type],
                                    }"
                                ></i>
                            </b-btn>
                            <span class="ml-2">{{geTypeNameByTypeCode(medical_type)}}</span>
                            <b-btn
                                size="sm"
                                variant="primary"
                                class="float-right"
                                @click="addField('medical',medical_type)"
                            >
                                <i class="fas fa-plus"></i> Add
                            </b-btn>
                        </h5>
                    </div>
                    <!-- End Header -->
                    <!-- Start Body loop-->
                    <b-collapse :visible="collapse_medical[medical_type]">
                        <table class="table table-bordered table-sm">
                            <tbody>
                                <template v-for="(medical,medical_index) in type_data">
                                    <NCIncputField
                                        :key="medical_index"
                                        v-if="medical.deleted != 1"
                                        :props-form="medical"
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
    data() {
        return {
            collapse_medical: {},
        }
    },
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
        NCMedicalData() {
            let data = this.NCData.medical
            return data
        },
        NCFollowBenchmark() {
            if (this.NCPreference == null) return 0
            return this.NCPreference.medical_follow
        },
        /* End of Renaming  */

        TotalMedical() {
            let total = 0
            if (this.NCMedicalData == null) return "Pending Data"

            if (this.NCPreference.medical_follow == 1) {
                total = this.NCPreference.medical
            } else {
                this.NCMedicalData.forEach(function (v, k) {
                    let is_deleted = v.deleted ?? 0
                    if (!is_deleted) {
                        total += parseFloat(v.total_amount)
                    }
                })
            }

            return total
        },
        MedicalBreakdown() {
            let breakdown = {
                personal_medical: [],
            }
            if (this.NCMedicalData == null) return breakdown
            this.NCMedicalData.forEach(function (v, k) {
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
        toggleCollapse(v) {
            this.collapse_medical[v] = !this.collapse_medical[v]
        },
        addField(nc_type, nc_sub_type) {
            let params = {
                nc_type: nc_type,
                nc_sub_type: nc_sub_type,
            }
            this.$store.dispatch("needs_calculator/addNCDataField", params)
        },
        deleteField(data) {
            let params = {
                nc_type: "medical",
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
                    nc_type: "medical",
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

        for (let index in this.MedicalBreakdown) {
            this.$set(this.collapse_medical, index, true)
        }
    },
}
</script>