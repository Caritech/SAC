<template>
    <div style="width:100%">
        <span style="display:none">{{chartKey}}</span>
        <LineChart
            :chart-data="dataCollection"
            :style="{position: 'relative',width:'100%'}"
            :options="chartOptions"
            :ref="'myLifeChart'"
        ></LineChart>

    </div>
</template>

<script>
import LineChart from "../../Chart/LineChart"

export default {
    //chartKey use to for chart re-render
    props: ["setting", "chartKey"],
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

    methods: {
        rerender() {
            this.$refs.myLifeChart.renderChart(
                this.dataCollection,
                this.chartOptions
            )
            console.log("line chart re-render")
        },
    },
    updated() {
        let vm = this
        //need to wait for component width set
        this.$nextTick(function () {
            setTimeout(function () {
                vm.rerender()
            }, 1000)
        })
    },
}
</script>

<style>
.small {
    max-width: 600px;
    margin: 150px auto;
}
</style>