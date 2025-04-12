<template>
  <div class="container m-2 card shadow-sm">
    <div class="text-custom pt-3">
      <h5 class="fw-bold">Step-3: Education</h5>
      <p>
        Fill in the details below to proceed with your CV creation. Follow all the steps
        carefully.
      </p>
    </div>

    <!-- Form for multiple education records -->
    <form @submit.prevent="submitForm">
      <div
        v-for="(education, index) in educations"
        :key="index"
        class="mb-4 p-3 border rounded bg-light"
      >
        <h4 class="text-primary mb-3">{{ education.title || "New Record" }}</h4>

        <!-- Row 1 -->
        <div class="row mb-3">
          <div class="col-md-6">
            <label for="name_of_institute" class="form-label">Name of Institute</label>
            <input
              v-model="education.name_of_institute"
              type="text"
              class="form-control"
              placeholder="Enter name of institute"
              required
            />
          </div>
          <div class="col-md-6">
            <label for="name_of_exam" class="form-label">Name of Exam</label>
            <select
              v-model="education.name_of_exam"
              @change="updateTitle(index)"
              class="form-select"
              required
            >
              <option value="" disabled>Select exam</option>
              <option value="SSC">SSC</option>
              <option value="HSC">HSC</option>
              <option value="BSc">BSc</option>
              <option value="BBA">BBA</option>
              <option value="MSc">MSc</option>
              <option value="BSS">BSS</option>
              <option value="MBA">MBA</option>
              <option value="PhD">PhD</option>
            </select>
          </div>
        </div>

        <!-- Row 2 -->
        <div class="row mb-3">
          <div class="col-md-6">
            <label for="institute" class="form-label">Group/Dept</label>
            <input
              v-model="education.institute"
              type="text"
              class="form-control"
              placeholder="Enter institute name (optional)"
            />
          </div>
          <div class="col-md-6">
            <label for="board" class="form-label">Board</label>
            <input
              v-model="education.board"
              type="text"
              class="form-control"
              placeholder="Enter board name (optional)"
            />
          </div>
        </div>

        <!-- Row 3 -->
        <div class="row mb-3">
          <div class="col-md-6">
            <label for="CGPA" class="form-label">CGPA</label>
            <input
              v-model="education.CGPA"
              type="number"
              step="0.01"
              class="form-control"
              placeholder="Enter CGPA (optional)"
            />
          </div>
          <div class="col-md-6 d-none">
            <label for="user_mail" class="form-label">User Email</label>
            <input
              v-model="education.user_mail"
              type="email"
              class="form-control"
              placeholder="Enter your email"
              required
            />
          </div>
        </div>

        <!-- Remove and Delete buttons -->
        <div class="d-flex justify-content-between">
          <button @click.prevent="removeEducation(index)" class="btn btn-danger btn-sm">
            Remove
          </button>
          <button
            v-if="education.id"
            @click.prevent="deleteEducation(education.id, index)"
            class="btn btn-outline-danger btn-sm"
          >
            Delete
          </button>
        </div>
      </div>

      <!-- Button to add new education entry -->
      <div class="d-grid gap-2 mb-3 w-25">
        <button @click.prevent="addEducation" class="btn btn-success">
          Add Another Educational Qualification
        </button>
      </div>

      <div class="row mb-4">
        <div class="col-12 d-flex justify-content-between">
          <router-link
            to="/heading"
            class="text-dark border border-dark btn text-decoration-none mx-3 fw-medium hover-link px-4 fs-4 rounded-5"
          >
            Previous
          </router-link>
          <div>
            <router-link
              style="background: #388e3c"
              to="/experience"
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
              <span v-if="!loading">Next</span>
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
      templateId: null,
      educations: [
        {
          name_of_institute: "",
          name_of_exam: "",
          institute: "",
          board: "",
          CGPA: "",
          user_mail: "",
          title: "",
          id: null, // Added ID for existing records
        },
      ],
      errorMessage: "",
      loading: false, // Add loading state
    };
  },
  methods: {
    async userEmail() {
      const user = JSON.parse(localStorage.getItem("user"));
      if (user && user.email) {
        try {
          const response = await axios.get(
            `/api/educations/user/${user.email}`
          );
          const data = response.data?.data || [];
          this.educations = data.map((item) => ({
            ...item,
            title: this.generateTitle(item.name_of_exam),
          }));
        } catch (error) {
          this.educations = [
            {
              name_of_institute: "",
              name_of_exam: "",
              institute: "",
              board: "",
              CGPA: "",
              user_mail: user.email,
              title: "",
              id: null,
            },
          ];
        }
      } else {
        console.error("No user data or email found.");
      }
    },
    async submitForm() {
      this.loading = true; // Start loading
      try {
        const plainData = this.educations.map((education) => ({ ...education }));
        console.log("Submitting data:", plainData);

        const response = await axios.post(
          "/api/educations/store",
          { educations: plainData },
          { headers: { "Content-Type": "application/json" } }
        );

        if (response.status === 201) {
          this.resetForm();
          // this.$router.push("/experience");
          this.$router.push(
                    this.templateId
                        ? `/premiumcv/${this.templateId}/experience`
                        : "/experience"
                );
        }
      } catch (error) {
        this.errorMessage = error.response?.data?.message || "An error occurred!";
      } finally {
        this.loading = false; // Stop loading after submission
      }
    },
    async deleteEducation(id, index) {
      try {
        const response = await axios.delete(
          `/api/educations/delete/${id}`
        );

        if (response.status === 200) {
          this.educations.splice(index, 1);
          alert("Record deleted successfully!");
        }
      } catch (error) {
        console.error("Error deleting record:", error.response?.data);
        alert("Failed to delete the record!");
      }
    },
    addEducation() {
      const user = JSON.parse(localStorage.getItem("user"));
      this.educations.push({
        name_of_institute: "",
        name_of_exam: "",
        institute: "",
        board: "",
        CGPA: "",
        user_mail: user?.email,
        title: "",
        id: null,
      });
    },
    removeEducation(index) {
      this.educations.splice(index, 1);
    },
    resetForm() {
      this.educations = [
        {
          name_of_institute: "",
          name_of_exam: "",
          institute: "",
          board: "",
          CGPA: "",
          user_mail: "",
          title: "",
          id: null,
        },
      ];
      this.errorMessage = "";
    },
    updateTitle(index) {
      const selectedExam = this.educations[index].name_of_exam;
      this.educations[index].title = this.generateTitle(selectedExam);
    },
    generateTitle(exam) {
      switch (exam) {
        case "SSC":
          return "Secondary School Certificate";
        case "HSC":
          return "Higher Secondary Certificate";
        case "BSc":
          return "Bachelor of Science";
        case "BBA":
          return "Bachelor of Business Administration";
        case "MSc":
          return "Master of Science";
        case "MBA":
          return "Master of Business Administration";
        case "PhD":
          return "Doctor of Philosophy";
        case "BSS":
          return "Master of Science"; // Fixed case for BSS
        default:
          return "New Record";
      }
    },
  },
  mounted() {
    this.userEmail();
    this.templateId = this.$route.params.id;
  },
};
</script>

<style scoped>
/* Add custom CSS for loading spinner if needed */
</style>
