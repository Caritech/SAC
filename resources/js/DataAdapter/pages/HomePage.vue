<template>
<div>
    <loading :active.sync="isLoading" :can-cancel="false" :is-full-page="fullPage"></loading>

    <button class="btn btn-success" @click="syncInformation">Sync Contact Information From V1</button>
    <button class="btn btn-success" @click="syncService">Sync Care Plan & Assignment From V1</button>
    <button class="btn btn-success" @click="syncPrice">Sync Agency and HCP Pricing From V1</button>
</div>
</template>

<script>
// Import component
import Loading from 'vue-loading-overlay';
// Import stylesheet
import 'vue-loading-overlay/dist/vue-loading.css';
export default {
    data() {
        return {
            isLoading: false,
            fullPage: true
        };
    },
    components: {
        Loading
    },
    methods: {
        syncService() {
            Vue.swal("pending");
        },
        syncInformation() {
            this.$swal({
                title: "Confirmation",
                text: "Confirm to sync information from Ired V1 ?",
                showCancelButton: true,
            }).then((result) => {

                if (result.value) {
                    this.isLoading = true;
                    axios.get("/data_adapter/r/sync_information").then((res) => {
                        this.isLoading = false;
                        Vue.swal("Success", "Record has been syned", "success");
                    });
                }
            });
        },
        syncPrice() {
            this.$swal({
                title: "Confirmation",
                text: "Confirm to sync prici from Ired V1 ?",
                showCancelButton: true,
            }).then((result) => {
                if (result.value) {
                    this.isLoading = true;
                    axios.get("/data_adapter/r/sync_price").then((res) => {
                        Vue.swal("Success", "Record has been syned", "success");
                    });
                    this.isLoading = false;
                }
            });
        },
    },
    created() {},
};
</script>
