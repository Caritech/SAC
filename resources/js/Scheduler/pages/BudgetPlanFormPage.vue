<template>
  <div>
    <b-breadcrumb>
      <b-breadcrumb-item href="/service">Service</b-breadcrumb-item>
      <b-breadcrumb-item
        :href="'/service/budget_plan/client/'+client_info.id"
      >Client Budget Plan [ {{client_info.name}} ]</b-breadcrumb-item>
      <b-breadcrumb-item active>Budget Plan Info</b-breadcrumb-item>
    </b-breadcrumb>
    <div>
      <div class>
        <div class="row">
          <div class="col-md-6">
            <h5>Client Info</h5>
            <table class="table table-sm table-bordered">
              <tr class="bg-default">
                <th>Client No</th>
                <th>Client Name</th>
                <th>Gender</th>
                <th>DOB</th>
              </tr>
              <tr class="bg-default">
                <td>{{ client_info.client_no }}</td>
                <td>{{ client_info.name }}</td>
                <td>{{ client_info.gender }}</td>
                <td>{{ client_info.dob }}</td>
              </tr>
            </table>
          </div>
          <div class="col-md-6">
            <h5>Agreement Info</h5>
            <table class="table table-sm table-bordered table-striped table-hover">
              <tr>
                <th>Service</th>
                <th>Level</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Review Date</th>
                <th>Case Worker</th>
                <th>Remark</th>
              </tr>
              <tr>
                <td>{{ agreement.service_code }}</td>
                <td>{{ agreement.level }}</td>
                <td>{{ agreement.start_date }}</td>
                <td>{{ agreement.end_date }}</td>
                <td>{{ agreement.review_date }}</td>
                <td>{{ agreement.case_worker }}</td>
                <td>{{ agreement.remark }}</td>
              </tr>
            </table>
          </div>
        </div>

        <div class="row">
          <div class="col-md-6">
            <div class="card">
              <div class="card-header">Budget Info</div>
              <div class="card-body">
                <div class="row form-group-sm">
                  <label class="col-md-6">Active :</label>
                  <div class="col-md-6">
                    <b-form-checkbox value="1" unchecked-value="0" v-model="budget_plan.is_active"></b-form-checkbox>
                  </div>
                </div>
                <div class="row form-group-sm">
                  <label class="col-md-6">Level :</label>
                  <div class="col-md-6">
                    <cool-select
                      size="sm"
                      single-line
                      :items="lists_level"
                      v-model="budget_plan.level"
                    ></cool-select>
                  </div>
                </div>

                <div class="row form-group-sm">
                  <label class="col-md-6">Start Date :</label>
                  <div class="col-md-6">
                    <date-picker v-model="budget_plan.start_date"></date-picker>
                  </div>
                </div>

                <div class="row form-group-sm">
                  <label class="col-md-6">End Date :</label>
                  <div class="col-md-6">
                    <date-picker v-model="budget_plan.end_date"></date-picker>
                  </div>
                </div>

                <div class="row form-group-sm">
                  <label class="col-md-6">Review Date :</label>
                  <div class="col-md-6">
                    <date-picker v-model="budget_plan.review_date"></date-picker>
                  </div>
                </div>

                <div class="row">
                  <label class="col-md-6">Remark :</label>
                  <div class="col-md-6">
                    <textarea class="form-control textarea" rows="3" v-model="budget_plan.remark"></textarea>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="col-md-6">
            <div class="card mb-3">
              <div class="card-header">Select Price Plan</div>
              <div class="card-body">
                <div class="mb-2">
                  <cool-select
                    size="sm"
                    single-line
                    :items="lists_price_plan"
                    v-model="budget_plan.price_plan_id"
                    itemText="text"
                    itemValue="id"
                  ></cool-select>
                </div>
                <button
                  class="btn btn-sm btn-block btn-outline-success"
                  @click="updatePricePlan"
                >Apply Price Plan</button>
              </div>
            </div>
            <div class="card">
              <div class="card-header">Evergreen College</div>
              <div class="card-body">
                <table class="table table-bordered table-sm">
                  <tr>
                    <th></th>
                    <th class="text-center" v-for="d in lists_evergreen_day ">{{d}}</th>
                    <th class="text-center">Fee ( $ )</th>
                  </tr>
                  <tr v-for="ampm in ['AM','PM']">
                    <td>{{ampm}}</td>
                    <td class="text-center" v-for="d in lists_evergreen_day ">
                      <checkbox v-model="budget_plan_evergreen['Chk'+d+ampm]" />
                    </td>
                    <td class="text-center">{{budget_plan_evergreen[ampm+'Fee']}}</td>
                  </tr>
                  <tr>
                    <td>Cost</td>
                    <td
                      class="text-center"
                      v-for="d in lists_evergreen_day"
                    >{{calculated_evergreen[d]}}</td>
                    <td class="text-center">{{calculated_evergreen.total}}</td>
                  </tr>
                </table>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6" v-for=" (group_item,title) in calculated_group_item">
            <div class="card mt-4">
              <div class="card-header">{{title}}</div>
              <div class="card-body">
                <table class="table table-sm table-bordered">
                  <thead>
                    <tr>
                      <th>Item</th>
                      <th style="width:40%">Value</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="item in group_item">
                      <template v-if="item.input_type == 'user_enter'">
                        <td>{{item.title}}</td>
                        <td>
                          <b-form-input size="sm" placeholder="Enter value" v-model="item.value"></b-form-input>
                        </td>
                      </template>
                      <template v-if="item.input_type == 'percentage'">
                        <td>{{item.title}} (%)</td>
                        <td>
                          <b-form-input size="sm" placeholder="Enter value" v-model="item.value"></b-form-input>
                        </td>
                      </template>
                      <template v-else-if="item.input_type == 'checkbox'">
                        <td>
                          {{item.title}}
                          <small>( $ {{item.value}} )</small>
                        </td>
                        <td>
                          <checkbox size="lg" v-model="item.is_checked" />
                        </td>
                      </template>
                      <template v-else-if="item.input_type == 'fixed'">
                        <td>{{item.title}}</td>
                        <td>
                          <b-form-input size="sm" placeholder="Enter value" v-model="item.value"></b-form-input>
                        </td>
                      </template>
                    </tr>
                  </tbody>
                  <tfoot>
                    <tr>
                      <td>Total</td>
                      <td>
                        <span v-for="(total,income_type) in calculated_group_item_cost[title]">
                          <template v-if="total > 0">
                            <b>
                              {{total | numeral('$ 0,0.00')}}
                              <small>({{income_type}})</small>
                            </b>
                          </template>
                        </span>
                      </td>
                    </tr>
                  </tfoot>
                </table>
              </div>
            </div>
          </div>
        </div>

        <div class="card mt-4">
          <div class="card-header">
            <div class="row">
              <div class="col-md-6">Service Price</div>

              <div class="col-md-6 row">
                <div class="col-6">
                  <cool-select
                    size="sm"
                    single-line
                    :items="lists_price_plan_breakdown"
                    itemText="text"
                    itemValue="id"
                    v-model="new_service_item_id"
                  ></cool-select>
                </div>
                <div class="col-6">
                  <Button
                    class="btn btn-sm btn-block btn-success"
                    @click="addNewServiceItem"
                  >Add new Service Item</Button>
                </div>
              </div>
            </div>
          </div>
          <div class="card-body">
            <div class="row">
              <template v-for="(g_breakdown,g_key) in group_breakdown">
                <div class="col-md-6" :key="g_key">
                  <table class="table table-bordered table-sm budget-plan-pricing-table">
                    <tr>
                      <td></td>
                      <td style="width:12%"></td>
                      <template v-for=" (d,d_key) in ['Week','Sat','Sun','Pub']">
                        <td :key="d_key" style="width:8%">{{d}} Day</td>
                        <td :key="'ot_'+d_key" style="width:8%">{{d}} Night</td>
                      </template>
                    </tr>
                    <template v-for="(breakdown,breakdown_key) in g_breakdown">
                      <tr :key="'breakdown_'+breakdown_key">
                        <td rowspan="2">
                          {{breakdown.breakdown_name}}
                          ({{breakdown.breakdown_uom}})
                          <br />
                          <button
                            class="btn btn-sm text-danger"
                            @click="deleteServiceBreakdownItem(breakdown.id)"
                          >
                            <i class="fa fa-minus-circle"></i>
                          </button>
                        </td>
                        <td>
                          <span v-if="breakdown.breakdown_uom=='amount'">Price</span>
                          <span v-else>Unit</span>
                        </td>
                        <template v-for=" (d,d_key) in lists_breakdown_day">
                          <td :key="'normal_'+d_key">
                            <b-form-input
                              class="text-right"
                              v-b-tooltip.hover
                              :title="generateTooltip(breakdown,d)"
                              v-model="breakdown[d+'_unit']"
                              size="sm"
                              placeholder="unit"
                            ></b-form-input>
                          </td>
                          <td :key="'ot_'+d_key">
                            <b-form-input
                              class="text-right"
                              v-b-tooltip.hover
                              :title="generateTooltip(breakdown,d+'_ot')"
                              v-model="breakdown[d+'_ot_unit']"
                              size="sm"
                              placeholder="unit"
                            ></b-form-input>
                          </td>
                        </template>
                      </tr>
                      <tr :key="breakdown_key">
                        <td>Cost ($)</td>
                        <template v-for=" (d,d_key) in lists_breakdown_day">
                          <td
                            class="text-right font-weight-bold"
                            :key="'normal_'+d_key"
                          >{{breakdown[d+'_cost'] | numeral('0,0')}}</td>
                          <td
                            class="text-right font-weight-bold"
                            :key="'ot_'+d_key"
                          >{{breakdown[d+'_ot_cost'] | numeral('0,0')}}</td>
                        </template>
                      </tr>
                    </template>
                  </table>
                </div>
              </template>
            </div>
          </div>
        </div>

        <div class="card mt-4">
          <div class="card-header text-center">
            <h4>Budget Balance Information</h4>
          </div>
          <div class="card-body">
            <table class="table">
              <tr>
                <td></td>
                <th class="text-right">Weekly</th>
                <th class="text-right">Monthly</th>
                <th class="text-right">Yearly</th>
              </tr>
              <template v-for=" (data,balance_type) in calculated_income_expense">
                <tr>
                  <td class="font-weight-bold" colspan="5">{{balance_type.toUpperCase()}}</td>
                </tr>
                <tr v-for="(item,item_name) in data">
                  <td>{{item.title}}</td>
                  <td class="text-right">{{item.weekly | numeral('$ 0,0.00')}}</td>
                  <td class="text-right">{{item.monthly | numeral('$ 0,0.00')}}</td>
                  <td class="text-right">{{item.yearly | numeral('$ 0,0.00')}}</td>
                </tr>
                <tr>
                  <td class="text-right font-weight-bold">{{balance_type.toUpperCase()}} TOTAL</td>
                  <td
                    class="text-right"
                  >{{calculated_balance[balance_type].weekly | numeral('$ 0,0.00')}}</td>
                  <td
                    class="text-right"
                  >{{calculated_balance[balance_type].monthly | numeral('$ 0,0.00')}}</td>
                  <td
                    class="text-right"
                  >{{calculated_balance[balance_type].yearly | numeral('$ 0,0.00')}}</td>
                </tr>
              </template>
              <tr
                class="text-white font-weight-bold"
                :class="{'bg-danger':calculated_balance['balance'].weekly<0,'bg-success':calculated_balance['balance'].weekly>=0,}"
              >
                <td class="font-weight-bold">Budget Balance</td>
                <td
                  class="text-right"
                >{{calculated_balance['balance'].weekly | numeral('$ 0,0.00')}}</td>
                <td
                  class="text-right"
                >{{calculated_balance['balance'].monthly | numeral('$ 0,0.00')}}</td>
                <td
                  class="text-right"
                >{{calculated_balance['balance'].yearly | numeral('$ 0,0.00')}}</td>
              </tr>
            </table>
          </div>
        </div>
      </div>

      <!-- <user-timestamp :data="budget_plan"></user-timestamp> -->

      <div class>
        <div class="col-md-12 text-center">
          <button class="btn btn-success" @click="saveBudgetPlan">
            <i class="fa fa-save"></i>
            Save
          </button>
        </div>
      </div>
    </div>
    <fab
      position="bottom-right"
      bg-color="#f44336"
      :actions="fabActions"
      @save="saveBudgetPlan"
      @print="printBudgetPlan"
      icon-size="small"
      main-tooltip="More Actions"
    ></fab>
  </div>
</template>

<script>
export default {
  data() {
    return {
      fabActions: [
        {
          color: "#43a047",
          name: "save",
          icon: "save",
          tooltip: "Save Budget Plan",
        },
        {
          color: "#e53935",
          name: "print",
          icon: "print",
          tooltip: "Print Budget Plan",
        },
      ],
      lists_service: [],
      lists_client: [],
      lists_level: [],
      lists_price_plan: [],
      lists_price_plan_breakdown: [],
      lists_breakdown_day: ["wk", "sat", "sun", "pb"],
      lists_evergreen_day: ["Mon", "Tue", "Wed", "Thu", "Fri"],
      test: "",

      budget_plan_id: null,

      client_info: {},
      agreement: {},

      budget_plan: {},
      budget_plan_breakdown: [],
      budget_plan_evergreen: {},
      budget_plan_group_item: [],

      new_service_item_id: null,
    };
  },
  computed: {
    calculated_group_item() {
      /*
            1. Group the item based on group id
        */
      var $vm = this;
      var items = $vm.budget_plan_group_item;
      var new_items = {};
      items.forEach(function (v, k) {
        new_items[v.group_name] = [];
      });
      items.forEach(function (v, k) {
        new_items[v.group_name].push(v);
      });

      return new_items;
    },
    calculated_group_item_cost() {
      /*
            1. Group the item based on group id
        */
      var $vm = this;
      var items = $vm.budget_plan_group_item;
      var group_cost = {};
      items.forEach(function (v, k) {
        group_cost[v.group_name] = { income: 0, expense: 0 };
      });
      items.forEach(function (v, k) {
        var apply_sum = true;
        if (v.input_type == "checkbox" && v.is_checked != 1) {
          apply_sum = false;
        }
        if (apply_sum) {
          var value = parseFloat(v.value);
          if (!isNaN(value)) {
            group_cost[v.group_name][v.type] += parseFloat(v.value);
          }
        }
      });

      return group_cost;
    },
    calculated_evergreen() {
      var $vm = this;
      var evergreen = $vm.budget_plan_evergreen;
      var new_evergreen = {};
      var total = 0;
      this.lists_evergreen_day.forEach(function (v) {
        let both_checked = evergreen.ChkAM == 1 && evergreen.ChkPM == 1;
        let fee = evergreen["Chk" + v + "AM"] == 1 ? evergreen.AMFee : 0;
        fee += evergreen["Chk" + v + "PM"] == 1 ? evergreen.PMFee : 0;
        if (both_checked) {
          fee = evergreen.CombinedFee;
        }
        new_evergreen[v] = fee;
        total += fee;
      });
      new_evergreen["total"] = total;
      return new_evergreen;
    },
    calculated_breakdown() {
      var $vm = this;
      var breakdown = $vm.budget_plan_breakdown;
      var new_breakdown = [];
      breakdown.forEach(function (v, k) {
        $vm.lists_breakdown_day.forEach(function (day) {
          if (v.breakdown_uom == "amount") {
            v[day + "_price"] =
              v[day + "_price"] == 0 ? 1.0 : v[day + "_price"];
            v[day + "_ot_price"] =
              v[day + "_ot_price"] == 0 ? 1.0 : v[day + "_ot_price"];

            v[day + "_cost"] = v[day + "_unit"] * v[day + "_price"];
            v[day + "_ot_cost"] = v[day + "_ot_unit"] * v[day + "_ot_price"];
          } else {
            v[day + "_cost"] = v[day + "_unit"] * v[day + "_price"];
            v[day + "_ot_cost"] = v[day + "_ot_unit"] * v[day + "_ot_price"];
          }
        });
        new_breakdown.push(v);
      });
      return new_breakdown;
    },
    group_breakdown() {
      var $vm = this;
      var new_breakdown = this.calculated_breakdown;
      //break into two group by modulus
      var group = { 1: [], 2: [] };
      new_breakdown.forEach(function (v, k) {
        if (k % 2 == 0) {
          group[1].push(v);
        } else {
          group[2].push(v);
        }
      });

      return group;
    },
    /*
        Calculate All and group By Income, Expense -> Weekly, Monthly, Yearly
    */
    calculated_income_expense() {
      var $vm = this;
      var service_item = this.calculated_breakdown;
      var evergreen = this.calculated_evergreen;
      var item_group = this.calculated_group_item_cost;
      var balance = { income: [], expense: [] };

      //service item
      service_item.forEach(function (item, k) {
        var item_cost = 0;
        $vm.lists_breakdown_day.forEach(function (day) {
          item_cost += item[day + "_cost"] + item[day + "_ot_cost"];
        });
        if (item_cost != 0) {
          balance["expense"].push({
            title: item.breakdown_name,
            weekly: item_cost,
            monthly: item_cost * 4,
            yearly: item_cost * 52,
          });
        }
      });

      //evergreen
      balance["expense"].push({
        title: "Evergreen College",
        weekly: evergreen.total,
        monthly: evergreen.total * 4,
        yearly: evergreen.total * 52,
      });

      for (var group_name in item_group) {
        for (var income_type in item_group[group_name]) {
          var total = item_group[group_name][income_type];
          if (total != 0) {
            balance[income_type].push({
              title: group_name,
              weekly: total,
              monthly: total * 4,
              yearly: total * 52,
            });
          }
        }
      }

      return balance;
    },
    calculated_balance() {
      var income_expense = this.calculated_income_expense;
      var income = income_expense.income;
      var expense = income_expense.expense;

      var total_income = { weekly: 0, monthly: 0, yearly: 0 };
      var total_expense = { weekly: 0, monthly: 0, yearly: 0 };

      income.forEach(function (v, k) {
        total_income["weekly"] += v.weekly;
        total_income["monthly"] += v.monthly;
        total_income["yearly"] += v.yearly;
      });
      expense.forEach(function (v, k) {
        total_expense["weekly"] += v.weekly;
        total_expense["monthly"] += v.monthly;
        total_expense["yearly"] += v.yearly;
      });

      var balance = {
        weekly: total_income["weekly"] - total_expense["weekly"],
        monthly: total_income["monthly"] - total_expense["monthly"],
        yearly: total_income["yearly"] - total_expense["yearly"],
      };
      return {
        income: total_income,
        expense: total_expense,
        balance: balance,
      };
    },
  },
  methods: {
    generateTooltip(breakdown, day) {
      if (breakdown.breakdown_uom == "amount") {
        let price = breakdown[day + "_price"];
        if (price == 0) {
          return "No modifier";
        } else {
          return "Modifier " + price + "x";
        }
      } else {
        return (
          "$ " +
          breakdown[day + "_price"] +
          " per unit | $ " +
          breakdown[day + "_half_price"] +
          " per half unit"
        );
      }
    },
    getBudgetPlanDetail() {
      axios
        .get("/service/r/get_budget_plan_detail", {
          params: {
            budget_plan_id: this.budget_plan_id,
          },
        })
        .then((response) => {
          let data = response.data;
          this.budget_plan = data.budget_plan;
          this.client_info = data.client;
          this.lists_level = data.lists_level;
          this.agreement = data.agreement;
          this.budget_plan_breakdown = data.budget_plan_breakdown;
          this.budget_plan_evergreen = data.budget_plan_evergreen;
          this.budget_plan_group_item = data.budget_plan_group_item;

          this.lists_price_plan = data.lists_price_plan;
          this.lists_price_plan_breakdown = data.lists_price_plan_breakdown;
          //this.getClientInfo();
        });
    },
    printBudgetPlan() {
      Vue.swal("Not Ready");
    },
    saveBudgetPlan() {
      axios
        .post("/service/r/save_budget_plan", {
          budget_plan_id: this.budget_plan_id,
          budget_plan: this.budget_plan,
          budget_plan_breakdown: this.budget_plan_breakdown,
          budget_plan_evergreen: this.budget_plan_evergreen,
          budget_plan_group_item: this.budget_plan_group_item,
        })
        .then((response) => {
          Vue.swal("Success", "Record has been saved", "success");
          //location.reload();
        });
    },
    updatePricePlan() {
      this.$swal({
        title: "Confirmation",
        text: "Confirm to add new budget plan ?",
        showCancelButton: true,
      }).then((result) => {
        if (result.value) {
          axios
            .post("/service/r/update_budget_plan_pricing", {
              budget_plan_id: this.budget_plan.id,
              price_plan_id: this.budget_plan.price_plan_id,
            })
            .then((res) => {
              Vue.swal(
                "Success",
                "Budget Plan Pricing has been updated",
                "success"
              );
              location.reload();
            });
        }
      });
    },
    addNewServiceItem() {
      if (this.new_service_item_id == null || this.new_service_item_id == "") {
        Vue.swal("Error", "Service Item cannot be empty", "error");
        return;
      }
      this.$swal({
        title: "Confirmation",
        text: "Confirm to add new service item ?",
        showCancelButton: true,
      }).then((result) => {
        if (result.value) {
          axios
            .post("/service/r/budget_plan/add_new_service_item", {
              budget_plan_id: this.budget_plan.id,
              breakdown_id: this.new_service_item_id,
            })
            .then((res) => {
              Vue.swal("Success", "Record has been saved", "success");
              location.reload();
            });
        }
      });
    },
    deleteServiceBreakdownItem(breakdown_id) {
      this.$swal({
        title: "Confirmation",
        text: "Confirm to delete service item ?",
        showCancelButton: true,
      }).then((result) => {
        if (result.value) {
          axios
            .post("/service/r/budget_plan/delete_service_breakdown_item", {
              budget_plan_id: this.budget_plan.id,
              breakdown_id: breakdown_id,
            })
            .then((res) => {
              Vue.swal("Success", "Breakdown Item has been deleted", "success");
              location.reload();
            });
        }
      });
    },
  }, //end of method
  created: function () {
    let params = this.$route.params;
    this.budget_plan_id = params.budgetPlanId;
    if (this.budget_plan_id != null) {
      this.getBudgetPlanDetail();
    }
  },
};
</script>

<style>
.budget-plan-pricing-table td {
  font-size: 13px;
  vertical-align: middle;
}
</style>
