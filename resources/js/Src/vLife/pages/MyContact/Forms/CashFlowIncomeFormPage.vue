<template>
    <div>
        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary">
                    <div class="card-header">Income</div>
                    <div class="card-body">
                        <div class="row form-group form-group-sm">
                            <label class="col-md-3">Incl ? :</label>
                            <div class="col-md-9">
                                <b-form-checkbox
                                    value="1"
                                    unchecked-value="0"
                                    v-model="income_data.incl"
                                ></b-form-checkbox>
                            </div>
                        </div>

                        <div class="row form-group form-group-sm">
                            <label class="col-md-3">Description :</label>
                            <div class="col-md-9">
                                <input
                                    type="text"
                                    class="form-control"
                                    v-model="income_data.description"
                                />
                            </div>
                        </div>

                        <div class="row form-group form-group-sm">
                            <label class="col-md-3">Type :</label>
                            <div class="col-md-9">
                                <my-select
                                    size="sm"
                                    :items="type_options"
                                    v-model="income_data.type"
                                    itemText="text"
                                    itemValue="value"
                                ></my-select>
                            </div>
                        </div>

                        <div class="row form-group form-group-sm">
                            <label class="col-md-3">Frequency :</label>
                            <div class="col-md-9">
                                <my-select
                                    size="sm"
                                    :items="frequency_options"
                                    v-model="income_data.frequency"
                                    itemText="text"
                                    itemValue="value"
                                ></my-select>
                            </div>
                        </div>

                        <div
                            class="row form-group form-group-sm"
                            v-if="visible === true"
                        >
                            <label class="col-md-3">Amount :</label>
                            <div class="col-md-9">
                                <input
                                    type="number"
                                    min="0"
                                    step="1"
                                    v-model="income_data.amount"
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
                            <label class="col-md-3">Amount:</label>
                            <div class="col-md-9">
                                <input
                                    type="text"
                                    v-model="income_data.amount"
                                    class="form-control"
                                    @focus="onFocusText"
                                />
                            </div>
                        </div>
                        <!--<label class="col-md-3">Amount :</label>
              <div class="col-md-9">
                <input type="number" min="0" step="0.01" class="form-control" v-model="income_data.amount">
              </div>-->

                        <div class="row form-group form-group-sm">
                            <label class="col-md-3">Start :</label>
                            <div class="col-md-9">
                                <input
                                    type="number"
                                    min="0"
                                    class="form-control"
                                    v-model="income_data.start_age"
                                />
                            </div>
                        </div>

                        <div class="row form-group form-group-sm">
                            <label class="col-md-3">End :</label>
                            <div class="col-md-9">
                                <input
                                    type="number"
                                    min="0"
                                    class="form-control"
                                    v-model="income_data.end_age"
                                />
                            </div>
                        </div>

                        <div class="row form-group form-group-sm">
                            <label class="col-md-3">Growth (%) :</label>
                            <div class="col-md-9">
                                <input
                                    type="number"
                                    min="0"
                                    class="form-control"
                                    v-model="income_data.growth"
                                />
                            </div>
                        </div>

                        <div class="row form-group form-group-sm">
                            <label class="col-md-3">Tax :</label>
                            <div class="col-md-9">
                                <my-select
                                    size="sm"
                                    single-line
                                    :items="yesno_options"
                                    v-model="income_data.tax"
                                    itemText="text"
                                    itemValue="value"
                                ></my-select>
                            </div>
                        </div>

                        <div class="row form-group form-group-sm">
                            <label class="col-md-3">EPF :</label>
                            <div class="col-md-9">
                                <my-select
                                    size="sm"
                                    single-line
                                    :items="yesno_options"
                                    v-model="income_data.epf"
                                    itemText="text"
                                    itemValue="value"
                                ></my-select>
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
            frequency_options: [],
            type_options: [],
            yesno_options: [],

            income_data: {},
            temp: null,
            visible: true,
        }
    },
    methods: {
        save: function () {
            axios
                .post("/vlife/my_contact/cashflow/income/save", {
                    income_data: this.income_data,
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

                        this.$router.push({
                            path: "/my_contact/" + data + "/edit/cashflow",
                        })
                        //this.$router.replace("/my_contact/" + data + "/edit");
                    }
                })
        },
        onBlurNumber(e) {
            this.visible = false
            this.temp = this.income_data.amount
            this.income_data.amount = this.thousandSeprator(
                this.income_data.amount
            )
        },
        onFocusText() {
            this.visible = true
            this.income_data.amount = this.temp
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

        //Get All Lists First
        async initLists() {
            var $vm = this

            await axios
                .get("/vlife/get_contact_cashflow_income_option")
                .then((response) => {
                    var res = response.data
                    $vm.frequency_options = res.frequency_options
                    $vm.type_options = res.type_options
                    $vm.yesno_options = res.yesno_options
                })

            if (this.$route.params.id) {
                await axios
                    .get(
                        "/vlife/get_contact_cashflow_income_data/" +
                            this.$route.params.id
                    )
                    .then((response) => {
                        var res = response.data
                        $vm.income_data = res
                    })
            }

            return true
        },
    },
    created: function () {
        this.initLists()
        this.income_data.contact_id = this.$route.params.contact_id
    },
    mounted() {},
}
</script>
