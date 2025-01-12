<template>
  <div class="container mx-auto my-5">
    <div class="row align-items-center">
      <!-- Left Section -->
      <div class="col-md-6 rounded p-4 ">
        <div class=" h-100 d-flex flex-column justify-content-center">
          <p class=" fw-semibold fs-5 mb-2 text-custom">Solution-Oriented Services</p>
          <h1 class="display-4 fw-semibold text-custom">Creative Design Company We Create</h1>
          <p class="mt-3 text-muted">
            We provide cutting-edge design solutions to bring your ideas to life. 
            From concept to creation, we're here to innovate and inspire.
          </p>
          <router-link to="/resume/overview" class="btn w-50 bg-custom mt-4 px-4  text-white rounded-5 fs-5">Create Your CV</router-link>
        </div>
      </div>

      <!-- Right Section -->
      <div class="col-md-6 text-center">
        <img
          src="/banner.png"
          alt="Creative Design"
          class="img-fluid rounded "
        />
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "Banner",
};
</script>

<style scoped>
.bg-custom{
  background: #050748; 
}

.text-custom {
      color: #050748; 
    }
</style>
