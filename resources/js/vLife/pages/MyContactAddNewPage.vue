<template>
    <div>
        <h2>Add New Contact</h2>
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">BASIC INFO</h5>
            </div>

            <div class="card-body">
                <div class="row form-group form-group-sm">
                    <div class="col-md-4">
                        <label>Name :</label>
                        <input
                            type="text"
                            class="form-control"
                            v-model="contact_data.name"
                        />
                    </div>
                    <div class="col-md-4">
                        <label>Nickname :</label>
                        <input
                            type="text"
                            class="form-control"
                            v-model="contact_data.nickname"
                        />
                    </div>
                    <div class="col-md-4">
                        <label>Email :</label>
                        <input
                            type="email"
                            class="form-control"
                            v-model="contact_data.email"
                        />
                    </div>
                </div>
                <div class="row form-group form-group-sm">
                    <div class="col-md-4">
                        <label>Mobile :</label>
                        <input
                            type="text"
                            class="form-control"
                            v-model="contact_data.mobile"
                        />
                    </div>
                    <div class="col-md-4">
                        <label>NRIC/Passport No. :</label>
                        <input
                            type="text"
                            class="form-control"
                            v-model="contact_data.nric_passport"
                        />
                    </div>
                    <div class="col-md-4">
                        <label>Date of Birth :</label>
                        <date-picker v-model="contact_data.dob"></date-picker>
                    </div>
                </div>
            </div>

            <div class="card-footer">
                <button
                    class="btn btn-success"
                    @click="save"
                >
                    Add Contact
                </button>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            contact_data: {},
        }
    },
    methods: {
        save: function () {
            axios
                .post("/vlife/my_contact/profile/save", {
                    contact_data: this.contact_data,
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
                        this.$router.replace(
                            "/my_contact/" + data + "/edit/profile"
                        )
                    }
                })
        },
    },
    created: function () {},
    mounted() {},
}
</script>
