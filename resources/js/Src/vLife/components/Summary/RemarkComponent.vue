<template>
    <div class="">
        <div class="row h3">
            <div class="col-4">Last Review Date</div>
            <div class="col">
                <my-datepicker v-model="form.last_review_date" />
            </div>
        </div>
        <div class="row h3">
            <div class="col-4">Special Remark</div>
            <div class="col">
                <b-form-textarea
                    id="textarea"
                    v-model="form.special_remark"
                    placeholder="This remark will appear in report"
                    rows="5"
                    max-rows="9"
                ></b-form-textarea>
            </div>
        </div>
        <h1 class="title-cyan">Remarks</h1>
        <div>
            <div class="row h3">
                <div class="col-4">1. Recap of Review</div>
                <div class="col">
                    <b-form-textarea
                        id="textarea"
                        v-model="form.recap_of_review"
                        placeholder="Enter something..."
                        rows="5"
                        max-rows="9"
                    ></b-form-textarea>
                </div>
            </div>
            <div class="row h3">
                <div class="col-4">2. Action Taken</div>
                <div class="col">
                    <b-form-textarea
                        id="textarea"
                        v-model="form.action_taken"
                        placeholder="Enter something..."
                        rows="5"
                        max-rows="9"
                    ></b-form-textarea>
                </div>
            </div>
            <div class="row h3">
                <div class="col-4">3. Affordability of Goals</div>
                <div class="col">
                    <b-form-textarea
                        id="textarea"
                        v-model="form.affordability_of_goals"
                        placeholder="Enter something..."
                        rows="5"
                        max-rows="9"
                    ></b-form-textarea>
                </div>
            </div>
            <div class="row h3">
                <div class="col-4">4. Next Steps</div>
                <div class="col">
                    <b-form-textarea
                        id="textarea"
                        v-model="form.next_steps"
                        placeholder="Enter something..."
                        rows="5"
                        max-rows="9"
                    ></b-form-textarea>
                </div>
            </div>
        </div>
        <div class="mt-5 text-center">
            <b-btn
                variant="success"
                size="lg"
                @click="saveRemark"
            >
                <i class="fa fa-save"></i>
                Save
            </b-btn>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            contact_id: null,
            form: {},
        }
    },
    methods: {
        saveRemark() {
            axios
                .post("/vlife/my_contact/summary/save", {
                    contact_id: this.contact_id,
                    form: this.form,
                })
                .then((response) => {
                    var data = response.data
                    if (data.errors != null) {
                        Vue.swal(
                            "Validation Error",
                            data.error_message,
                            "error"
                        )
                    } else {
                        Vue.swal("Success", "Record has been saved", "success")
                    }
                })
        },
        getContactDetail() {
            axios
                .get("/vlife/get_contact_profile_data/" + this.contact_id)
                .then((res) => {
                    var data = res.data

                    Vue.set(
                        this.form,
                        "last_review_date",
                        data.last_review_date
                    )
                    Vue.set(this.form, "special_remark", data.special_remark)
                    Vue.set(this.form, "recap_of_review", data.recap_of_review)
                    Vue.set(this.form, "action_taken", data.action_taken)

                    Vue.set(
                        this.form,
                        "affordability_of_goals",
                        data.affordability_of_goals
                    )
                    Vue.set(this.form, "next_steps", data.next_steps)
                })
        },
    },
    created() {
        this.contact_id = this.$route.params.id
        this.getContactDetail()
    },
}
</script>