<template>

    <tr style="font-size:12px;">
        <template v-if="TrType=='PV'">
            <td align=right></td>
            <td>Description</td>
            <td align=right>Amount</td>
            <td align=right>Year</td>
            <td align=right>Inflation</td>
            <td align=right>Return</td>
            <td align=right>Total</td>
        </template>

        <template v-if="TrType=='FV'">
            <td align=right></td>
            <td>Description</td>
            <td align=right>Amount</td>
            <td align=right>Year</td>
            <td align=right>Inflation</td>
            <td align=right>Return</td>
            <td align=right>Total</td>
        </template>

        <template v-if="TrType=='Interest'">
            <td align=right></td>
            <td>Description</td>
            <td align=right>Amount</td>
            <td align=right>Year</td>
            <td align=right>Interest</td>
            <td align=right>Total</td>
        </template>

        <template v-if="TrType=='Normal'">
            <td align=right></td>
            <td>Description</td>
            <td align=right>Amount</td>
        </template>
    </tr>

</template>

<script>
import MixinNeedsCalculator from "../../../../Mixins/MyContact/needs_calculator"
export default {
    props: ["type"],
    mixins: [MixinNeedsCalculator],
    computed: {
        TrType() {
            let field = this.type
            let arr_fv = this.getFVInputArray()
            let arr_normal = this.getAmountOnlyInputArray()
            let arr_pv = this.getPVInputArray()
            let arr_interest = this.getInterestInputArray()

            //PV or FV Calculation
            if (arr_fv.includes(field)) {
                return "FV"
            }

            if (arr_pv.includes(field)) {
                return "PV"
            }
            //Interest Calculation
            if (arr_interest.includes(field)) {
                return "Interest"
            }

            return "Normal"
        },
    },
}
</script>

<style>
</style>