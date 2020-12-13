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
                <b-form-input
                    v-model="form.total_amount"
                    class="text-right"
                ></b-form-input>
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
                    <input
                        type="number"
                        class="form-control text-right"
                        placeholder="PMT"
                        v-model="form.amount"
                        @input="calculateTotal"
                    >
                </div>
            </td>
            <!-- Year -->
            <td width="10%">
                <input
                    type="number"
                    class="form-control text-right"
                    placeholder="Year"
                    v-model="form.year"
                    @input="calculateTotal"
                >
            </td>
            <!-- Return Rate-->
            <td width="10%">
                <input
                    type="number"
                    class="form-control text-right"
                    placeholder="Return %"
                    v-model="form.return_percent"
                    @input="calculateTotal"
                >
            </td>
            <!-- Inflation Rate -->
            <td width="10%">
                <input
                    type="number"
                    class="form-control text-right"
                    placeholder="Inflation %"
                    v-model="form.inflation"
                    @input="calculateTotal"
                >
            </td>
            <!-- Amount Calculated -->
            <td width="20%">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">$</span>
                    </div>
                    <input
                        type="number"
                        class="form-control text-right"
                        placeholder="Total Amount"
                        v-model="form.total_amount"
                    >
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
            if (arr_fv.includes(type)) {
                return "FV"
            } else if (arr_pv.includes(type)) {
                return "PV"
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