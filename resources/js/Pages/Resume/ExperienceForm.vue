<template>
  <div class="container mt-2 card shadow-sm">
    <div class="col-md-9 d-flex">
      <div class="text-custom pt-3">
        <h5 class="fw-bold">Step-4: Experience</h5>
        <p>
          Fill in the details below to proceed with your CV creation. Follow all the steps
          carefully to build a professional CV tailored just for you
        </p>
      </div>
    </div>

    <!-- Form for multiple experience records -->
    <form @submit.prevent="submitForm">
      <div
        v-for="(experience, index) in experiences"
        :key="index"
        class="mb-4 p-3 border rounded bg-light"
      >
        <h4 class="text-primary mb-3">
          {{ experience.job_title || "New Record" }}
        </h4>

        <!-- Row 1 -->
        <div class="row mb-3">
          <div class="col-md-6">
            <label for="employer" class="form-label">Employer</label>
            <input
              v-model="experience.employer"
              type="text"
              class="form-control"
              placeholder="Enter employer name"
              required
            />
          </div>
          <div class="col-md-6">
            <label for="job_title" class="form-label">Job Title</label>
            <input
              v-model="experience.job_title"
              type="text"
              class="form-control"
              placeholder="Enter job title"
              required
            />
          </div>
        </div>

        <!-- Row 2 -->
        <div class="row mb-3">
          <div class="col-md-6">
            <label for="start_date" class="form-label">Start Date</label>
            <input
              v-model="experience.start_date"
              type="date"
              class="form-control"
              required
            />
          </div>
          <div class="col-md-6">
            <label for="end_date" class="form-label">End Date</label>
            <input v-model="experience.end_date" type="date" class="form-control" />
          </div>
        </div>

        <!-- Row 3 -->
        <div class="row mb-3">
          <div class="col-md-6">
            <label for="short_description" class="form-label">Short Description</label>
            <textarea
              v-model="experience.short_description"
              class="form-control"
              placeholder="Enter short description of your job"
            ></textarea>
          </div>

          <div class="col-md-6">
            <label for="current_work" class="form-label">Currently Working: </label>
            <input
              v-model="experience.current_work"
              type="checkbox"
              class="form-check-input bg-custom border-4 border-primary mx-3 rounded-full w-8 h-8 transition-all duration-300 ease-in-out transform hover:scale-110 focus:ring-2 focus:ring-primary"
              :true-value="true"
              :false-value="false"
            />
          </div>
        </div>

        <!-- Row 4 (user email) -->
        <div class="row mb-3 d-none">
          <div class="col-md-6">
            <label for="user_email" class="form-label">User Email</label>
            <input
              v-model="experience.user_email"
              type="email"
              class="form-control"
              placeholder="Enter your email"
              required
            />
          </div>
        </div>

        <!-- Remove and Delete buttons -->
        <div class="d-flex justify-content-between">
          <button @click.prevent="removeExperience(index)" class="btn btn-danger btn-sm">
            Remove
          </button>
          <button
            v-if="experience.id"
            @click.prevent="deleteExperience(experience.id, index)"
            class="btn btn-outline-danger btn-sm"
          >
            Delete
          </button>
        </div>
      </div>

      <!-- Button to add new experience entry -->
      <div class="d-grid gap-2 mb-3 w-25">
        <button @click.prevent="addExperience" class="btn btn-success">
          Add Another Experience Record
        </button>
      </div>

      <div class="row mb-4">
        <div class="col-12 d-flex justify-content-between">
          <router-link
            to="/education"
            class="text-dark border border-dark btn text-decoration-none mx-3 fw-medium hover-link px-4 fs-4 rounded-5"
          >
            Previous
          </router-link>
          <div>
            <router-link
              style="background: #388e3c"
              to="/resume/skills"
              class="text-white btn text-decoration-none mx-3 fw-medium hover-link px-4 fs-4 rounded-5"
            >
              Skip
            </router-link>
            <button
              type="submit"
              class="btn btn-warning px-4 fs-4 rounded-5"
              :disabled="loading"
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
      </div>
    </form>

    <!-- Error Message Display -->
    <div v-if="errorMessage" class="alert alert-danger mt-3">
      {{ errorMessage }}
    </div>
  </div>
</template>

<script>
import axios from "axios";

export default {
  data() {
    return {
      experiences: [
        {
          job_title: "",
          employer: "",
          start_date: "",
          end_date: "",
          current_work: false,
          short_description: "",
          user_email: "", // Fixed this from `user_mail`
          id: null,
        },
      ],
      errorMessage: "",
      loading: false, // Added loading state
    };
  },
  methods: {
    async userEmail() {
      const user = JSON.parse(localStorage.getItem("user"));
      if (user && user.email) {
        try {
          const response = await axios.get(
            `http://127.0.0.1:8000/api/experience/${user.email}`
          );
          const data = response.data?.data || [];
          this.experiences = data.map((item) => ({
            ...item,
            user_email: user.email, // Fixed mapping here
          }));
        } catch (error) {
          this.experiences = [
            {
              job_title: "",
              employer: "",
              start_date: "",
              end_date: "",
              current_work: false,
              short_description: "",
              user_email: user.email, // Fixed mapping here
              id: null,
            },
          ];
        }
      } else {
        console.error("No user data or email found.");
      }
    },
    async submitForm() {
      this.loading = true; // Set loading to true when the form is submitted
      try {
        const plainData = this.experiences.map((experience) => ({
          ...experience,
        }));
        console.log("Submitting data:", plainData);

        const response = await axios.post(
          "http://127.0.0.1:8000/api/experiences",
          { experiences: plainData },
          { headers: { "Content-Type": "application/json" } }
        );

        if (response.status === 201) {
          this.resetForm();
          this.$router.push("/resume/skills");
        }
      } catch (error) {
        this.errorMessage = error.response?.data?.message || "An error occurred!";
      } finally {
        this.loading = false; // Set loading to false after submission is done
      }
    },
    async deleteExperience(id, index) {
      try {
        const response = await axios.delete(
          `http://127.0.0.1:8000/api/experiences/${id}`
        );

        if (response.status === 200) {
          this.experiences.splice(index, 1);
          alert("Experience deleted successfully!");
        }
      } catch (error) {
        console.error("Error deleting record:", error.response?.data);
        alert("Failed to delete the experience record!");
      }
    },
    addExperience() {
      const user = JSON.parse(localStorage.getItem("user"));
      this.experiences.push({
        job_title: "",
        employer: "",
        start_date: "",
        end_date: "",
        current_work: false,
        short_description: "",
        user_email: user?.email, // Fixed mapping here
        id: null,
      });
    },
    removeExperience(index) {
      this.experiences.splice(index, 1);
    },
    resetForm() {
      this.experiences = [
        {
          job_title: "",
          employer: "",
          start_date: "",
          end_date: "",
          current_work: false,
          short_description: "",
          user_email: "",
          id: null,
        },
      ];
      this.errorMessage = "";
    },
  },
  mounted() {
    this.userEmail();
  },
};
</script>

<style scoped>
/* Additional Bootstrap customization if needed */
</style>
