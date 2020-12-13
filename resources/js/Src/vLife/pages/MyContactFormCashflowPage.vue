<template>
  <div>
    <ul class="nav nav-pills justify-content-center">
      <li class="nav-item">
        <a class="nav-link active" data-toggle="pill" href="#income">Income</a>
      </li>
      <li class="nav-item">
        <!-- <a class="nav-link" data-toggle="pill" href="#expenses">Expenses</a> -->
        <button class="btn btn-secondary" disabled style="font-size: initial">
          Expenses
        </button>
      </li>
    </ul>
    <div class="tab-content">
      <div class="tab-pane container active" id="income">
        <div class="card">
          <div class="card-header">
            <span class="title-cyan">Income</span>
            <span class="float-right">
              <router-link :to="add_income_btn" class="btn btn-sm btn-success"
                ><i class="fas fa-user-plus"></i> Add Income</router-link
              >
            </span>
          </div>
          <div class="card-body">
            <my-vuetable
              :api-url="cashflow_income_api"
              :per-page="10"
              :fields="contact_fields"
              ref="myVuetable"
              :transform="transformCashflowIncome"
            >
              <template
                slot="actions"
                slot-scope="props"
                v-if="props.rowData.id"
              >
                <a
                  class="btn btn-outline-success"
                  @click="editIncome(props.rowData)"
                >
                  <i class="fa fa-edit"></i>
                </a>
                <a
                  class="btn btn-outline-primary"
                  @click="deleteIncome(props.rowData)"
                >
                  <i class="fas fa-trash-alt"></i>
                </a>
              </template>
              <template
                slot="checkbox"
                slot-scope="props"
                v-if="props.rowData.id"
              >
                <b-form-checkbox
                  value="1"
                  @change="inclIncome(props.rowData)"
                  v-model="props.rowData.incl"
                ></b-form-checkbox>
              </template>
              <template slot="description" slot-scope="props">
                <strong v-if="!props.rowData.id">{{
                  props.rowData.description
                }}</strong>
                <template v-else="!props.rowData.id">{{
                  props.rowData.description
                }}</template>
              </template>
              <template slot="amount" slot-scope="props">
                <strong v-if="!props.rowData.id"
                  >$
                  {{ formatThousandsSeparator(props.rowData.amount) }}
                  / Per Month</strong
                >
                <template v-else="!props.rowData.id"
                  >$
                  {{ formatThousandsSeparator(props.rowData.amount) }}</template
                >
              </template>
            </my-vuetable>
          </div>
        </div>
      </div>

      <div class="tab-pane container fade" id="expenses"></div>
    </div>
  </div>
</template>

<script>
import MyContactFormProfilePage from "./MyContactFormProfilePage";
export default {
  components: {
    "contact-profile": MyContactFormProfilePage,
  },
  data() {
    return {
      id: "",
      cashflow_income_api: "",
      contact_fields: [
        {
          name: "actions",
          title: "Actions",
        },
        {
          name: "checkbox",
          title: "Incl?",
        },
        {
          name: "description",
          title: "Description",
          sortField: "description",
        },
        {
          name: "type",
          title: "Type",
          sortField: "type",
        },
        {
          name: "frequency",
          title: "Frequency",
          sortField: "frequency",
        },
        {
          name: "amount",
          title: "Amount",
          sortField: "amount",
        },

        {
          name: "start_age",
          title: "Start",
          sortField: "start_age",
        },
        {
          name: "end_age",
          title: "End",
          sortField: "end_age",
        },
        {
          name: "growth",
          title: "Growth",
          sortField: "growth",
        },
        {
          name: "tax",
          title: "Tax",
          sortField: "tax",
        },
        {
          name: "epf",
          title: "EPF",
          sortField: "epf",
        },
      ],
    };
  },
  methods: {
    checkEmpty(val) {
      if (!val) {
        val = "-";
      }
      return val;
    },
    transformCashflowIncome(datas) {
      var transformed = datas;
      var cur_data = datas.data;
      var total_amt = 0;

      for (var i = 0; i < cur_data.length; i++) {
        total_amt += parseFloat(cur_data[i].amount);
      }

      transformed.data.push({
        description: "Total",
        amount: total_amt.toFixed(2),
      });

      return transformed;
    },
    editIncome(data) {
      let id = data.id;
      this.$router.push("/my_contact/cashflow/income/" + id + "/edit");
    },
    deleteIncome(data) {
      let id = data.id;
      Vue.swal({
        title: "Are you sure?",
        text: "It will be inactive this cashflow record!",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes",
        showLoaderOnConfirm: true,

        preConfirm: function () {
          return new Promise(function (resolve) {
            axios
              .post("/vlife/my_contact/cashflow/income/inactive", {
                id: id,
              })
              .then((response) => {
                /*swal('Event Status Updated!', response.message, response.status);*/
                console.log(response),
                  Vue.swal(
                    response.data.title,
                    response.data.message,
                    response.data.status
                  );
                setTimeout(function () {
                  window.location.reload(); // you can pass true to reload function to ignore the client cache and reload from the server
                }, 2000);
              });
          });
        },
        allowOutsideClick: false,
      });
    },
    inclIncome(data) {
      let id = data.id;
      Vue.swal({
        title: "Are you sure?",
        text: "It will be change the incl status!",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes",
        showLoaderOnConfirm: true,

        preConfirm: function () {
          return new Promise(function (resolve) {
            axios
              .post("/vlife/my_contact/cashflow/income/update_incl", {
                id: id,
              })
              .then((response) => {
                /*swal('Event Status Updated!', response.message, response.status);*/
                console.log(response),
                  Vue.swal(
                    response.data.title,
                    response.data.message,
                    response.data.status
                  );
                setTimeout(function () {
                  window.location.reload(); // you can pass true to reload function to ignore the client cache and reload from the server
                }, 2000);
              });
          });
        },
        allowOutsideClick: false,
      });

    },
    formatThousandsSeparator(num) {
      return Number(Math.ceil(num)).toLocaleString();
    },
  },
  created() {
    var vm = this;
    vm.id = vm.$route.params.id;
    vm.add_income_btn =
      "/my_contact/cashflow/income/" + vm.$route.params.id + "/create";
    vm.cashflow_income_api =
      "/vlife/get_contact_cashflow_income/" + vm.$route.params.id;
  },
};
</script>
