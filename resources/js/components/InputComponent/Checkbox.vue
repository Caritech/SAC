
<template>
  <b-form-checkbox
    :id="id"
    @change="$emit('input', $event)"
    :name="name"
    value="1"
    :checked="value"
    unchecked-value="0"
    :size="size"
  >{{title}}</b-form-checkbox>
</template>
<script>
export default {
  name: "checkbox",
  props: {
    size: {
      type: String,
      default: "",
    },
    id: {
      type: String,
      default: "",
    },
    name: {
      type: String,
      default: "",
    },
    title: {
      type: String,
      default: "",
    },
    value: {
      default: 0,
    },
  },
};
</script>
