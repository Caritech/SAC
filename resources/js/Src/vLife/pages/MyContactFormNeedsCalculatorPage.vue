<template>
    <div>
        <ul class="nav nav-pills justify-content-center">
            <li class="nav-item">
                <a
                    class="nav-link active"
                    data-toggle="pill"
                    href="#medical"
                >Medical</a>
            </li>
            <li class="nav-item">
                <a
                    class="nav-link"
                    data-toggle="pill"
                    href="#critical_illness"
                >Critical Illness</a>
            </li>
            <li class="nav-item">
                <a
                    class="nav-link"
                    data-toggle="pill"
                    href="#death_tpd"
                >Death/TPD</a>
            </li>
            <li class="nav-item">
                <!-- <a class="nav-link" data-toggle="pill" href="#retirement">Retirement</a> -->
                <button
                    class="btn btn-secondary"
                    disabled
                    style="font-size: initial;"
                >Retirement</button>
            </li>
            <li class="nav-item">
                <!-- <a class="nav-link" data-toggle="pill" href="#other">Other</a> -->
                <button
                    class="btn btn-secondary"
                    disabled
                    style="font-size: initial;"
                >Other</button>
            </li>
        </ul>
        <div class="tab-content">
            <div
                class="tab-pane container active"
                id="medical"
            >
                <NC-Medical></NC-Medical>
            </div>
            <div
                class="tab-pane container fade"
                id="critical_illness"
            >
                <NC-CI></NC-CI>
            </div>

            <div
                class="tab-pane container fade"
                id="death_tpd"
            >
                <NC-DeathTpd></NC-DeathTpd>
            </div>
            <div
                class="tab-pane container fade"
                id="retirement"
            >
                COMMING SOON
            </div>
            <div
                class="tab-pane container fade"
                id="other"
            >
                COMMING SOON
            </div>
        </div>
    </div>
</template>

<script>
import Medical from "../components/NeedsCalculator/Medical"
import CI from "../components/NeedsCalculator/CI"
import DeathTpd from "../components/NeedsCalculator/DeathTpd"
import StoreNeedsCalculator from "../../../Stores/MyContact/needs_calculator"

export default {
    components: {
        "NC-Medical": Medical,
        "NC-CI": CI,
        "NC-DeathTpd": DeathTpd,
    },
    computed: {
        state() {
            return this.$store.state.needs_calculator
        },
        store() {
            return this.$store.needs_calculator
        },
    },
    created() {
        let contact_id = this.$route.params.id

        this.$store.commit("needs_calculator/setId", contact_id)
        this.$store.dispatch("needs_calculator/getNeedsCalculatorData")
        this.$store.dispatch("needs_calculator/getVLifeSetting")
    },
}
</script>
<style>
.btn-label {
    color: black !important;
    border: 1px solid black !important;
    font-weight: 700 !important;
}
.btn-label:hover {
    background: rgba(0, 0, 0, 0) !important;
    color: black !important;
}
</style>

