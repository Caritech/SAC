<template>
    <div>
        <!-- <b-breadcrumb>
      <b-breadcrumb-item href="/vlife">Home</b-breadcrumb-item>
      <b-breadcrumb-item active>My Contact</b-breadcrumb-item>
    </b-breadcrumb> -->
        <div class="row mt-3">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        Contact
                        <span class="float-right">
                            <button
                                class="btn btn-sm btn-success"
                                @click="addProfile()"
                            >
                                <i class="fas fa-user-plus"></i> Add Contact
                            </button>
                        </span>
                    </div>
                    <div class="card-body">
                        <my-vuetable
                            api-url="/vlife/get_contact_list"
                            :per-page="10"
                            :fields="contact_fields"
                            ref="myVuetable"
                        >
                            <template
                                slot="actions"
                                slot-scope="props"
                            >
                                <a
                                    class="btn btn-outline-success"
                                    @click="editContact(props.rowData)"
                                >
                                    <i class="fa fa-edit"></i>
                                </a>
                                <a
                                    class="btn btn-outline-primary"
                                    @click="deleteContact(props.rowData)"
                                >
                                    <i class="fas fa-trash-alt"></i>
                                </a>
                            </template>
                            <template
                                slot="class_type"
                                slot-scope="props"
                            >
                                <span
                                    v-if="props.rowData.class_type == 'A'"
                                    class="bg-success label-background"
                                >{{ props.rowData.class_type }}</span>
                                <span
                                    v-if="props.rowData.class_type == 'B'"
                                    class="bg-warning label-background"
                                >{{ props.rowData.class_type }}</span>
                                <span
                                    v-if="props.rowData.class_type == 'C'"
                                    class="bg-danger label-background"
                                >{{ props.rowData.class_type }}</span>

                            </template>
                            <template
                                slot="remark"
                                slot-scope="props"
                            >
                                <span
                                    v-if="
                    props.rowData.remark != '' && props.rowData.remark != null
                  "
                                    v-b-tooltip.hover.left
                                    :title="props.rowData.remark"
                                >
                                    <i class="fa fa-sticky-note"></i>
                                </span>
                            </template>
                        </my-vuetable>
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
            pagination: {
                wrapperClass: "pagination float-right",
                activeClass: "active",
                disabledClass: "disabled",
                pageClass: "page-item page-link",
                linkClass: "page-link",
                paginationClass: "pagination",
                paginationInfoClass: "float-left",
                dropdownClass: "form-control",
                icons: {
                    first: "fa fa-angle-double-left",
                    prev: "fa fa-angle-left",
                    next: "fa fa-angle-right",
                    last: "fa fa-angle-double-right",
                },
            },
            contact_fields: [
                {
                    name: "actions",
                    title: "Option",
                },
                {
                    name: "id",
                    title: "ID",
                    sortField: "id",
                },
                {
                    name: "name",
                    title: "Name",
                    sortField: "name",
                },
                {
                    name: "gender",
                    title: "Gender",
                    sortField: "gender",
                },
                {
                    name: "dob",
                    title: "Date of Birth",
                    sortField: "dob",
                },
                {
                    name: "relationship_status",
                    title: "Relationship Status",
                    sortField: "relationship_status",
                },
                {
                    name: "class_type",
                    title: "Class",
                    sortField: "class_type",
                },
            ],
        }
    },
    methods: {
        editContact(data) {
            let id = data.id
            this.$router.push("/my_contact/" + id + "/edit/profile")
        },
        deleteContact(data) {
            let id = data.id
            Vue.swal({
                title: "Are you sure?",
                text: "It will be inactive this profile!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes",
                showLoaderOnConfirm: true,

                preConfirm: function () {
                    return new Promise(function (resolve) {
                        axios
                            .post("/vlife/my_contact/profile/inactive", {
                                id: id,
                            })
                            .then((response) => {
                                /*swal('Event Status Updated!', response.message, response.status);*/
                                Vue.swal(
                                    response.data.title,
                                    response.data.message,
                                    response.data.status
                                )
                                setTimeout(function () {
                                    window.location.reload() // you can pass true to reload function to ignore the client cache and reload from the server
                                }, 2000)
                            })
                    })
                },
                allowOutsideClick: false,
            })
        },
        addProfile() {
            this.$router.push("/my_contact/profile/create")
        },
    },
    created() {},
}
</script>
