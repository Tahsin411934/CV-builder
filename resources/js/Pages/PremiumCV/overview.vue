<template>
  <div class="container mx-auto">
    <div class="row align-items-center">
      <!-- Left Section -->
      <div class="col-md-6 rounded p-4">
        <div class="h-100 d-flex flex-column justify-content-center">
          <p class="fw-semibold fs-4 mb-2 text-custom">Fast. Easy. Effective.</p>
          <h1 class="font-weight-bold">
            The Best CV Maker Online.
          </h1>
          <p class="mt-3 text-muted">
            We provide cutting-edge design solutions to bring your ideas to life. From
            concept to creation, we're here to innovate and inspire.
          </p>
         <div class="d-flex gap-2">
            <router-link to="/premiumcv/select-tamplate" class="btn btn-warning rounded-5 w-50 btn-lg mt-4">Get Started</router-link>
            <router-link to="/resume/objective" class="btn border border-secondary rounded-5 w-50 btn-lg mt-4">Upload Exiting File</router-link>
         </div>
          
        </div>
      </div>

      <!-- Right Section -->
      <div class="col-md-6 text-center bg-custom py-5">
        <img src="/hero-image.avif" alt="Creative Design" class="img-fluid rounded" />
      </div>
    </div>
    <Gideline />
  </div>
</template>

<script>
import Typewriter from 'typewriter-effect/dist/core';
import Gideline from '../../components/Gideline.vue';

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
