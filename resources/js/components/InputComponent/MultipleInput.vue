<template>
    <div>
        <b-row>
            <b-col>
                <div
                    class="text-dark"
                    style="display: none"
                >{{ value }}</div>
                <div v-for="(a, key) in arr">
                    <b-row>
                        <b-col cols="2">
                            <b-button
                                class="btn btn-danger btn-sm"
                                @click="remove(key)"
                            ><i class="fa fa-trash"></i>
                            </b-button>
                        </b-col>
                        <b-col>
                            <b-form-input
                                v-model="arr[key]"
                                :placeholder="placeholder"
                                @input="onChange"
                            ></b-form-input>
                        </b-col>
                    </b-row>
                </div>
            </b-col>
            <b-col cols="2">
                <b-button
                    class="btn btn-success btn-sm"
                    @click="add"
                ><i class="fa fa-plus"></i></b-button>
            </b-col>
        </b-row>
    </div>
</template>
<script>
export default {
    props: {
        type: {
            type: String,
            default: "text",
        },
        placeholder: {
            type: String,
        },
        value: {},
        test: {},
    },
    data() {
        return {
            arr: [],
        }
    },
    methods: {
        add() {
            this.arr.push("")
            this.$emit("input", this.arr)
        },
        remove(key) {
            Vue.delete(this.arr, key)
            this.$emit("input", this.arr)
        },
        onChange() {
            this.$emit("input", this.arr)
        },
    },
    updated() {
        this.arr = this.value
    },
    created() {
        this.arr = this.value
    },
}
</script>