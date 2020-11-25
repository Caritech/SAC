<template>
    <div :class="[divColClass, bottomPaddingClass]">
        <div class="row">
            <label :class="labelColClass">{{ title }} :</label>
            <div :class="inputColClass">
                <slot></slot>
            </div>
        </div>
    </div>
</template>


<script>
export default {
    props: {
        title: {
            type: String,
        },
        divCol: {
            type: Number,
        },
        labelCol: {
            default: 3,
        },
        inputCol: {
            default: 9,
        },
        bottomPadding: {
            default: 3,
        },
        withRow: {
            type: Boolean,
            default: false,
        },
        equalSize: {
            type: Boolean,
            default: false,
        },
    },
    computed: {
        bottomPaddingClass() {
            return "mb-" + this.bottomPadding
        },
        divColClass() {
            var div_col = null
            if (this.divCol != null) {
                div_col = this.divCol
            }

            if (this.equalSize) {
                div_col = 12
            }

            if (div_col != null) {
                return "col-md-" + div_col
            } else {
                return ""
            }
        },
        labelColClass() {
            var label_col = this.labelCol
            if (this.equalSize) {
                label_col = 6
            }
            return "col-md-" + label_col
        },
        inputColClass() {
            var input_col = this.inputCol
            if (this.equalSize) {
                input_col = 6
            }
            return "col-md-" + input_col
        },
    },
}
</script>

