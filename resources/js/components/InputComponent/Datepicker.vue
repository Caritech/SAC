<template>
  <datepicker
    :class="datepickerClass"
    :config="datepickerConfig()"
    :value="value"
    @input="$emit('input',$event)"
  ></datepicker>
</template>
<script>
import datePicker from "vue-bootstrap-datetimepicker";
import "pc-bootstrap4-datetimepicker/build/css/bootstrap-datetimepicker.css";

export default {
  name: "date-picker",
  components: {
    datepicker: datePicker,
  },
  methods: {
    datepickerConfig() {
      return {
        useCurrent: this.useCurrent,
        format: "YYYY-MM-DD",
      };
    },
  },
  props: {
    size: {
      type: String,
      default: "sm",
    },
    value: {
      type: String,
      default: "",
    },
    useCurrent: {
      type: Boolean,
      default: false,
    },
  },
  computed: {
    datepickerClass() {
      if (this.size == "sm") {
        return "form-control-sm";
      } else {
        return "";
      }
    },
  },
};
</script>
