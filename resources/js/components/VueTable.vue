<template>
  <div>
    <vuetable
      ref="vuetable"
      :api-url="apiUrl"
      :fields="fields"
      @vuetable:pagination-data="onPaginationData"
      :per-page="perPage"
      pagination-path
    >
      <slot></slot>
    </vuetable>
    <div class="col-md-12" style="padding-top:10px">
      <vuetable-pagination
        ref="pagination"
        :css="pagination"
        @vuetable-pagination:change-page="onChangePage"
      ></vuetable-pagination>
    </div>
  </div>
</template>
<script>
export default {
  data() {
    return {
      pagination: {
        wrapperClass: "pagination float-right",
        activeClass: "active",
        disabledClass: "disabled",
        pageClass: "page-item page-link",
        linkClass: "page-link",
        paginationClass: "pagination",
        paginationInfoClass: "float-left",
        dropdownClass: "form-control",
        icons: {
          first: "fa fa-angle-double-left",
          prev: "fa fa-angle-left",
          next: "fa fa-angle-right",
          last: "fa fa-angle-double-right",
        },
      },
    };
  },
  props: {
    fields: {
      type: Array,
    },
    perPage: {
      type: Number,
      default: 20,
    },
    apiUrl: {
      type: String,
    },
  },
  methods: {
    onPaginationData(paginationData) {
      this.$refs.pagination.setPaginationData(paginationData);
    },
    onChangePage(page) {
      this.$refs.vuetable.changePage(page);
    },
  },
};
</script>
