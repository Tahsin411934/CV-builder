<template>
  <div class="py-3" style="background-color: #07142B;">
    <div class="row justify-content-center">
      <div class="">
        <div class="timeline position-relative">
          <div
            v-for="(step, index) in steps"
            :key="index"
            :class="['timeline-step', { active: isActiveRoute(step.route) }]"
            @click="navigateToStep(step.route)"
          >
            <div class="d-flex align-items-center position-relative">
              <div class="step-number position-relative">
                {{ index + 1 }}
                <!-- Vertical line connecting steps -->
                <hr
                  v-if="index < steps.length - 1"
                  class="timeline-hr"
                  :style="{ top: `${hrHeight}px` }"
                />
              </div>
              <div class="step-content">
                <h5>{{ step.label }}</h5>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      steps: [
        { label: "Overview", route: "/resume" },
        { label: "Heading", route: "/heading" },
        { label: "Education", route: "/education" },
        { label: "Experience", route: "/experience" },
        { label: "Skills", route: "/skills" },
        { label: "Summary", route: "/summary" },
        { label: "Finalize", route: "/finalize" },
      ],
      hrHeight: 40, // Default height for the connecting hr
    };
  },
  methods: {
    navigateToStep(route) {
      this.$router.push(route); // Navigate to the clicked step's route
    },
    isActiveRoute(route) {
      return this.$route.path === route; // Check if the route is active
    },
    updateHrHeight() {
      // Dynamically calculate the height of the `hr` based on the step number size
      const stepNumberElement = document.querySelector(".step-number");
      if (stepNumberElement) {
        const stepHeight = stepNumberElement.offsetHeight;
        this.hrHeight = stepHeight / 2; // Adjust height to match visual alignment
      }
    },
  },
  mounted() {
    // Update `hr` height on component mount
    this.updateHrHeight();
    // Add listener for window resize to dynamically adjust
    window.addEventListener("resize", this.updateHrHeight);
  },
  beforeUnmount() {
    // Clean up event listener on unmount
    window.removeEventListener("resize", this.updateHrHeight);
  },
};
</script>

<style scoped>
/* General styles for the timeline */
.timeline {
  position: relative;
  padding: 20px;
}

.timeline-step {
  position: relative;
  padding: 20px;
  cursor: pointer;
  background-color: transparent;
}

.timeline-step.active {
  background-color: #0d243f;
  border-left: 4px solid #1e90ff;
  border-radius: 8px;
}

.step-number {
  background-color: #1e90ff;
  color: white;
  width: 40px;
  height: 40px;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  font-weight: bold;
  margin-right: 15px;
  position: relative;
}

.step-content h5 {
  margin: 0;
  font-size: 18px;
  color: white;
}

/* Line connecting steps */
.timeline-hr {
  position: absolute;
  left: 50%;
  transform: translateX(-50%);
  width: 2px;
  height: 70px;
  background-color: #1e90ff;
  margin: 0;
  border: none;
}
</style>
