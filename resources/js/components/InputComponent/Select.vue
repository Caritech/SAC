<template>
    <cool-select
        :size="size"
        single-line
        :items="computedItems"
        :itemText="itemText"
        :itemValue="itemValue"
        :value="computedValue"
        :placeholder="placeholder"
        @input="$emit('input', $event)"
    ></cool-select>
</template>

<script>
import { CoolSelect } from "vue-cool-select"
import { CoolSelectPlugin } from "vue-cool-select"

export default {
    name: "my-select",
    components: {
        "cool-select": CoolSelect,
    },
    props: {
        size: {
            type: String,
            default: "sm",
        },
        value: {
            default: "",
        },
        placeholder: {
            type: String,
            default: "",
        },
        items: {
            type: Array,
            default: () => {
                return []
            },
        },
        itemText: {
            type: String,
            default: "text",
        },
        itemValue: {
            type: String,
            default: "value",
        },
    },
    computed: {
        computedItems() {
            var string_key_items = []
            var items = this.items
            var item_value = this.itemValue

            for (let i in items) {
                var new_item = items[i]
                new_item[item_value] = new_item[item_value].toString()
                string_key_items.push(new_item)
            }
            return string_key_items
        },
        computedValue() {
            if (this.value != null) {
                return this.value.toString()
            } else {
                return null
            }
        },
    },
}
</script>
