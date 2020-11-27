<template>
    <div class="">
        <h1 class="title-cyan">Special Remarks</h1>
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
            this.showInfo("Pending", "Comming Soon")
        },
    },
    created() {
        this.contact_id = this.$route.params.id
    },
}
</script>