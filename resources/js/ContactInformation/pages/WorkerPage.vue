<template>
<div>
    <b-breadcrumb>
        <b-breadcrumb-item href="/contactinformation">Contact Information</b-breadcrumb-item>
        <b-breadcrumb-item active>Worker Lists</b-breadcrumb-item>
    </b-breadcrumb>

    <my-table-search @search="reloadVuetable" v-model="search" :search-fields="search" :search-columns="column"></my-table-search>

    <div>
        <my-vuetable ref="myVuetable" api-url="/contactinformation/r/get_support_worker_lists" :fields="fields" :appendParams="{search:this.search}">
            <template slot="actions" slot-scope="props">
                <router-link class="btn btn-success" :to="'support_worker/'+props.rowData.id+'/edit'" target="_blank">
                    <i class="fa fa-edit"></i>
                </router-link>
            </template>
            <template slot="appearance">
                <span class="badge badge-primary">NULL</span>
            </template>
        </my-vuetable>
    </div>

</div>
</template>

<script>
import MyTableSearch from "../../components/MyTableSearch";

export default {
    components: {
        "my-table-search": MyTableSearch
    },
    data() {
        return {
            column: [{
                    name: "prefer_name",
                    title: "Prefer Name",
                    search_type: "text",
                },
                {
                    name: "first_name",
                    title: "First Name",
                    search_type: "text",
                },
                {
                    name: "active",
                    title: "Active",
                    search_type: "drop_down",
                    search_lists: [{
                        label: 'Active',
                        value: 1
                    }, {
                        label: 'Inactive',
                        value: 0
                    }],
                    search_lists_placeholder: "Active / Inactive"
                },
            ],

            search: [],

            fields: [{
                    name: "actions",
                    title: "Option",
                },
                {
                    name: "active",
                    title: "Active",
                    sortField: "active",
                },
                {
                    name: "is_staff",
                    title: "Staff",
                    sortField: "is_staff",
                },
                {
                    name: "sw_no",
                    title: "SW No",
                    sortField: "sw_no",
                },
                {
                    name: "prefer_name",
                    title: "Prefer Name",
                    sortField: "personal_particular.prefer_name",
                },
                {
                    name: "first_name",
                    title: "First",
                    sortField: "personal_particular.first_name",
                },
                {
                    name: "middle_name",
                    title: "Middle",
                    sortField: "personal_particular.middle_name",
                },
                {
                    name: "surname",
                    title: "Last",
                    sortField: "personal_particular.surname",
                },
                {
                    name: "gender",
                    title: "Gender",
                    sortField: "personal_particular.gender",
                },
                {
                    name: "dob",
                    title: "DOB",
                    sortField: "personal_particular.dob",
                },
                {
                    name: "suburb",
                    title: "Suburb",
                    sortField: "personal_particular.suburb",
                },
                {
                    name: "phone",
                    title: "Phone",
                    sortField: "personal_particular.phone",
                },
                {
                    name: "mobile",
                    title: "Mobile",
                    sortField: "personal_particular.mobile",
                },
            ],
        };
    },
    methods: {
        addWorker() {},
        editRow() {},
        reloadVuetable() {
            this.$refs.myVuetable.$refs.vuetable.refresh()
        }
    },
    created() {},
};
</script>
