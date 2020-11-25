
import Vue from "vue";
const InputText = Vue.component("input-text", {
    props: [],
    render(h, context) {
        return (
            <b-form-input id="range-1" v-model="value" type="range" min="0" max="5"></b-form-input>
        );
    }
});

const InputCheckbox = Vue.component("input-checkbox", {
    props: {
        title: {
            type: String,
            default: ""
        },
        value: {
            type: String,
            default: ""
        },
        id: {
            type: String,
            default: ""
        },
        name: {
            type: String,
            default: ""
        },
        tooltip: {
            type: String,
            default: ""
        }

    },
    render: function (h, context) {
        return (
            <span title={this.title}>
                <b-form-checkbox
                    id={this.id}
                    name={this.name}
                    value="1"
                    unchecked-value="0"

                >
                    {this.title}
                </b-form-checkbox>
            </span>
        );
    }
});

export { InputCheckbox };
export default InputText;

