<template>
  <div>
    <b-breadcrumb>
      <b-breadcrumb-item href="/service">Service</b-breadcrumb-item>
      <b-breadcrumb-item active>Budget Plan</b-breadcrumb-item>
    </b-breadcrumb>

    <my-vuetable api-url="/service/r/get_service_agreement_lists" :fields="col_fields">
      <template slot="actions" slot-scope="props">
        <a class="btn btn-outline-success" @click="editRow(props.rowData)">
          <i class="fa fa-edit"></i>
        </a>
        <a class="btn btn-outline-primary" @click="openBudgetPlan(props.rowData)">
          <i class="fa fa-file-invoice"></i>
        </a>
      </template>
    </my-vuetable>
  </div>
</template>

<script>
export default {
  data() {
    return {
      col_fields: [
        {
          name: "actions",
          title: "Option",
        },
        {
          name: "id",
          title: "ID",
          sortField: "id",
        },
        {
          name: "is_active",
          title: "Active",
          sortField: "is_active",
        },
        {
          name: "client_name",
          title: "Client",
          sortField: "client_name",
        },
        {
          name: "service_code",
          title: "Srv",
          sortField: "service_code",
        },
        {
          name: "level",
          title: "Lvl",
          sortField: "level",
        },
        {
          name: "start_date",
          title: "Start",
          sortField: "start_date",
        },
        {
          name: "end_date",
          title: "End",
          sortField: "end_date",
        },
        {
          name: "review_date",
          title: "Review Date",
          sortField: "review_date",
        },
        {
          name: "case_worker",
          title: "Case Worker",
          sortField: "case_worker",
        },
        // {
        //   name: "remark",
        //   title: "Remark",
        //   sortField: "remark",
        // },
        {
          name: "need_srv_in_holiday",
          title: "Holiday",
          sortField: "need_srv_in_holiday",
        },
      ],
    };
  },
  methods: {},
  created() {},
};
</script>
