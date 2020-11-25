<template>
  <div>
    <b-breadcrumb>
      <b-breadcrumb-item href="/setting">Setting</b-breadcrumb-item>
      <b-breadcrumb-item href="/setting/services">Service</b-breadcrumb-item>
      <b-breadcrumb-item active>Service Detail [{{ service.code }}]</b-breadcrumb-item>
    </b-breadcrumb>
    <div v-if="isLoaded">
      <div class="card">
        <div class="card-header">Service Detail</div>
        <div class="card-body">
          <div class="row">
            <div class="col-md-9">
              <div class="col-12 row">
                <div class="col-md-6">
                  <label>Code</label>
                  <input type="text" v-model="service.code" class="form-control" />
                </div>
                <div class="col-md-6">
                  <label>Name</label>
                  <input type="text" v-model="service.name" class="form-control" />
                </div>
              </div>
              <div class="col-12 mt-3">
                <b-form-checkbox
                  name="check-button"
                  value="1"
                  v-model="service.budget_enabled"
                  switch
                >Budget Enabled</b-form-checkbox>
                <b-form-checkbox
                  name="check-button"
                  value="1"
                  v-model="service.customer_invoice_enabled"
                  switch
                >Customer Invoice Enabled</b-form-checkbox>
                <b-form-checkbox
                  name="check-button"
                  value="1"
                  v-model="service.sw_payment_enabled"
                  switch
                >SW Payment Enabled</b-form-checkbox>
                <b-form-checkbox
                  name="check-button"
                  value="1"
                  v-model="service.dex_enabled"
                  switch
                >DEX Enabled</b-form-checkbox>
                <b-form-checkbox
                  name="check-button"
                  value="1"
                  v-model="service.careplan_enabled"
                  switch
                >Careplan Enabled</b-form-checkbox>
              </div>
            </div>
            <div class="col-md-3">
              <div class="card">
                <div class="card-header">Appearance</div>
                <div class="card-body">
                  <div class="row">
                    <div class="col-12 row">
                      <label class="col-9">Aspect Output</label>
                      <div class="col-3">
                        <span
                          class="badge"
                          :style="{
                                                    background:
                                                        service.css_background_color,
                                                    color:
                                                        service.css_text_color,
                                                    borderColor:
                                                        service.css_border_color
                                                }"
                        >{{service.code}}</span>
                      </div>
                    </div>
                    <div class="col-12 row">
                      <label class="col-9">Background</label>
                      <div class="col-3">
                        <verte
                          class="verte-wrapper"
                          v-model="
                                                    service.css_background_color
                                                "
                          picker="square"
                          model="hex"
                        ></verte>
                      </div>
                    </div>
                    <!--
                                        <div class="col-12 row">
                                            <label class="col-9">Border</label>
                                            <div class="col-3">
                                                <verte
                                                    v-model="
                                                    service.css_border_color
                                                "
                                                    picker="square"
                                                    model="hex"
                                                ></verte>
                                            </div>
                                        </div>
                    -->
                    <div class="col-12 row">
                      <label class="col-9">Text</label>
                      <div class="col-3">
                        <verte
                          class="verte-wrapper"
                          v-model="service.css_text_color"
                          picker="square"
                          model="hex"
                        ></verte>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="row justify-content-center">
            <button class="btn btn-primary" @click="saveService">Save</button>
          </div>
        </div>
      </div>
      <div class="mt-4"></div>
      <div class="row">
        <div class="col-md-6">
          <div class="card">
            <div class="card-header">Service Breakdown</div>
            <div class="card-body">
              <table class="table table-borderd table-hover table-striped table-sm">
                <thead>
                  <tr>
                    <th>Option</th>
                    <th>Code</th>
                    <th>Name</th>
                    <th>UOM</th>
                    <th>Active</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="(b, b_key) in breakdown" :key="b_key">
                    <td align="center">
                      <button
                        type="button"
                        class="btn btn-sm btn-danger"
                        @click="deleteServiceBreakdown(b.id)"
                      >
                        <i class="fa fa-trash"></i>
                      </button>
                    </td>
                    <td>
                      <b-form-input v-model="b.code" size="sm" placeholder="Code"></b-form-input>
                    </td>
                    <td>
                      <b-form-input v-model="b.name" size="sm" placeholder="Name"></b-form-input>
                    </td>
                    <td>
                      <cool-select
                        v-model="b.uom"
                        size="sm"
                        placeholder="UOM"
                        :items="lists_uom"
                        itemText="text"
                        itemValue="value"
                      ></cool-select>
                    </td>
                    <td>
                      <b-form-checkbox name="check-button" value="1" size="lg" v-model="b.active"></b-form-checkbox>
                    </td>
                  </tr>
                  <tr>
                    <td align="center">
                      <button
                        type="button"
                        class="btn btn-sm btn-success"
                        @click="addNewServiceBreakdown"
                      >
                        <i class="fa fa-plus"></i>
                      </button>
                    </td>
                    <td>
                      <b-form-input size="sm" placeholder="Code" v-model="new_breakdown.code"></b-form-input>
                    </td>
                    <td>
                      <b-form-input size="sm" placeholder="Name" v-model="new_breakdown.name"></b-form-input>
                    </td>
                    <td>
                      <cool-select
                        size="sm"
                        placeholder="UOM"
                        :items="lists_uom"
                        v-model="new_breakdown.uom"
                        itemText="text"
                        itemValue="value"
                      ></cool-select>
                    </td>
                    <td></td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="card">
            <div class="card-header">Service Price</div>
            <div class="card-body">
              <table class="table table-bordered table-hover table-striped table-sm">
                <thead>
                  <tr>
                    <th>
                      <button type="button" class="btn btn-primary" @click="addNewPricePlan">
                        <i class="fa fa-plus"></i>
                      </button>
                    </th>
                    <th>ID</th>
                    <th>Price Title</th>
                    <th>Effective From</th>
                    <th>Effective To</th>
                  </tr>
                </thead>
                <tbody>
                  <template v-for="(price, k) in price_plan">
                    <tr :key="k">
                      <td>
                        <button
                          type="button"
                          class="btn btn-success"
                          @click="editPricePlan(price.id)"
                        >
                          <i class="fa fa-edit"></i>
                        </button>
                      </td>
                      <td>{{ price.id }}</td>
                      <td>{{ price.title }}</td>
                      <td>{{ price.start_date }}</td>
                      <td>{{ price.end_date }}</td>
                    </tr>
                  </template>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<style>
.verte-wrapper {
  background: white;
  border: 1px solid black;
}
</style>

<script>
export default {
  data() {
    return {
      isLoaded: false,
      serviceId: null,
      service: {},
      price_plan: {},
      breakdown: {},
      lists_uom: [],
      new_breakdown: {},
    };
  },
  methods: {
    editRow(data) {
      let serviceId = data.id;
      this.$router.push({ path: `/services/${serviceId}` });
    },
    async getServiceDetail() {
      axios
        .get("/setting/r/get_service_detail", {
          params: {
            service_id: this.serviceId,
          },
        })
        .then((res) => {
          let data = res.data;

          this.service = data.service;
          this.price_plan = data.price_plan;
          this.breakdown = data.breakdown;
          this.lists_uom = data.lists_uom;
          this.isLoaded = true;
        });
    },
    addNewPricePlan() {
      axios
        .post("/setting/r/add_new_service_price_plan", {
          service_id: this.serviceId,
        })
        .then((res) => {
          location.reload();
        });
    },
    editPricePlan(priceId) {
      this.$router.push({ path: `/price_plan/${priceId}` });
    },
    addNewServiceBreakdown() {
      axios
        .post("/setting/r/add_new_service_breakdown", {
          service_id: this.serviceId,
          breakdown: this.new_breakdown,
        })
        .then((res) => {
          location.reload();
        });
    },
    deleteServiceBreakdown(breakdown_id) {
      this.$swal({
        title: "Confirmation",
        text: "Confirm to delete this service breakdown ?",
        showCancelButton: true,
      }).then((result) => {
        if (result.value) {
          axios
            .post("/setting/r/delete_service_breakdown", {
              breakdown_id: breakdown_id,
            })
            .then((res) => {
              location.reload();
            });
        }
      });
    },
    saveService() {
      axios
        .post("/setting/r/save_service", {
          service: this.service,
        })
        .then((res) => {
          location.reload();
        });
    },
  },
  created() {
    let params = this.$route.params;
    this.serviceId = params.serviceId;
    this.getServiceDetail();
  },
};
</script>
