<template>
    <div>
        <div class="row">
            <div
                v-for="d in data"
                class
                style="display:inline-block"
                :style="'width:'+getWidth(d)+'%;color:'+getColor(d)+';text-align:'+getTextAlign(d)+';padding:'+getPadding(d)"
            >
                <h4 class="font-weight-bold">{{d.title}}</h4>
            </div>
        </div>
        <div class="row">
            <div
                v-for="d in data"
                class="text-white"
                style="display:inline-block"
                :style="'width:'+getWidth(d)+'%;background:'+getColor(d)+';text-align:'+getTextAlign(d)+';padding:'+getPadding(d)"
            >
                <h4>{{getWidth(d)}} %</h4>
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
    },
    methods: {
        getWidth(d) {
            let w = (d.value / this.total) * 100
            return Math.floor(w * 10) / 10
        },
        getColor(d) {
            if (this.data.length == 2) {
                let index = this.data.indexOf(d)

                if (index == 0) {
                    return "#F50057"
                } else {
                    return "#448AFF"
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


