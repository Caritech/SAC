<template>
    <div>
        <div class="row">
            <div class="col-md-12">
                <div class="mb-2">
                    <b-btn @click="redirectBack">Back</b-btn>
                </div>
                <div class="card card-primary">
                    <div class="card-header">{{pageTitle}}</div>
                    <div class="card-body">
                        <!-- Insurance Info -->
                        <div class="card mb-4">
                            <div class="card-body">
                                <h3>Insurance Info</h3>
                                <my-form-group
                                    title="Insurer"
                                    divCol="12"
                                >
                                    <input
                                        type="text"
                                        class="form-control"
                                        v-model="form.insurer"
                                    />
                                </my-form-group>

                                <my-form-group
                                    v-if="form.insurance_type =='existing'"
                                    title="Policy No."
                                    divCol="12"
                                >
                                    <input
                                        type="text"
                                        class="form-control"
                                        v-model="form.policy_no"
                                    />
                                </my-form-group>

                                <my-form-group
                                    v-if="form.insurance_type =='recommendation'"
                                    title="Recommendation No."
                                    divCol="12"
                                >
                                    <input
                                        type="text"
                                        class="form-control"
                                        v-model="form.recommendation_no"
                                    />
                                </my-form-group>

                                <my-form-group
                                    title="Life Assured"
                                    divCol="12"
                                >
                                    <my-select
                                        :items="dropdown.insurance_assured"
                                        v-model="form.life_assured"
                                    />
                                </my-form-group>

                                <my-form-group
                                    title="Plan Name"
                                    divCol="12"
                                >
                                    <input
                                        type="text"
                                        class="form-control"
                                        v-model="form.plan_name"
                                    />
                                </my-form-group>

                                <!-- Date -->
                                <div class="row">
                                    <div class="col">
                                        <my-form-group
                                            title="Start Date"
                                            divCol="12"
                                        >
                                            <my-datepicker
                                                size="md"
                                                v-model="form.start_date"
                                                @input="calInsuranceAge('start')"
                                            />
                                        </my-form-group>
                                    </div>
                                    <div class="col">
                                        <my-form-group
                                            title="Maturity Date"
                                            divCol="12"
                                        >
                                            <my-datepicker
                                                size="md"
                                                v-model="form.maturity_date"
                                                @input="calInsuranceAge('maturity')"
                                            />
                                        </my-form-group>
                                    </div>
                                </div>
                                <!-- /. Date -->

                                <!-- Age -->
                                <div class="row">
                                    <div class="col">
                                        <my-form-group
                                            title="Start Age"
                                            divCol="12"
                                        >
                                            <input
                                                type="text"
                                                class="form-control"
                                                readonly
                                                v-model="form.start_age"
                                            />
                                        </my-form-group>
                                    </div>
                                    <div class="col">
                                        <my-form-group
                                            title="Maturity Age"
                                            divCol="12"
                                        >
                                            <input
                                                type="text"
                                                class="form-control"
                                                readonly
                                                v-model="form.maturity_age"
                                            />
                                        </my-form-group>
                                    </div>
                                </div>
                                <!-- /. Age -->

                                <!-- Plan Type -->
                                <my-form-group
                                    title="Plan Type"
                                    divCol="12"
                                >
                                    <my-select
                                        :items="dropdown.insurance_plan_type"
                                        v-model="form.plan_type"
                                    />
                                </my-form-group>
                                <!-- ./Plan Type -->

                                <!-- Coverage Type -->
                                <table class="table table-sm table-hover table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th class="text-center">
                                                <b-btn
                                                    size="sm"
                                                    variant="success"
                                                    @click="addCoverage"
                                                >
                                                    <i class="fa fa-plus"></i>
                                                </b-btn>
                                            </th>
                                            <th>Coverage Type</th>
                                            <th>Coverage Age From</th>
                                            <th>Coverage Age To</th>
                                            <th>Frequency</th>
                                            <th>Sum Assured</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr
                                            v-for="coverage in form.coverage"
                                            v-if="!coverage.deleted"
                                        >
                                            <td align=center>
                                                <b-btn
                                                    size="sm"
                                                    variant="danger"
                                                    @click="deleteCoverage(coverage)"
                                                >
                                                    <i class="fa fa-trash"></i>
                                                </b-btn>
                                            </td>
                                            <td>
                                                <my-select
                                                    :items="dropdown.coverage_type"
                                                    v-model="coverage.coverage_type"
                                                />
                                            </td>
                                            <td><input
                                                    class="form-control"
                                                    v-model="coverage.coverage_age_from"
                                                ></td>
                                            <td><input
                                                    class="form-control"
                                                    v-model="coverage.coverage_age_to"
                                                ></td>
                                            <td>
                                                <my-select
                                                    :items="dropdown.coverage_frequency"
                                                    v-model="coverage.frequency"
                                                />
                                            </td>
                                            <td>
                                                <VueNumeric
                                                    currency="$"
                                                    separator=","
                                                    v-model="coverage.sum_assured"
                                                    class="form-control text-right"
                                                ></VueNumeric>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <!-- ./ Coverage Type -->

                            </div>
                        </div>
                        <!-- ./Insurance Info -->

                        <!-- Medical Benefit -->
                        <div class="card mb-4">
                            <div class="card-body">
                                <h3>Medical Benefit</h3>
                                <my-form-group
                                    title="Medical Benefit"
                                    divCol="6"
                                    labelCol="4"
                                    inputCol="8"
                                >
                                    <input
                                        type="checkbox"
                                        class="form-control"
                                        v-model="form.chk_medical_benefit"
                                    />
                                </my-form-group>
                                <!-- Medical Benefit Input-->
                                <template v-if="form.chk_medical_benefit==1">
                                    <my-form-group
                                        title="Room & Board Rate"
                                        divCol="12"
                                    >
                                        <VueNumeric
                                            currency="$"
                                            separator=","
                                            v-model="form.medical_benefit_room_board_rate"
                                            class="form-control "
                                        ></VueNumeric>
                                    </my-form-group>
                                    <my-form-group
                                        title="Annual Limit"
                                        divCol="12"
                                    >
                                        <VueNumeric
                                            currency="$"
                                            separator=","
                                            v-model="form.medical_benefit_annual_limit"
                                            class="form-control "
                                        ></VueNumeric>
                                    </my-form-group>
                                    <my-form-group
                                        title="Lifetime Limit"
                                        divCol="12"
                                    >
                                        <VueNumeric
                                            currency="$"
                                            separator=","
                                            v-model="form.medical_benefit_lifetime_limit"
                                            class="form-control "
                                        ></VueNumeric>
                                    </my-form-group>
                                    <my-form-group
                                        title="Co-Insurance"
                                        divCol="12"
                                    >
                                        <input
                                            type="text"
                                            class="form-control"
                                            v-model="form.medical_benefit_co_insurance"
                                        />
                                    </my-form-group>
                                    <div class="row">
                                        <div class="col">
                                            <my-form-group
                                                title="Start Date"
                                                divCol="12"
                                            >
                                                <my-datepicker
                                                    size="md"
                                                    v-model="form.medical_benefit_start_date"
                                                    @input="calMedicalAge('start')"
                                                />
                                            </my-form-group>
                                        </div>
                                        <div class="col">
                                            <my-form-group
                                                title="Maturity Date"
                                                divCol="12"
                                            >
                                                <my-datepicker
                                                    size="md"
                                                    v-model="form.medical_benefit_maturity_date"
                                                    @input="calMedicalAge('maturity')"
                                                />
                                            </my-form-group>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <my-form-group
                                                title="Start Age"
                                                divCol="12"
                                            >
                                                <input
                                                    type="text"
                                                    class="form-control"
                                                    readonly
                                                    v-model="form.medical_benefit_start_age"
                                                />
                                            </my-form-group>
                                        </div>
                                        <div class="col">
                                            <my-form-group
                                                title="Maturity Age"
                                                divCol="12"
                                            >
                                                <input
                                                    type="text"
                                                    class="form-control"
                                                    readonly
                                                    v-model="form.medical_benefit_maturity_age"
                                                />
                                            </my-form-group>
                                        </div>
                                    </div>
                                    <my-form-group
                                        title="Remarks"
                                        divCol="12"
                                    >
                                        <input
                                            type="text"
                                            class="form-control"
                                            v-model="form.medical_benefit_remarks"
                                        />
                                    </my-form-group>
                                </template>
                                <!-- ./Medical Benefit Input-->

                            </div>
                        </div>
                        <!-- ./ Medical Benefit -->

                        <!-- Premium -->
                        <div class="card mb-4">
                            <div class="card-body">
                                <h3>Premium</h3>
                                <my-form-group
                                    title="Premium Amount"
                                    divCol="12"
                                >

                                    <VueNumeric
                                        currency="$"
                                        separator=","
                                        v-model="form.premium_amount"
                                        class="form-control "
                                    ></VueNumeric>

                                </my-form-group>
                                <my-form-group
                                    v-if="form.insurance_type == 'existing'"
                                    title="Premium Status"
                                    divCol="12"
                                >
                                    <my-select
                                        :items="dropdown.premium_status"
                                        v-model="form.premium_status"
                                    />
                                </my-form-group>
                                <my-form-group
                                    title="Frequency Increment"
                                    divCol="12"
                                >
                                    <my-select
                                        :items="dropdown.premium_frequency"
                                        v-model="form.premium_frequency_increment"
                                    />
                                </my-form-group>
                                <div class="row">
                                    <div class="col">
                                        <my-form-group
                                            title="Start Date"
                                            divCol="12"
                                        >
                                            <my-datepicker
                                                size="md"
                                                v-model="form.premium_start_date"
                                                @input="calPremiumAge('start')"
                                            />
                                        </my-form-group>
                                    </div>
                                    <div class="col">
                                        <my-form-group
                                            title="Maturity Date"
                                            divCol="12"
                                        >
                                            <my-datepicker
                                                size="md"
                                                v-model="form.premium_maturity_date"
                                                @input="calPremiumAge('maturity')"
                                            />
                                        </my-form-group>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <my-form-group
                                            title="Start Age"
                                            divCol="12"
                                        >
                                            <input
                                                type="text"
                                                class="form-control"
                                                readonly
                                                v-model="form.premium_start_age"
                                            />
                                        </my-form-group>
                                    </div>
                                    <div class="col">
                                        <my-form-group
                                            title="Maturity Age"
                                            divCol="12"
                                        >
                                            <input
                                                type="text"
                                                class="form-control"
                                                readonly
                                                v-model="form.premium_maturity_age"
                                            />
                                        </my-form-group>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- ./Premium -->

                        <!-- Insurance Benefits -->
                        <div class="card mb-4">
                            <div class="card-body">
                                <h3>Benefits</h3>

                                <!-- Coverage Type -->
                                <table class="table table-sm table-hover table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th class="text-center">
                                                <b-btn
                                                    size="sm"
                                                    variant="success"
                                                    @click="addProjectedBenefit"
                                                >
                                                    <i class="fa fa-plus"></i>
                                                </b-btn>
                                            </th>
                                            <th>Projected Cash/Inv./Sur./Mat. Value</th>
                                            <th>Frequency</th>
                                            <th>Age From</th>
                                            <th>Age To</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr
                                            v-for="projected_benefit in form.projected_benefit"
                                            v-if="!projected_benefit.deleted"
                                        >
                                            <td align=center>
                                                <b-btn
                                                    size="sm"
                                                    variant="danger"
                                                    @click="deleteProjectedBenefit(projected_benefit)"
                                                >
                                                    <i class="fa fa-trash"></i>
                                                </b-btn>
                                            </td>
                                            <td>

                                                <VueNumeric
                                                    currency="$"
                                                    separator=","
                                                    v-model="projected_benefit.projected_value"
                                                    class="form-control "
                                                ></VueNumeric>

                                            </td>
                                            <td>
                                                <my-select
                                                    :items="dropdown.coverage_frequency"
                                                    v-model="projected_benefit.frequency"
                                                />
                                            </td>
                                            <td><input
                                                    class="form-control"
                                                    v-model="projected_benefit.age_from"
                                                ></td>
                                            <td><input
                                                    class="form-control"
                                                    v-model="projected_benefit.age_to"
                                                ></td>
                                        </tr>
                                    </tbody>
                                </table>
                                <!-- ./ Coverage Type -->

                            </div>
                        </div>
                        <!-- ./Insurance Benefits -->

                        <!-- Nomination -->
                        <div
                            class="card mb-4"
                            v-if="form.insurance_type == 'existing'"
                        >
                            <div class="card-body">
                                <h3>Nomination</h3>
                                <my-form-group
                                    title="Nomination Name"
                                    divCol="12"
                                >
                                    <input
                                        type="text"
                                        class="form-control"
                                        v-model="form.nomination_name"
                                    />
                                </my-form-group>
                                <my-form-group
                                    title="Nomination Relationship"
                                    divCol="12"
                                >
                                    <my-select
                                        :items="dropdown.relationship"
                                        v-model="form.nomination_relationship"
                                    />
                                </my-form-group>
                                <my-form-group
                                    title="
                                        Nomination
                                        Percentage"
                                    divCol="12"
                                >
                                    <input
                                        type="text"
                                        class="form-control"
                                        v-model="form.nomination_percentage"
                                    />
                                </my-form-group>

                            </div>
                        </div>
                        <!-- ./Nomination -->

                        <div class="card">
                            <div class="card-body">
                                <h4>Comment</h4>
                                <b-form-textarea
                                    v-model="form.comment"
                                    placeholder="Comment..."
                                    rows="5"
                                    max-rows="10"
                                ></b-form-textarea>
                            </div>
                        </div>

                        <div class="row form-group-sm">
                            <div class="col-md-12 text-right">
                                <button
                                    class="btn btn-success"
                                    @click="save"
                                >
                                    <i class="fa fa-save"></i>
                                    Save
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            insurance_id: null,
            contact_data: {},
            form: {
                coverage: [],
                projected_benefit: [],
            },
            dropdown: {},
        }
    },
    computed: {
        contactDob() {
            return this.contact_data.dob
        },
        contactAge() {
            return this.contact_data.age
        },
        pageTitle() {
            let action = ""
            let title = ""
            if (this.form.is_create) {
                action = "Add New"
            } else if (!this.form.is_create) {
                action = "Edit "
            }

            if (this.form.insurance_type == "existing") {
                title = "Insurance"
            } else if (this.form.insurance_type == "recommendation") {
                title = "Recommendation"
            }
            return action + " " + title
        },
    },
    methods: {
        redirectBack() {
            let contact_id = this.form.contact_id
            this.$router.replace(
                "/my_contact/" +
                    contact_id +
                    "/edit/insurance#" +
                    this.form.insurance_type
            )
        },
        addProjectedBenefit() {
            this.form.projected_benefit.push({})
        },
        addCoverage() {
            this.form.coverage.push({})
        },
        deleteProjectedBenefit(projected_benefit) {
            let target = this.form.projected_benefit
            if (projected_benefit.id == null) {
                target.splice(target.indexOf(projected_benefit), 1)
            } else {
                this.$set(projected_benefit, "deleted", true)
            }
        },
        deleteCoverage(coverage) {
            let target = this.form.coverage
            if (coverage.id == null) {
                target.splice(target.indexOf(coverage), 1)
            } else {
                this.$set(coverage, "deleted", true)
            }
        },

        calInsuranceAge(type) {
            if (this.contact_data.dob == null) {
                return
            }
            if (type == "start") {
                let year_diff = this.getYearDiff(
                    this.contactDob,
                    this.form.start_date
                )
                this.$set(this.form, "start_age", year_diff)
            } else {
                let year_diff = this.getYearDiff(
                    this.contactDob,
                    this.form.maturity_date
                )
                this.$set(this.form, "maturity_age", year_diff)
            }
        },
        calMedicalAge(type) {
            if (this.contact_data.dob == null) {
                return
            }
            if (type == "start") {
                let year_diff = this.getYearDiff(
                    this.contactDob,
                    this.form.medical_benefit_start_date
                )
                this.$set(this.form, "medical_benefit_start_age", year_diff)
            } else {
                let year_diff = this.getYearDiff(
                    this.contactDob,
                    this.form.medical_benefit_maturity_date
                )
                this.$set(this.form, "medical_benefit_maturity_age", year_diff)
            }
        },
        calPremiumAge(type) {
            if (this.contact_data.dob == null) {
                return
            }
            if (type == "start") {
                let year_diff = this.getYearDiff(
                    this.contactDob,
                    this.form.premium_start_date
                )
                this.$set(this.form, "premium_start_age", year_diff)
            } else {
                let year_diff = this.getYearDiff(
                    this.contactDob,
                    this.form.premium_maturity_date
                )
                this.$set(this.form, "premium_maturity_age", year_diff)
            }
        },

        /*
            AXIOS Related
        */
        getInsuranceDetail() {
            axios
                .get("/vlife/get_contact_insurance_detail/" + this.insurance_id)
                .then((res) => {
                    this.form = res.data
                    this.getContactDetail()
                })
        },

        save: function () {
            axios
                .post("/vlife/my_contact/insurance/save", {
                    form: this.form,
                })
                .then((res) => {
                    var data = res.data
                    if (data.errors != null) {
                        Vue.swal(
                            "Validation Error",
                            data.error_message,
                            "error"
                        )
                    } else {
                        Vue.swal(
                            "Success",
                            "Record has been saved",
                            "success"
                        ).then((res) => {
                            if (this.form.id == null) {
                                location.href =
                                    "/vlife/my_contact/insurance/" +
                                    data.id +
                                    "/edit"
                            }
                        })
                    }
                })
        },

        //Get All Lists First
        async initLists() {
            await axios.get("/vlife/get_insurance_dropdown").then((res) => {
                this.dropdown = res.data
            })
        },
        getContactDetail() {
            axios
                .get("/vlife/get_contact_profile_data/" + this.form.contact_id)
                .then((res) => {
                    this.contact_data = res.data
                })
        },
    },

    created: function () {
        //this.asset_investment_data.contact_id = this.$route.params.contact_id
        let insurance_id = this.$route.params.insurance_id
        let contact_id = this.$route.params.contact_id

        if (insurance_id == null) {
            this.form.is_create = true
            this.form.contact_id = contact_id
            this.form.insurance_type = this.$route.query.insurance_type
            this.getContactDetail()
        } else {
            this.form.is_create = false
            this.insurance_id = insurance_id
            this.getInsuranceDetail()
        }
        this.initLists()
    },
    mounted() {},
}
</script>
