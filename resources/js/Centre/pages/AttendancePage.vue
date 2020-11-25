<template>
  <div class="bg-white" style="height:100vh">
    <b-breadcrumb>
      <b-breadcrumb-item href="/centre">Centre</b-breadcrumb-item>
      <b-breadcrumb-item href="/centre/attendance">Location</b-breadcrumb-item>
      <b-breadcrumb-item active>Attendance [ Balcatta ]</b-breadcrumb-item>
    </b-breadcrumb>
    <div class="col-md-12">
      <h4>Balcatta</h4>
      <router-link
        :to="'/attendance/'+location_id+'/create'"
        target="_blank"
        class="btn btn-success btn-sm mr-2 float-right"
      >New Attendance</router-link>
      <div class="mb-2">
        <div class="col-md-4 row">
          <label class="col-md-6">Select Date</label>
          <div class="col-md-6">
            <cool-select :items="[]"></cool-select>
          </div>
        </div>
      </div>
      <div class="row col-12 mb-2">
        <div class="row col-md-4">
          <label class="col-md-6">Search Attendance:</label>
          <div class="col-md-6">
            <input type="text" class="form-control" />
          </div>
        </div>
      </div>
      <div class="col-md-7">
        <h5>Attendance Lists (5)</h5>
        <table class="table table-sm table-bordered">
          <tr>
            <th>Type</th>
            <th>Name</th>
            <th>Time In</th>
            <th>Time Out</th>
            <th>Option</th>
          </tr>
          <tr v-for="a in ['SW','Client','Other']">
            <td>{{a}}</td>
            <td>
              <i class="fa fa-image"></i> Hello World
            </td>
            <td>11:00</td>
            <td>11:00</td>
            <td>
              <button class="btn btn-sm btn-outline-primary">Detail</button>
              <button class="btn btn-sm btn-success">Check In</button>
              <button class="btn btn-sm btn-primary">Check Out</button>
            </td>
          </tr>
        </table>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      location_id: null,
    };
  },
  methods: {},
  created() {
    this.location_id = this.$route.params.locationId;
  },
};
</script>
