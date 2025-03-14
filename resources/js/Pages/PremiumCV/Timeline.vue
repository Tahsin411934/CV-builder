<template>
  <div class="py-3 min-vh-100" style="background-color: #07142B;">
    <div class="row justify-content-center">
      <div>
        <div class="timeline position-relative">
          <div
            v-for="(step, index) in steps"
            :key="index"
            :class="['timeline-step', { active: isActiveRoute(step.route), disabled: step.label === 'Confirm Order' && !paymentSubmitted }]"
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
              <div class="step-content fs">
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
      props: {
          templateId: {
              type: String,
              required: true,
          },
      },
      data() {
          return {
              hrHeight: 40,
              paymentSubmitted: localStorage.getItem('paymentSubmitted') === 'true', // Initialize paymentSubmitted from localStorage
          };
      },
      computed: {
          steps() {
              return [
                  { label: "Objective", route: `/premiumcv/${this.templateId}/objective` },
                  { label: "Heading", route: `/premiumcv/${this.templateId}/heading` },
                  { label: "Education", route: `/premiumcv/${this.templateId}/education` },
                  { label: "Experience", route: `/premiumcv/${this.templateId}/experience` },
                  { label: "Skills", route: `/premiumcv/${this.templateId}/skills` },
                  { label: "Language Proficiency", route: `/premiumcv/${this.templateId}/language-proficiency` },
                  { label: "Project", route: `/premiumcv/${this.templateId}/project` },
                  { label: "Summary", route: `/premiumcv/${this.templateId}/finalize` },
                  { label: "Instruction", route: `/premiumcv/${this.templateId}/instruction` },
                  { label: "Payment", route: `/premiumcv/${this.templateId}/payment` },
                  { label: "Confirm Order", route: `/premiumcv/${this.templateId}/confirm-order` },
              ];
          },
      },
      methods: {
          navigateToStep(route) {
             
              this.$router.push(route);
          },
          isActiveRoute(route) {
              return this.$route.path === route;
          },
          updateHrHeight() {
              const stepNumberElement = document.querySelector(".step-number");
              if (stepNumberElement) {
                  const stepHeight = stepNumberElement.offsetHeight;
                  this.hrHeight = stepHeight / 2;
              }
          },
      },
      mounted() {
          this.updateHrHeight();
          window.addEventListener("resize", this.updateHrHeight);
      },
      beforeUnmount() {
          window.removeEventListener("resize", this.updateHrHeight);
      },
  };
  </script>
  
  <style scoped>
  /* General styles for the timeline */
  .timeline {
    position: relative;
    padding: 10px;
  }
  
  .timeline-step {
    position: relative;
    padding: 10px;
    cursor: pointer;
    background-color: transparent;
  }
  
  .timeline-step.active {
    background-color: #0d243f;
    border-radius: 8px;
  }
  
  .timeline-step.active .step-number {
    background-color: red; /* Step number background turns red when active */
    color: white; /* Make the number white for contrast */
  }
  
  .step-number {
    background-color: #e5e7eb;
    color: #0d243f;
    width: 30px;
    height: 30px;
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
    font-size: 13px;
    color: white;
  }
  
  /* Line connecting steps */
  .timeline-hr {
    position: absolute;
    left: 50%;
    transform: translateX(-50%);
    width: 5px;
    height: 70px;
    background-color: #e5e7eb;
    margin: 0;
    border: none;
  }
  
  /* Responsive design for small devices */
  @media (max-width: 576px) {
    .step-content {
      display: none; /* Hide the labels on small screens */
    }
  
    .step-number {
      width: 20px; /* Smaller step number size */
      height: 20px;
      font-size: 12px; /* Adjust font size for better fit */
      margin-right: 10px; /* Reduce margin */
    }
  
    .timeline-hr {
      width: 3px; /* Narrower line */
      height: 50px; /* Adjust line height for better alignment */
    }
    .timeline-step {
      position: relative;
      padding: 0px;
      margin-top: 10px;
      margin-bottom: 10px;
      cursor: pointer;
      background-color: transparent;
    }
  }
  </style>