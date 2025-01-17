<template>
  <div class="container mx-auto my-5">
    <div class="row align-items-center">
      <!-- Left Section -->
      <div class="col-md-6 rounded py-4">
        <div class="h-100 d-flex flex-column justify-content-center">
          <p class="fw-semibold fs-5 mb-2 text-custom">Solution-Oriented Services</p>
          <h4 class="display-5 fw-medium text-custom">Creative Design Company We Create</h4>
          
          <!-- Typewriter Effect -->
          <div class="fs-4 fw-bold text-gradient" ref="typewriter"></div>

          <p class="mt-3 text-muted">
            We provide cutting-edge design solutions to bring your ideas to life.
            From concept to creation, we're here to innovate and inspire.
          </p>
          
          <router-link to="/overview" class="btn w-lg-50 w-75  bg-custom mt-4 px-4 text-white rounded-5 fs-5">Create Your CV</router-link>
        </div>
      </div>

      <!-- Right Section -->
      <div class="col-md-6 text-center">
        <img
          src="/banner.png"
          alt="Creative Design"
          class="img-fluid rounded"
        />
      </div>
    </div>
  </div>
</template>

<script>
import Typewriter from 'typewriter-effect/dist/core';

export default {
  name: "Banner",
  mounted() {
    // Initialize the typewriter effect
    const typewriter = new Typewriter(this.$refs.typewriter, {
      loop: true,
      delay: 75,
    });

    typewriter
      .typeString("Stand out with our unique Design.")
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
  background: #050748;
}

.text-custom {
  color: #050748;
}
</style>
