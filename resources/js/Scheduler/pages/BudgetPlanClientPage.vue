<template>
  <div>
    <b-breadcrumb>
      <b-breadcrumb-item href="/service">Service</b-breadcrumb-item>
      <b-breadcrumb-item href="/service/service_agreement">Agreement</b-breadcrumb-item>
      <b-breadcrumb-item active>Client Budget Plan</b-breadcrumb-item>
    </b-breadcrumb>
    <div class="row">
      <div class="col-md-4">
        <div class="card">
          <div class="card-header">Client Info</div>
          <div class="card-body">
            <div class="row">
              <label class="col-6">ID</label>
              <label class="col-6">{{client.id}}</label>
            </div>
            <div class="row">
              <label class="col-6">Client No</label>
              <label class="col-6">{{client.client_no}}</label>
            </div>
            <div class="row">
              <label class="col-6">Client Name</label>
              <label class="col-6">{{client.name}}</label>
            </div>
            <div class="row">
              <label class="col-6">Gender</label>
              <label class="col-6">{{client.gender}}</label>
            </div>
            <div class="row">
              <label class="col-6">DOB</label>
              <label class="col-6">{{client.dob}}</label>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-8">
        <div class="card">
          <div class="card-header">
            Agreement Lists
            <router-link
              class="btn btn-sm btn-success float-right"
              :to="'/service_agreement/create?client_id='+client_id"
              target="_blank"
            >Add New Agreement</router-link>
          </div>
          <div class="card-body">
            <my-vuetable
              ref="vuetable"
              api-url="/service/r/get_service_agreement_lists"
              :append-params="{client_id:client_id}"
              :per-page="2"
              :fields="agreement_fields"
            >
              <template slot="actions" slot-scope="props">
                <router-link
                  :to="'/service_agreement/'+props.rowData.id+'/edit'"
                  target="_blank"
                  class="btn btn-outline-success"
                >
                  <i class="fa fa-arrow-right"></i>
                </router-link>
              </template>
              <template slot="remark" slot-scope="props">
                <span
                  v-if="props.rowData.remark != '' && props.rowData.remark != null"
                  v-b-tooltip.hover.left
                  :title="props.rowData.remark"
                >
                  <i class="fa fa-sticky-note"></i>
                </span>
              </template>
            </my-vuetable>
          </div>
        </div>
      </div>
    </div>
    <div class="row mt-3">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            Budget Plan Lists
            <span class="float-right">
              <button
                class="btn btn-sm btn-success"
                @click="addNewBudgetPlanPopUp"
              >Add New Budget Plan</button>
            </span>
          </div>
          <div class="card-body">
            <my-vuetable
              api-url="/service/r/get_client_budget_plan_lists"
              :append-params="{
                  'client_id': client_id
              }"
              :per-page="10"
              :fields="budget_plan_fields"
            >
              <template slot="actions" slot-scope="props">
                <a class="btn btn-outline-success" @click="goToBudgetPlan(props.rowData)">
                  <i class="fa fa-arrow-right"></i>
                </a>
              </template>
              <template slot="remark" slot-scope="props">
                <span
                  v-if="props.rowData.remark != '' && props.rowData.remark != null"
                  v-b-tooltip.hover.left
                  :title="props.rowData.remark"
                >
                  <i class="fa fa-sticky-note"></i>
                </span>
              </template>
            </my-vuetable>
          </div>
        </div>
      </div>
    </div>
    <b-modal :title="'Add New Budget Plan'" ref="modal-add-new-budget-plan" hide-footer>
      <label class="label-control">Service Agreement</label>
      <cool-select
        size="sm"
        :items="lists_agreement"
        v-model="new_budget_plan.agreement_id"
        itemText="text"
        itemValue="id"
      ></cool-select>
      <label class="label-control">Start Date</label>
      <date-picker v-model="new_budget_plan.start_date"></date-picker>
      <label class="label-control">End Date</label>
      <date-picker v-model="new_budget_plan.end_date"></date-picker>
      <label class="label-control">Remark</label>
      <b-form-textarea
        id="textarea"
        v-model="new_budget_plan.remark"
        placeholder="Remark ..."
        rows="3"
      ></b-form-textarea>
      <b-button class="mt-3" variant="success" block @click="addNewBudgetPlan">Add Budget Plan</b-button>
      <b-button
        class="mt-2"
        variant="outline-danger"
        block
        @click="closeModalAddNewBudgetPlan"
      >Close</b-button>
    </b-modal>
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
      client_id: null,
      client: {},
      lists_agreement: [],
      lists_budget_plan: [],
      new_budget_plan: {},
      agreement_fields: [
        {
          name: "actions",
          title: "Option",
        },
        {
          name: "service_id",
          title: "Srv",
          sortField: "service_id",
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
          title: "Review",
          sortField: "review_date",
        },
        {
          name: "casr_worker",
          title: "Case Worker",
          sortField: "casr_worker",
        },
        {
          name: "remark",
          title: "Remark",
        },
      ],
      budget_plan_fields: [
        {
          name: "actions",
          title: "Option",
        },
        {
          name: "id",
          title: "Budget Plan ID",
          sortField: "id",
        },
        {
          name: "agreement_id",
          title: "Agreement ID",
          sortField: "agreement_id",
        },
        {
          name: "price_plan_id",
          title: "Price Plan",
          sortField: "price_plan_id",
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
          title: "Review",
          sortField: "review_date",
        },
        {
          name: "remark",
          title: "Remark",
        },
      ],
    };
  },
  methods: {
    async getClientBudgetPlan() {
      await axios
        .get("/service/r/get_client_budget_plan", {
          params: {
            client_id: this.client_id,
          },
        })
        .then((response) => {
          var res = response.data;
          this.client = res.client;
          this.lists_agreement = res.lists_agreement;
        });
    },

    goToBudgetPlan(budgetPlanData) {
      let budget_plan_id = budgetPlanData.id;
      this.$router.push("/budget_plan/" + budget_plan_id + "/edit");
    },
    addNewBudgetPlanPopUp() {
      this.$refs["modal-add-new-budget-plan"].show();
    },
    closeModalAddNewBudgetPlan() {
      this.$refs["modal-add-new-budget-plan"].hide();
    },
    addNewBudgetPlan() {
      this.$swal({
        title: "Confirmation",
        text: "Confirm to add new budget plan ?",
        showCancelButton: true,
      }).then((result) => {
        if (result.value) {
          axios
            .post("/service/r/create_budgte_plan", {
              client_id: this.client_id,
              budget_plan: this.new_budget_plan,
            })
            .then((res) => {
              var data = res.data;
              if (data.errors != null) {
                Vue.swal("Validation Error", data.error_message, "error");
              } else {
                Vue.swal("Success", "Record has been saved", "success");
                location.reload();
              }
            });
        }
      });
    },
  },
  created() {
    let params = this.$route.params;
    this.client_id = params.clientId;
    this.getClientBudgetPlan();
  },
};
</script>
