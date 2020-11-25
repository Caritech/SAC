<template>
  <div>
    <b-breadcrumb>
      <b-breadcrumb-item href="/centre">Centre</b-breadcrumb-item>
      <b-breadcrumb-item href="/centre/attendance">Location</b-breadcrumb-item>
      <b-breadcrumb-item :href="'/centre/attendance/'+location_id">Attendance [ Balcatta ]</b-breadcrumb-item>
      <b-breadcrumb-item active>Add New Attendance [ Balcatta ]</b-breadcrumb-item>
    </b-breadcrumb>
    <h4>Add New Attendamce</h4>
    <div class="row">
      <div class="col-md-4">
        <div class="card">
          <div class="card-header">Attendance Info</div>
          <div class="card-body">
            <div class="form-group row">
              <label class="col-md-6">Attendance Date</label>
              <div class="col-md-6">
                <date-picker :useCurrent="true"></date-picker>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-md-6">Category</label>
              <div class="col-md-6">
                <cool-select
                  size="sm"
                  :items="['Client', 'Support Worker', 'Visitor','Volunteer','Staff']"
                ></cool-select>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-md-6">Personal Contact</label>
              <div class="col-md-6">
                <cool-select
                  size="sm"
                  :items="['Contact 1', 'Contact 2', 'Contact 3','Contact 4','Contact 5']"
                ></cool-select>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-md-6">Price Type</label>
              <div class="col-md-6">
                <cool-select
                  size="sm"
                  :items="['Visitor (Member)', 'Visitor (Non-Member)', 'Visitor (Member + speicial Lunch)']"
                ></cool-select>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card">
          <div class="card-header">Pricing Info</div>
          <div class="card-body">
            <div class="form-group row">
              <label class="col-md-4">Service Fee</label>
              <div class="col-md-6">
                <input type class="form-control form-control-sm" />
              </div>
            </div>
            <div class="form-group row">
              <label class="col-md-4">Lunch</label>
              <div class="col-md-6">
                <input type class="form-control form-control-sm" />
              </div>
            </div>
            <div class="form-group row">
              <label class="col-md-4">Pickup</label>
              <div class="col-md-6">
                <input type class="form-control form-control-sm" />
              </div>
            </div>
            <div class="form-group row">
              <label class="col-md-4">Return</label>
              <div class="col-md-6">
                <input type class="form-control form-control-sm" />
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="card">
          <div class="card-header">More Info</div>
          <div class="card-body">
            <div class="form-group">
              <checkbox title="Billed"></checkbox>
            </div>
            <div class="form-group">
              <checkbox title="Volunteer On Duty"></checkbox>
            </div>
            <div class="form-group">
              <checkbox title="James St Bus (AM)"></checkbox>
            </div>
            <div class="form-group">
              <checkbox title="James St Bus (PM)" v-model="attendance.busPM"></checkbox>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-12 mt-3 text-center">
      <button class="btn btn-success">Add Attendance</button>
    </div>
  </div>
</template>
<script>
export default {
  data() {
    return {
      location_id: null,
      attendance: {},
    };
  },
  created() {
    this.location_id = this.$route.params.locationId;
  },
};
</script>
