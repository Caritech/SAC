<template>
    <div>
        <div class="row">
            <div
                v-for="d in data"
                class
                style="display:inline-block"
                :style="'width:'+getWidth(d)+'%;color:'+getColor(d)+';text-align:'+getTextAlign(d)+';padding:'+getPadding(d)"
            >
                <h4
                    class="font-weight-bold"
                    v-if="getWidth(d) > 0"
                >{{d.title}}</h4>
            </div>
        </div>
        <div class="row">
            <div
                v-for="d in data"
                class="text-white"
                style="display:inline-block"
                :style="'width:'+getWidth(d)+'%;background:'+getColor(d)+';text-align:'+getTextAlign(d)+';padding:'+getPadding(d)"
            >
                <h4 v-if="getWidth(d) > 0">{{ showBarTitle(getWidth(d)) }} %</h4>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: ["data"],
    computed: {
        total() {
            let total = 0
            this.data.forEach(function (v, k) {
                total += v.value
            })
            return total
        },
        noData() {
            if (isNaN(this.total) || this.total == 0) {
                return true
            } else {
                return false
            }
        },
    },
    methods: {
        showBarTitle(v) {
            if (this.noData) {
                return "-"
            } else {
                return v
            }
        },
        getWidth(d) {
            if (this.noData) {
                return 50
            } else {
                let w = (d.value / this.total) * 100
                return Math.floor(w * 10) / 10
            }
        },
        getColor(d) {
            if (this.data.length == 2) {
                let index = this.data.indexOf(d)

                if (index == 0) {
                    return "#FF968A"
                } else {
                    return "#A9DEF9"
                }
            }
        },
        getTextAlign(d) {
            if (this.data.length == 2) {
                let index = this.data.indexOf(d)

                if (index == 0) {
                    return "right"
                } else {
                    return "left"
                }
            }
        },
        getPadding(d) {
            if (this.data.length == 2) {
                let index = this.data.indexOf(d)
                if (this.getWidth(d) == 0) {
                    return "0px"
                }
                if (index == 0) {
                    return "0px 5px 0px 5px"
                } else {
                    return "0px 5px 0px 5px"
                }
            }
        },
    },
}
</script>


