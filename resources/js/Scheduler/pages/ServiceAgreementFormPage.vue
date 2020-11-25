<template>
  <div>
    <b-breadcrumb>
      <b-breadcrumb-item href="/service">Service</b-breadcrumb-item>
      <b-breadcrumb-item href="/service/service_agreement">Service Agreement</b-breadcrumb-item>
      <b-breadcrumb-item active>Agreement Info</b-breadcrumb-item>
    </b-breadcrumb>
    <div>
      <div class="text-right">
        <button class="btn btn-success" @click="saveAgreement">
          <i class="fa fa-save"></i>
          Save
        </button>
      </div>

      <div class>
        <div class="row">
          <div class="col-md-5">
            <div class="card card-primary">
              <div class="card-header">Agreement Info</div>
              <div class="card-body">
                <div class="row form-group-sm">
                  <label class="col-md-6">Plan ID :</label>
                </div>
                <div class="row form-group form-group-sm">
                  <label class="col-md-6">Active :</label>
                  <div class="col-md-6">
                    <b-form-checkbox value="1" unchecked-value="0" v-model="agreement.is_active"></b-form-checkbox>
                  </div>
                </div>

                <div class="row form-group form-group-sm">
                  <label class="col-md-6">Service ID :</label>
                  <div class="col-md-6">
                    <cool-select
                      size="sm"
                      single-line
                      :items="lists_service"
                      v-model="agreement.service_id"
                      itemText="code"
                      itemValue="id"
                    ></cool-select>
                  </div>
                </div>

                <div class="row form-group form-group-sm">
                  <label class="col-md-6">Client :</label>
                  <div class="col-md-6">
                    <cool-select
                      size="sm"
                      :items="lists_client"
                      v-model="agreement.client"
                      @select="getClientInfo(index)"
                      itemText="label"
                      itemValue="key"
                    ></cool-select>
                  </div>
                </div>

                <div class="row form-group form-group-sm">
                  <label class="col-md-6">Service Level :</label>
                  <div class="col-md-6">
                    <cool-select
                      size="sm"
                      single-line
                      :items="lists_level"
                      v-model="agreement.level"
                    ></cool-select>
                  </div>
                </div>

                <div class="row form-group form-group-sm">
                  <label class="col-md-6">Start Date :</label>
                  <div class="col-md-6">
                    <date-picker
                      class="form-control-sm"
                      :config="{
                          useCurrent: false,
                                format: 'YYYY-MM-DD'
                            }"
                      v-model="agreement.start_date"
                    ></date-picker>
                  </div>
                </div>

                <div class="row form-group form-group-sm">
                  <label class="col-md-6">End Date :</label>
                  <div class="col-md-6">
                    <date-picker
                      class="form-control-sm"
                      :config="{
                                useCurrent: false,
                                format: 'YYYY-MM-DD'
                            }"
                      v-model="agreement.end_date"
                    ></date-picker>
                  </div>
                </div>

                <div class="row form-group form-group-sm">
                  <label class="col-md-6">Review Date :</label>
                  <div class="col-md-6">
                    <date-picker
                      class="form-control-sm"
                      :config="{
                                useCurrent: false,
                                format: 'YYYY-MM-DD'
                            }"
                      v-model="agreement.review_date"
                    ></date-picker>
                  </div>
                </div>

                <div class="row form-group-sm">
                  <label class="col-md-6">Case Worker :</label>
                  <div class="col-md-6">
                    <cool-select
                      size="sm"
                      single-line
                      :items="lists_level"
                      v-model="agreement.case_worker"
                    ></cool-select>
                  </div>
                </div>

                <div class="row form-group-sm">
                  <label class="col-md-6">Need Service In Holiday :</label>
                  <div class="col-md-6">
                    <b-form-checkbox
                      value="1"
                      unchecked-value="0"
                      v-model="agreement.need_srv_in_holiday"
                    ></b-form-checkbox>
                  </div>
                </div>

                <div class="row form-group-sm">
                  <label class="col-md-6">Remark :</label>
                  <div class="col-md-6">
                    <textarea class="form-control textarea" rows="3" v-model="agreement.remark"></textarea>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="col-md-4">
            <div class="card card-primary">
              <div class="card-header">Client Info</div>
              <div class="card-body">
                <div class="row form-group-sm">
                  <label class="col-md-6">ID :</label>
                  <label class="col-md-6">{{ client_info.id }}</label>
                </div>
                <div class="row form-group-sm">
                  <label class="col-md-6">No :</label>
                  <label class="col-md-6">{{ client_info.client_no }}</label>
                </div>
                <div class="row form-group-sm">
                  <label class="col-md-6">Name :</label>
                  <label class="col-md-6">{{ client_info.name }}</label>
                </div>
                <div class="row form-group-sm">
                  <label class="col-md-6">DOB :</label>
                  <label class="col-md-6">{{ client_info.dob }}</label>
                </div>
                <div class="row form-group-sm">
                  <label class="col-md-6">Gender :</label>
                  <label class="col-md-6">{{ client_info.gender }}</label>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- <user-timestamp :data="agreement"></user-timestamp> -->
      </div>

      <div class>
        <div class="col-md-12 text-center">
          <button class="btn btn-success" @click="saveAgreement">
            <i class="fa fa-save"></i>
            Save
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      is_loading: false,
      pageReady: true,
      loading_text: "",

      lists_service: [],
      lists_client: [],
      lists_level: [],

      client_info: {},
      agreement_id: null,
      agreement: { client: null },
    };
  },
  methods: {
    getServiceAgreementDetail() {
      axios
        .get("/service/r/get_agreement_detail", {
          params: {
            agreement_id: this.agreement_id,
          },
        })
        .then((response) => {
          this.agreement = response.data;
          this.getClientInfo();
        });
    },
    getClientInfo: function () {
      axios
        .get("/service/r/get_client_info", {
          params: {
            client_id: this.agreement.client,
          },
        })
        .then((response) => {
          var data = response.data;
          this.client_info = data;
        });
    },
    //save single
    saveAgreement: function () {
      axios
        .post("/service/r/save_service_agreement", {
          agreement: this.agreement,
        })
        .then((response) => {
          var data = response.data;
          if (data.errors != null) {
            Vue.swal("Validation Error", data.error_message, "error");
          } else {
            Vue.swal("Success", "Record has been saved", "success");
            if (this.agreement_id == null) {
              this.$router.replace("/service_agreement/" + data.id + "/edit");
            }
          }
        });
    },

    //Get All Lists First
    async initLists() {
      var $vm = this;

      await axios
        .get("/service/r/get_service_agreement_dropdown")
        .then((response) => {
          var res = response.data;
          $vm.lists_service = res.lists_service;
          $vm.lists_client = res.lists_client;
          $vm.lists_level = res.lists_level;
        });

      return true;
    },
  },
  created: function () {
    this.initLists();
    let params = this.$route.params;

    this.agreement_id = params.agreementId;
    if (this.agreement_id != null) {
      this.getServiceAgreementDetail();
    }
  },
  mounted() {
    let client_id = this.$route.query.client_id;
    if (client_id != null) {
      Vue.set(this.agreement, "client", parseInt(client_id));
      this.getClientInfo();
    }
  },
};
</script>
