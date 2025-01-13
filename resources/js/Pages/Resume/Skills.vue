<template>
  <div class="container mt-2">
    <!-- Header Section -->
    

    <div class="card shadow-sm">
     <div class="col-md-9 d-flex px-3 ">
          <div class=" text-custom pt-3 ">
            <h5 class="fw-bold ">Step-5:Skills</h5>
            <p>Fill in the details below to proceed with your CV creation. Follow all the steps carefully to build a professional CV tailored just for you</p>
          </div>
        </div>
      
      <!-- Form Section -->
      <div class="card-body">
        <form @submit.prevent="submitForm">
          <!-- Hard Skills Field -->
          <div class="mb-3">
            <label for="hard_skills" class="form-label">Hard Skills</label>
            <textarea
              id="hard_skills"
              v-model="formData.hard_skills"
              class="form-control pb-5"
              rows="3"
              placeholder="Enter your hard skills (e.g., programming, technical abilities)"
              required
            ></textarea>
          </div>

          <!-- Soft Skills Field -->
          <div class="mb-3">
            <label for="soft_skills" class="form-label">Soft Skills</label>
            <textarea
              id="soft_skills"
              v-model="formData.soft_skills"
              class="form-control pb-5"
              rows="3"
              placeholder="Enter your soft skills (e.g., communication, leadership)"
              required
            ></textarea>
          </div>

          <!-- Email Field (Hidden but populated) -->
          <div class="mb-3 d-none">
            <label for="user_email" class="form-label">Email</label>
            <input
              type="email"
              id="user_email"
              v-model="formData.user_email"
              class="form-control"
              readonly
            />
          </div>

          <!-- Submit and Navigation Buttons -->
          <div class="row mb-4">
            <div class="col-12 d-flex justify-content-between">
              <router-link
                to="/experience"
                class="text-custom border border-dark btn text-decoration-none mx-3 fw-medium hover-link px-4 fs-4 rounded-5"
              >
                Previous
              </router-link>
              <button
                type="submit"
                class="btn btn-warning px-4 fs-4 rounded-5"
                aria-live="polite"
              >
                <span
                  v-if="loading"
                  class="spinner-border spinner-border-sm"
                  role="status"
                  aria-hidden="true"
                ></span>
                <span v-else>Next</span>
              </button>
            </div>
          </div>
        </form>

        <!-- Success Message -->
        <div v-if="successMessage" class="alert alert-success mt-4">
          {{ successMessage }}
        </div>

        <!-- Error Message -->
        <div v-if="errorMessage" class="alert alert-danger mt-4">
          {{ errorMessage }}
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";

export default {
  name: "ObjectiveForm",
  data() {
    return {
      formData: {
        hard_skills: "",
        soft_skills: "",
        user_email: "",
      },
      successMessage: "",
      errorMessage: "",
      loading: false,
    };
  },
  methods: {
    async userEmail() {
      const user = JSON.parse(localStorage.getItem("user"));
      if (user && user.email) {
        try {
          const response = await axios.get(
            `http://127.0.0.1:8000/api/skills/${user.email}`
          );
          const data = response.data?.data || {};
          this.formData = {
            hard_skills: data.hard_skills || "",
            soft_skills: data.soft_skills || "",
            user_email: user.email,
          };
        } catch (error) {
          this.formData.user_email = user.email;
        }
      } else {
        console.error("No user data or email found.");
      }
    },
    async submitForm() {
      this.successMessage = "";
      this.errorMessage = "";
      this.loading = true;
      try {
        const response = await axios.post(
          "http://127.0.0.1:8000/api/skills",
          this.formData
        );
        this.successMessage = response.data.message;
        this.formData.hard_skills = "";
        this.formData.soft_skills = "";
        this.$router.push("/resume/language-proficiency");
      } catch (error) {
        this.errorMessage = error.response?.data?.message || "An error occurred.";
      } finally {
        this.loading = false;
      }
    },
  },
  mounted() {
    this.userEmail();
  },
};
</script>

<style scoped>
.text-custom {
  color: #050748;
}
</style>
