<template>
  <div class="container mt-2 card shadow-sm">
    <div class="col-md-9 d-flex">
      <div class="text-custom pt-3">
        <h5 class="fw-bold">Step-6: Language Proficiency</h5>
        <p>
          Fill in the details below to proceed with your CV creation. Follow all the steps
          carefully to build a professional CV tailored just for you
        </p>
      </div>
    </div>

    <!-- Form for multiple language proficiency records -->
    <form @submit.prevent="submitForm">
      <div
        v-for="(language, index) in languages"
        :key="index"
        class="mb-4 p-3 border rounded bg-light"
      >
        <h4 class="text-primary mb-3">
          {{ language.Language || "New Record" }}
        </h4>

        <!-- Row 1 -->
        <div class="row mb-3">
          <div class="col-md-6">
            <label for="Language" class="form-label">Language</label>
            <input
              v-model="language.Language"
              type="text"
              class="form-control"
              placeholder="Enter language"
              required
            />
          </div>
          <div class="col-md-6">
  <label for="Proficiency" class="form-label">Proficiency</label>
  <select
    v-model="language.Proficiency"
    class="form-control"
    required
  >
    <option disabled value="">Select proficiency level</option>
    <option value="Native">Native</option>
    <option value="Beginner">Beginner</option>
    <option value="Intermediate">Intermediate</option>
    <option value="Advanced">Advanced</option>
    <option value="Fluent">Fluent</option>
    
  </select>
</div>

        </div>

        <!-- Row 2 (user email) -->
        <div class="row mb-3 d-none">
          <div class="col-md-6">
            <label for="user_email" class="form-label">User Email</label>
            <input
              v-model="language.user_email"
              type="email"
              class="form-control"
              placeholder="Enter your email"
              required
            />
          </div>
        </div>

        <!-- Remove and Delete buttons -->
        <div class="d-flex justify-content-between">
          <button @click.prevent="removeLanguage(index)" class="btn btn-danger btn-sm">
            Remove
          </button>
          <button
            v-if="language.id"
            @click.prevent="deleteLanguage(language.id, index)"
            class="btn btn-outline-danger btn-sm"
          >
            Delete
          </button>
        </div>
      </div>

      <!-- Button to add new language proficiency entry -->
      <div class="d-grid gap-2 mb-3 w-25">
        <button @click.prevent="addLanguage" class="btn btn-success">
          Add Another Language Proficiency Record
        </button>
      </div>

      <div class="row mb-4">
        <div class="col-12 d-flex justify-content-between">
          <router-link
            to="/resume/skills"
            class="text-dark border border-dark btn text-decoration-none mx-3 fw-medium hover-link px-4 fs-4 rounded-5"
          >
            Previous
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
    </form>

    <!-- Error Message Display -->
    <div v-if="errorMessage" class="alert alert-danger mt-3">
      {{ errorMessage }}
    </div>
  </div>
</template>

<script>


export default {
  data() {
    return {
      templateId: null,
      languages: [
        {
          Language: "",
          Proficiency: "",
          user_email: "",
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
      console.log(user)
      if (user && user.email) {
        try {
          const response = await axios.get(
            `http://127.0.0.1:8000/api/language-proficiencybyemail/${user.email}`
          );
          const data = response.data?.data || [];
          this.languages = data.map((item) => ({
            ...item,
            user_email: user.email,
          }));
        } catch (error) {
            this.languages =[
                {
                     Language: "",
                    Proficiency: "",
                    user_email: user.email,
                    id:null,
                }
            ]
          
        }
      } else {
        console.error("No user data or email found.");
      }
    },
    async submitForm() {
      this.loading = true;
      try {
        const plainData = this.languages.map((language) => ({
          ...language,
        }));

        const response = await axios.post(
          "http://127.0.0.1:8000/api/language-proficiency",
          { languages: plainData },
          { headers: { "Content-Type": "application/json" } }
        );

        if (response.status === 201) {
          this.resetForm();

       
          this.$router.push(
                    this.templateId
                        ? `/premiumcv/${this.templateId}/project`
                        : "/project"
                );

        }
      } catch (error) {
        this.errorMessage = error.response?.data?.message || "An error occurred!";
      } finally {
        this.loading = false;
      }
    },
    async deleteLanguage(id, index) {
      try {
        const response = await axios.delete(
          `http://127.0.0.1:8000/api/language-proficiency/${id}`
        );

        if (response.status === 200) {
          this.languages.splice(index, 1);
          alert("Language proficiency record deleted successfully!");
        }
      } catch (error) {
        console.error("Error deleting record:", error);
        alert("Failed to delete the language proficiency record!");
      }
    },
    addLanguage() {
      const user = JSON.parse(localStorage.getItem("user"));
      this.languages.push({
        Language: "",
        Proficiency: "",
        user_email: user?.email,
        id: null,
      });
    },
    removeLanguage(index) {
      this.languages.splice(index, 1);
    },
    resetForm() {
      this.languages = [
        {
          Language: "",
          Proficiency: "",
          user_email: "",
          id: null,
        },
      ];
      this.errorMessage = "";
    },
  },
  mounted() {
    this.userEmail();
    this.templateId = this.$route.params.id;
  },
};
</script>

<style scoped>
/* Add any custom styles if necessary */
</style>
