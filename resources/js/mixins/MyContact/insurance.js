export default ({
    methods: {
        addInsurance(type, contact_id, new_page) {
            let url =
                "/my_contact/insurance/" +
                contact_id +
                "/create?insurance_type=" +
                type
            if (new_page) {
                window.open('/vlife' + url);
            } else {
                this.$router.push(url)
            }

        },
        editInsurance(data) {
            let url = "/vlife/my_contact/insurance/" + data.id + "/edit"
            window.open(url);
        },
        deleteInsurance(data) {
            var vm = this
            let id = data.id
            this.showConfirm(
                "Confirmation",
                "Confirm to delete ?",
                function () {
                    axios
                        .post("/vlife/my_contact/insurance/delete", {
                            insurance_id: id,
                        })
                        .then((res) => {
                            vm.showSuccess(
                                "Success",
                                "Insurance has been removed"
                            )
                            location.reload()
                        })
                }
            )
        },
        inclRecommendation($event, data) {
            let id = data.id
            let checked = $event ?? 0

            Vue.swal({
                title: 'Confirmation',
                text: "Confirm to udpdate the incl status",
                icon: 'warning',
                showCancelButton: true,
            }).then((result) => {
                if (result.isConfirmed) {
                    axios
                        .post("/vlife/my_contact/insurance/update_incl", {
                            insurance_id: id,
                            status: checked,
                        })
                        .then((res) => {

                            Vue.swal('Success', 'Page will refresh after the dialog closed', 'success').then(res => {
                                location.reload();
                            })
                        })
                } else {
                    data.incl = (data.incl == 1) ? false : 1
                }
            })




        },

    }
})