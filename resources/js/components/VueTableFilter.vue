<template>
  <div class="row">
    <div class="col-md-4 no-padding-right">
      <input type="text" v-model="filterText" class="form-control" @keyup.enter="doFilter" placeholder="Search...">
    </div>
    <div class="col-md-8">
        <button class="btn btn-sm btn-primary" @click="doFilter">Search</button>
        <button class="btn btn-sm btn-secondary" @click="resetFilter">Reset</button>
    </div>
  </div>
</template>
<script>

  export default {
    data () {
      return {
        filterText: ''
      }
    },
    methods: {
      doFilter () {
        this.$emit('update-search',this.filterText)
      },
      resetFilter () {
        this.filterText = '';
        this.$emit('reset-search')
      }
    }
  }
</script>
