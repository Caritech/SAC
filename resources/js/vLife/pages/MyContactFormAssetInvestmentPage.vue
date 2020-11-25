<template>
  <div class="card">
    <div class="card-header">
      <span class="title-cyan">Assets & Investment</span>
      <span class="float-right">
        <router-link
          :to="add_asset_investment_btn"
          class="btn btn-sm btn-success"
          ><i class="fas fa-user-plus"></i> Add</router-link
        >
      </span>
    </div>
    <div class="card-body">
      <my-vuetable
        :api-url="asset_investment_api"
        :per-page="10"
        :fields="asset_investment_fields"
        ref="myVuetable"
        :transform="transformAssetInvestment"
      >
        <template slot="actions" slot-scope="props" v-if="props.rowData.id">
          <a
            class="btn btn-outline-success"
            @click="editAssetInvestment(props.rowData)"
          >
            <i class="fa fa-edit"></i>
          </a>
          <a
            class="btn btn-outline-primary"
            @click="deleteAssetInvestment(props.rowData)"
          >
            <i class="fas fa-trash-alt"></i>
          </a>
        </template>
        <template slot="checkbox" slot-scope="props" v-if="props.rowData.id">
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
        <template slot="current_value" slot-scope="props">
          <strong v-if="!props.rowData.id"
            >$
            {{ formatThousandsSeparator(props.rowData.current_value) }}</strong
          >
          <template v-else="!props.rowData.id"
            >$
            {{
              formatThousandsSeparator(props.rowData.current_value)
            }}</template
          >
        </template>
      </my-vuetable>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      id: "",
      asset_investment_api: "",
      add_asset_investment_btn: "",
      vlife_setting: {},
      asset_investment_fields: [
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
          name: "start_age",
          title: "Start",
          sortField: "start_age",
        },
        {
          name: "age_to_liquidate",
          title: "Age To Liquidate",
          sortField: "age_to_liquidate",
        },
        {
          name: "project_growth",
          title: "Project Growth",
          sortField: "project_growth",
        },
        {
          name: "current_value",
          title: "Current Value",
          sortField: "current_value",
        },
      ],
    };
  },
  methods: {
    transformAssetInvestment(datas) {
      var transformed = datas;
      var cur_data = datas.data;
      var total_amt = 0;

      for (var i = 0; i < cur_data.length; i++) {
        total_amt += parseFloat(cur_data[i].current_value);
      }

      transformed.data.push({
        description: "Total",
        current_value: total_amt,
      });

      return transformed;
    },
    editAssetInvestment(data) {
      let id = data.id;
      this.$router.push("/my_contact/asset_investment/" + id + "/edit");
    },
    deleteAssetInvestment(data) {
      let id = data.id;
      Vue.swal({
        title: "Are you sure?",
        text: "It will be inactive this asset & investment record!",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes",
        showLoaderOnConfirm: true,

        preConfirm: function () {
          return new Promise(function (resolve) {
            axios
              .post("/vlife/my_contact/asset_investment/inactive", {
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
              .post("/vlife/my_contact/asset_investment/update_incl", {
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
    vm.add_asset_investment_btn =
      "/my_contact/asset_investment/" + vm.$route.params.id + "/create";
    vm.asset_investment_api =
      "/vlife/get_contact_asset_investment/" + vm.$route.params.id;
  },
};
</script>
