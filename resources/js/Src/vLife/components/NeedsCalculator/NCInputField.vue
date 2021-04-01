<template>
    <tr>
        <!-- Delete Button -->
        <td class="fit">
            <b-btn
                size="sm"
                variant="danger"
                @click="deleteField"
            >
                <i class="fa fa-trash"></i>
            </b-btn>
        </td>

        <!--  Default Input, direct input total amount-->
        <template v-if="inputMethod=='Normal'">
            <td width="70%">
                <b-form-input v-model="form.description"></b-form-input>
            </td>
            <td>
                <VueNumeric
                    currency="$"
                    separator=","
                    v-model="form.total_amount"
                    class="form-control text-right"
                ></VueNumeric>
            </td>
        </template>

        <!--  PV input, required year,pmt,return,inflation to calculate total amount-->
        <template v-if="inputMethod=='PV'">
            <td>
                <input
                    type="text"
                    class="form-control"
                    v-model="form.description"
                >
            </td>
            <td
                align="right"
                width="15%"
            >
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">$</span>
                    </div>
                    <VueNumeric
                        currency="$"
                        separator=","
                        v-model="form.amount"
                        class="form-control text-right"
                        @input="calculateTotal"
                    ></VueNumeric>

                </div>
            </td>
            <!-- Year -->
            <td width="10%">
                <input
                    v-model="form.year"
                    class="form-control text-right"
                    @input="calculateTotal"
                />
            </td>
            <!-- Inflation Rate -->
            <td width="10%">
                <div class="input-group">
                    <input
                        v-model="form.inflation"
                        class="form-control text-right"
                        @input="calculateTotal"
                    />
                    <div class="input-group-append">
                        <span class="input-group-text">%</span>
                    </div>
                </div>
            </td>

            <!-- Return Rate-->
            <td width="10%">
                <div class="input-group">
                    <input
                        v-model="form.return_percent"
                        class="form-control text-right"
                        @input="calculateTotal"
                    />
                    <div class="input-group-append">
                        <span class="input-group-text">%</span>
                    </div>
                </div>
            </td>

            <!-- Amount Calculated -->
            <td width="20%">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">$</span>
                    </div>
                    <VueNumeric
                        currency="$"
                        separator=","
                        v-model="form.total_amount"
                        class="form-control text-right"
                    ></VueNumeric>
                </div>

            </td>
        </template>

        <!--  PV input, required year,pmt,return,inflation to calculate total amount-->
        <template v-if="inputMethod=='Interest'">
            <td>
                <input
                    type="text"
                    class="form-control"
                    v-model="form.description"
                >
            </td>
            <td
                align="right"
                width="15%"
            >
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">$</span>
                    </div>
                    <VueNumeric
                        currency="$"
                        separator=","
                        v-model="form.amount"
                        class="form-control text-right"
                        @input="calculateTotal"
                    ></VueNumeric>

                </div>
            </td>
            <!-- Year -->
            <td width="10%">
                <input
                    v-model="form.year"
                    class="form-control text-right"
                    @input="calculateTotal"
                />
            </td>

            <!-- Interest Rate-->
            <td width="10%">
                <div class="input-group">
                    <input
                        v-model="form.return_percent"
                        class="form-control text-right"
                        @input="calculateTotal"
                    />
                    <div class="input-group-append">
                        <span class="input-group-text">%</span>
                    </div>
                </div>
            </td>

            <!-- Amount Calculated -->
            <td width="20%">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">$</span>
                    </div>
                    <VueNumeric
                        currency="$"
                        separator=","
                        v-model="form.total_amount"
                        class="form-control text-right"
                    ></VueNumeric>
                </div>

            </td>
        </template>

    </tr>

</template>

<script>
import MixinNeedsCalculator from "../../../../Mixins/MyContact/needs_calculator"

export default {
    props: ["propsForm"],
    mixins: [MixinNeedsCalculator],
    data() {
        return {
            form: {},
        }
    },
    computed: {
        inputMethod() {
            let type = this.form.type
            let arr_fv = this.getFVInputArray()
            let arr_normal = this.getAmountOnlyInputArray()
            let arr_pv = this.getPVInputArray()
            let arr_intereset = this.getInterestInputArray()
            if (arr_fv.includes(type)) {
                return "FV"
            } else if (arr_pv.includes(type)) {
                return "PV"
            } else if (arr_intereset.includes(type)) {
                return "Interest"
            } else {
                return "Normal"
            }
        },
    },
    methods: {
        deleteField() {
            this.$emit("delete-field", this.propsForm)
        },
        calculateTotal() {
            if (this.inputMethod == "PV") {
                let inflation_rate = 1 + this.form.inflation / 100
                let return_rate = 1 + this.form.return_percent / 100

                let rate = (inflation_rate / return_rate - 1) / 12
                let nper = this.form.year * 12
                let pmt = this.form.amount

                let calculated_amount = this.calculatePV(rate, nper, pmt)
                this.form.total_amount = Math.round(calculated_amount)
            } else if (this.inputMethod == "FV") {
                let return_rate = this.form.return_percent / 100
                let pv = this.form.amount

                let calculated_amount = this.calculateFV(rate, nper, pv)
                this.form.total_amount = Math.round(calculated_amount)
            } else if (this.inputMethod == "Interest") {
                let rate = this.form.return_percent / 100
                let year = this.form.year
                let amt = this.form.amount
                let calculated_amount = amt + amt * year * rate
                this.form.total_amount = Math.round(calculated_amount)
            } else {
                return this.amount ?? this.total_amount
            }
        },
    },
    created() {
        this.form = this.propsForm
    },
}
</script>

<style>
</style>