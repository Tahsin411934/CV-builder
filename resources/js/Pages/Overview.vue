<template>
  <div class="container mx-auto ">
    <div class="row align-items-center ">
      <!-- Left Section -->
      <div class="col-md-6 rounded p-4">
        <div class="h-100 d-flex flex-column justify-content-center">
          <p class="fw-semibold fs-5 mb-2 text-custom">Solution-Oriented Services</p>
          <h1 class="font-weight-bold">
            Create a <span class="text-warning">job-winning</span> CV in minutes
          </h1>
          <p class="mt-3 text-muted">
            We provide cutting-edge design solutions to bring your ideas to life. From
            concept to creation, we're here to innovate and inspire.
          </p>
          <router-link to="/heading" class="btn btn-warning rounded-5 w-50 btn-lg">Get Started</router-link>
          
        </div>
      </div>

      <!-- Right Section -->
      <div class="col-md-6 text-center bg-custom py-5">
        <img src="/preResume.png" alt="Creative Design" class="img-fluid rounded" />
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "OverviewR",
};
</script>

<style scoped>
.bg-custom {
  background: #f9faff;
}
</style>
