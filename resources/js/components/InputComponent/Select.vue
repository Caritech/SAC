<template>
    <div>
        <template v-if="mode == 'vue'">
            <cool-select
                v-if="computedItems.length > 0"
                :size="size"
                single-line
                :items="computedItems"
                :itemText="itemText"
                :itemValue="itemValue"
                :value="computedValue"
                :placeholder="placeholder"
                @input="$emit('input', $event)"
                @select="$emit('select', $event)"
                :readonly="readonly"
            ></cool-select>
            <span v-else>-- No Option --</span>
        </template>
        <template v-else>

            <b-form-select
                :name="name"
                :size="size"
                :options="computedItems"
                :value="computedValue"
                :placeholder="placeholder"
                @input="$emit('input', $event)"
                @select="$emit('select', $event)"
                :readonly="readonly"
            >
                <template
                    #first
                    v-if="placeholder!=''"
                >
                    <b-form-select-option :value="''">
                        {{placeholder}}
                    </b-form-select-option>
                </template>
            </b-form-select>
        </template>
    </div>
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
        /*
            available mode:
            vue: use cool select (cannot set name)
            html: use bootstrap select
        */
        mode: {
            type: String,
            default: "html",
        },
        name: {
            type: String,
            default: "",
        },
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
        readonly: {
            type: Boolean,
            default: false,
        },
    },
    computed: {
        computedItems() {
            var string_key_items = []
            var items = this.items
            var item_value = this.itemValue

            for (let i in items) {
                var new_item = items[i]
                if (new_item[item_value] != null) {
                    new_item[item_value] = new_item[item_value].toString()
                    string_key_items.push(new_item)
                }
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

<style>
.IZ-select__input--readonly input {
    background: #e9ecef !important; /*same as bootstrap disable color code*/
}
</style>