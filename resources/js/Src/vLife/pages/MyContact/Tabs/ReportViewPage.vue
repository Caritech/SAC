<template>
    <div>
        <b-card>
            <b-btn
                variant="primary"
                @click="printSummaryPDF"
            >Export Summary Report For Client (PDF)</b-btn>
        </b-card>
    </div>
</template>

<script>
export default {
    data() {
        return {
            contact_id: null,
        }
    },
    methods: {
        printSummaryPDF() {
            window.open(
                "/vlife/my_contact/" + this.contact_id + "/print_summary_report"
            )
        },
    },
    created() {
        this.contact_id = this.$route.params.id
    },
}
</script>
