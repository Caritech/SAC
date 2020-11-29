<template>
    <div class="row b-2">
        <div class="col">
            <b-form-input
                @input="onInput"
                :value="value"
                type="range"
                :min="min"
                :max="max"
            ></b-form-input>
        </div>
        <div class="col-1">
            <center>
                <b-badge
                    pill
                    variant="primary"
                    @click="resetToDefault"
                >{{value}} %</b-badge>
            </center>
        </div>

    </div>
</template>

<script>
export default {
    props: ["min", "max", "value", "default"],
    methods: {
        onInput($event) {
            this.$emit("input", $event)
        },
        resetToDefault() {
            this.$emit("input", this.default ?? 100)
        },
    },
}
</script>