<template>
    <div>
        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary">
                    <div class="card-header">Assets & Investment</div>
                    <div class="card-body">
                        <div class="row form-group form-group-sm">
                            <label class="col-md-3">Incl ? :</label>
                            <div class="col-md-9">
                                <b-form-checkbox
                                    value="1"
                                    unchecked-value="0"
                                    v-model="asset_investment_data.incl"
                                ></b-form-checkbox>
                            </div>
                        </div>

                        <div class="row form-group form-group-sm">
                            <label class="col-md-3">Type :</label>
                            <div class="col-md-9">
                                <my-select
                                    size="sm"
                                    :items="type_options"
                                    v-model="asset_investment_data.type"
                                    itemText="text"
                                    itemValue="value"
                                ></my-select>
                            </div>
                        </div>

                        <div class="row form-group form-group-sm">
                            <label class="col-md-3">Description :</label>
                            <div class="col-md-9">
                                <input
                                    type="text"
                                    class="form-control"
                                    v-model="asset_investment_data.description"
                                />
                            </div>
                        </div>

                        <div class="row form-group form-group-sm">
                            <label class="col-md-3">Start :</label>
                            <div class="col-md-9">
                                <input
                                    type="number"
                                    min="0"
                                    class="form-control"
                                    v-model="asset_investment_data.start_age"
                                />
                            </div>
                        </div>

                        <div class="row form-group form-group-sm">
                            <label class="col-md-3">Age To Liquidate :</label>
                            <div class="col-md-9">
                                <input
                                    type="number"
                                    min="0"
                                    class="form-control"
                                    v-model="asset_investment_data.age_to_liquidate"
                                />
                            </div>
                        </div>

                        <div class="row form-group form-group-sm">
                            <label class="col-md-3">Project Growth (%) :</label>
                            <div class="col-md-9">
                                <input
                                    type="number"
                                    min="0"
                                    class="form-control"
                                    v-model="asset_investment_data.project_growth"
                                />
                            </div>
                        </div>

                        <div
                            class="row form-group form-group-sm"
                            v-if="visible === true"
                        >
                            <label class="col-md-3">Current Value :</label>
                            <div class="col-md-9">
                                <input
                                    type="number"
                                    min="0"
                                    step="1"
                                    v-model="asset_investment_data.current_value"
                                    class="form-control"
                                    @blur="onBlurNumber"
                                    onkeypress="return event.charCode >= 48 && event.charCode <= 57"
                                />
                            </div>
                        </div>

                        <div
                            class="row form-group form-group-sm"
                            v-if="visible === false"
                        >
                            <label class="col-md-3">Current Value :</label>
                            <div class="col-md-9">
                                <input
                                    type="text"
                                    v-model="asset_investment_data.current_value"
                                    class="form-control"
                                    @focus="onFocusText"
                                />
                            </div>
                        </div>

                        <br />

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
            type_options: [],
            asset_investment_data: { incl: 1 },
            temp: null,
            visible: true,
        }
    },
    methods: {
        save: function () {
            axios
                .post("/vlife/my_contact/asset_investment/save", {
                    asset_investment_data: this.asset_investment_data,
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
                            "/my_contact/" + data + "/edit/asset_investment"
                        )
                    }
                })
        },

        //Get All Lists First
        async initLists() {
            var $vm = this

            await axios
                .get("/vlife/get_contact_asset_investment_option")
                .then((response) => {
                    var res = response.data
                    $vm.type_options = res.type_options
                })

            if (this.$route.params.id) {
                await axios
                    .get(
                        "/vlife/get_contact_cashflow_asset_investment_data/" +
                            this.$route.params.id
                    )
                    .then((response) => {
                        var res = response.data
                        $vm.asset_investment_data = res
                    })
            }

            return true
        },
        onBlurNumber(e) {
            this.visible = false
            this.temp = this.asset_investment_data.current_value
            this.asset_investment_data.current_value = this.thousandSeprator(
                this.asset_investment_data.current_value
            )
        },
        onFocusText() {
            this.visible = true
            this.asset_investment_data.current_value = this.temp
        },
        thousandSeprator(amount) {
            if (
                amount !== "" ||
                amount !== undefined ||
                amount !== 0 ||
                amount !== "0" ||
                amount !== null
            ) {
                return amount.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")
            } else {
                return amount
            }
        },
    },
    created: function () {
        this.initLists()
        this.asset_investment_data.contact_id = this.$route.params.contact_id
    },
    mounted() {},
}
</script>
