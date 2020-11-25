<template>
  <div>
    <good-search></good-search>

    <vuetable
      ref="vuetable"
      api-url="/contactinformation/r/get_contact"
      :fields="fields"
      pagination-path
      data-path="data"
      data-total="20"
      :per-page="10"
      @vuetable:pagination-data="onPaginationData"
    >
      <template slot="actions" slot-scope="props">
        <a class="btn btn-success" @click="editRow(props.rowData)">
          <i class="fa fa-edit"></i>
        </a>
      </template>
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
import GoodSearch from "../components/GoodSearch";

export default {
  components: {
    "good-search": GoodSearch,
  },
  data() {
    return {
      fields: [
        {
          name: "actions",
          title: "Action",
        },
        {
          name: "FirstName",
          title: "Full Name",
          sortField: "name",
        },
        {
          name: "FirstName",
          title: "Active",
          sortField: "name",
        },
        {
          name: "FirstName",
          title: "Gender",
          sortField: "email",
        },
        {
          name: "FirstName",
          title: "DOB",
          sortField: "email",
        },
        {
          name: "FirstName",
          title: "Suburb",
          sortField: "email",
        },
        {
          name: "FirstName",
          title: "State",
          sortField: "email",
        },

        {
          name: "FirstName",
          title: "Postcode",
          sortField: "email",
        },
        {
          name: "FirstName",
          title: "Home Phone",
          sortField: "email",
        },
        {
          name: "FirstName",
          title: "Mobile Phone",
          sortField: "email",
        },
        {
          name: "FirstName",
          title: "Region",
          sortField: "email",
        },
        {
          name: "FirstName",
          title: "Note",
          sortField: "email",
        },
      ],
    };
  },
  methods: {
    onPaginationData(paginationData) {
      console.log(paginationData);
      this.$refs.pagination.setPaginationData(paginationData);
    },
    onChangePage(page) {
      this.$refs.vuetable.changePage(page);
    },
  },
};
</script>
