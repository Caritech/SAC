<template>
  <div>
    <h2>Service Data Sync</h2>
    <p>
      This Page is used to sync data from ired v1 database
      Table to sync:
    </p>
    <div class="row">
      <div class="col-md-6">
        <div class="card">
          <div class="card-header">
            <button
              class="btn btn-block btn-success"
              @click="syncInfomration"
            >Sync Contact Information From V1</button>
          </div>
          <div class="card-body">
            <ul>
              <li>
                <h4>
                  Below Table will convert to XXXX
                  <b>service_plan</b>
                </h4>
              </li>
              <li>careplan</li>
              <li>careplanhh</li>
              <li>careplancacp</li>
              <li>careplanagency</li>
              <li>careplandlrc</li>
              <li>transportassignment_master</li>
              <li>swdutyroster_master</li>
              <li>driverroster_master</li>
            </ul>
            <ul>
              <li>
                <h4>
                  Below Table will convert to
                  <b>service_assignment</b>
                </h4>
              </li>
              <li>hhassignment</li>
              <li>dlrcattendance</li>
              <li>cdcbatendance</li>
              <li>transportassignment</li>
              <li>driverroster</li>
              <li>swdutyroster</li>
            </ul>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="card">
          <div class="card-header">
            <button
              class="btn btn-block btn-success"
              @click="syncService"
            >Sync Assignment And Plan From V1</button>
          </div>
          <div class="card-body">
            <ul>
              <li>
                <h4>
                  Below Table will convert to
                  <b>service_plan</b>
                </h4>
              </li>
              <li>careplan</li>
              <li>careplanhh</li>
              <li>careplancacp</li>
              <li>careplanagency</li>
              <li>careplandlrc</li>
              <li>transportassignment_master</li>
              <li>swdutyroster_master</li>
              <li>driverroster_master</li>
            </ul>
            <ul>
              <li>
                <h4>
                  Below Table will convert to
                  <b>service_assignment</b>
                </h4>
              </li>
              <li>hhassignment</li>
              <li>dlrcattendance</li>
              <li>cdcbatendance</li>
              <li>transportassignment</li>
              <li>driverroster</li>
              <li>swdutyroster</li>
            </ul>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="card">
          <div class="card-header">
            <button class="btn btn-block btn-primary" @click="syncPrice">Sync Service Price From V1</button>
          </div>
          <div class="card-body">
            <ul>
              <li>
                <h4>
                  Below Table will convert to
                  <b>
                    <br />setting_services_price_plan
                    <br />setting_services_price_plan_breakdown_items
                    <br />setting_services_price_plan_cdc_evergreen
                    <br />setting_services_price_plan_group
                    <br />setting_services_price_plan_group_item
                  </b>
                </h4>
              </li>
              <li>service_price_maintenance</li>
              <li>servicerate_hcp</li>
              <li>servicerate_agency2</li>
              <li>cdc_evergreen_price</li>
              <li>cdcsubsupp</li>
              <li>cdcwklycharge</li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  methods: {
    syncService() {
      Vue.swal("pending");
    },
    syncPrice() {
      this.$swal({
        title: "Confirmation",
        text: "Confirm to sync data from Ired V1 ?",
        showCancelButton: true,
      }).then((result) => {
        if (result.value) {
          axios.get("/data_adapter/r/sync_price").then((res) => {
            Vue.swal("Success", "Record has been syned", "success");
          });
        }
      });
    },
  },
};
</script>
