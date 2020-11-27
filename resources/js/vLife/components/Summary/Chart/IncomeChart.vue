<template>
    <div style="">
        <PieChart
            :chart-data="datacollection"
            :style="{position: 'relative'}"
            :options="{responsive: false,maintainAspectRatio: false,}"
        ></PieChart>
    </div>
</template>

<script>
import PieChart from "../../Chart/PieChart"

export default {
    components: {
        PieChart,
    },
    props: ["setting"],

    computed: {
        chartLabel() {
            if (this.setting != null && this.setting.label != null) {
                return this.setting.label
            }
            return []
        },
        chartColor() {
            if (this.setting != null && this.setting.color != null) {
                return this.setting.color
            }
            return []
        },
        chartData() {
            if (this.setting != null && this.setting.data != null) {
                return this.setting.data
            }
            return []
        },
        datacollection() {
            return {
                labels: this.chartLabel,
                datasets: [
                    {
                        data: this.chartData,
                        backgroundColor: this.chartColor,
                    },
                ],
            }
        },
    },
    methods: {},
}
</script>

<style>
.small {
    max-width: 600px;
    margin: 150px auto;
}
</style>