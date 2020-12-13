<template>
    <div>
        <b-breadcrumb >
            <b-breadcrumb-item href="/setting">Setting</b-breadcrumb-item>
            <b-breadcrumb-item active>Service</b-breadcrumb-item>
        </b-breadcrumb>
        <vuetable
            ref="vuetable"
            api-url="/setting/r/get_service_lists"
            :fields="fields"
        >
            <template slot="actions" slot-scope="props">
                <a class="btn  btn-success" @click="editRow(props.rowData)">
                    <i class="fa fa-edit"></i>
                </a>
            </template>
            <template slot="appearance">
                <span class="badge badge-primary">NULL</span>
            </template>
        </vuetable>
    </div>
</template>

<script>
export default {
    data() {
        return {
            fields: [
                {
                    name: "actions",
                    title: "Option"
                },
                {
                    name: "id",
                    title: "ID",
                    sortField: "id"
                },
                {
                    name: "code",
                    title: "Code",
                    sortField: "code"
                },
                {
                    name: "name",
                    title: "Name",
                    sortField: "name"
                },
                {
                    name: "budget_enabled",
                    title: "Budget",
                    sortField: "budget_enabled"
                },
                {
                    name: "customer_invoice_enabled",
                    title: "Customer Invoice",
                    sortField: "customer_invoice_enabled"
                },
                {
                    name: "sw_payment_enabled",
                    title: "SW Payment",
                    sortField: "sw_payment_enabled"
                },
                {
                    name: "dex_enabled",
                    title: "DEX",
                    sortField: "dex_enabled"
                },
                {
                    name: "careplan_enabled",
                    title: "Careplan",
                    sortField: "careplan_enabled"
                },
                {
                    name: "appearance",
                    title: "Appearance"
                }
            ]
        };
    },
    methods: {
        editRow(data){
            let serviceId = data.id
            this.$router.push({ path: `/services/${serviceId}` })
        },
    },
    created() {}
};
</script>
