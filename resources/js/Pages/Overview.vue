<template>
  <div class="container mx-auto">
    <div class="row align-items-center">
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
          <!-- Typewriter Effect -->
          <div class=" fs-4 fw-bold text-custom" ref="typewriter"></div>
          <router-link to="/resume/objective" class="btn btn-warning rounded-5 w-50 btn-lg mt-4">Get Started</router-link>
        </div>
      </div>

      <!-- Right Section -->
      <div class="col-md-6 text-center bg-custom py-5">
        <img src="/preResume.png" alt="Creative Design" class="img-fluid rounded" />
      </div>
    </div>
    <Gideline />
  </div>
</template>

<script>
import Typewriter from 'typewriter-effect/dist/core';
import Gideline from '../components/Gideline.vue';

export default {
  name: "OverviewR",
  components: { Gideline }, // Register Gideline here
  mounted() {
    // Initialize the typewriter effect
    const typewriter = new Typewriter(this.$refs.typewriter, {
      loop: true,
      delay: 75,
    });

    typewriter
      .typeString("Stand out with our unique templates.")
      .pauseFor(1000)
      .deleteAll()
      .typeString("Your dream job is one step away.")
      .pauseFor(1000)
      .deleteAll()
      .typeString("Join us and build your future.")
      .pauseFor(1000)
      .start();
  },
};
</script>

<style scoped>
.bg-custom {
  background: #f9faff;
}

.text-custom {
  color: #050748;
}
</style>
