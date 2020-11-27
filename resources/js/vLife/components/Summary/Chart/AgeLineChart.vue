<template>
    <div style="width:100%">
        <LineChart
            :chart-data="dataCollection"
            :style="{position: 'relative',width:'100%'}"
            :options="chartOptions"
        ></LineChart>
    </div>
</template>

<script>
import LineChart from "../../Chart/LineChart"

export default {
    props: ["setting"],
    components: {
        LineChart,
    },
    computed: {
        chartOptions() {
            return {
                responsive: true,
                maintainAspectRatio: false,
                elements: {
                    line: {
                        tension: 0,
                    },
                    point: {
                        radius: 0,
                    },
                },
                scales: {
                    xAxes: [
                        {
                            scaleLabel: {
                                display: true,
                                labelString: this.setting.xLabel,
                            },
                            ticks: {
                                suggestedMin: 0,
                                suggestedMax: 99,
                                stepSize: 2,
                            },
                        },
                    ],
                    yAxes: [
                        {
                            scaleLabel: {
                                display: true,
                                labelString: this.setting.yLabel,
                            },
                            ticks: {
                                suggestedMin: 0,
                                suggestedMax: this.setting.suggestedMax ?? null,
                                stepSize: this.setting.stepSize ?? null,
                                callback: function (value, index, values) {
                                    if (parseInt(value) >= 1000) {
                                        return (
                                            "$ " +
                                            value
                                                .toString()
                                                .replace(
                                                    /\B(?=(\d{3})+(?!\d))/g,
                                                    ","
                                                )
                                        )
                                    } else {
                                        return "$" + value
                                    }
                                },
                            },
                        },
                    ],
                },
            }
        },
        dataCollection() {
            let datasets = []

            for (let key in this.setting.dataSet) {
                let data = this.setting.dataSet[key]
                let set = {
                    label: data.title,
                    backgroundColor: data.color,
                    borderColor: data.color,
                    data: data.values,
                    fill: false,
                }
                datasets.push(set)
            }

            return {
                labels: this.setting.label,
                datasets: datasets,
            }
        },
    },
}
</script>

<style>
.small {
    max-width: 600px;
    margin: 150px auto;
}
</style>