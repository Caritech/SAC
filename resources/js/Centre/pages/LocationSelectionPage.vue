<template>
  <div class="row">
    <div class="col-md-2 col-sm-6">
      <div class="card">
        <div class="card-body text-center bg-danger">
          <i class="fa fa-home fa-5x text-white"></i>
          <div class="divider"></div>
          <router-link :to="'/attendance/1'" class="btn btn-block btn-light">Balcatta</router-link>
        </div>
      </div>
    </div>
    <div class="col-md-2 col-sm-6">
      <div class="card">
        <div class="card-body text-center bg-danger">
          <i class="fa fa-home fa-5x text-white"></i>
          <div class="divider"></div>
          <router-link :to="'/attendance/3'" class="btn btn-block btn-light">Willetton</router-link>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
export default {};
</script>
