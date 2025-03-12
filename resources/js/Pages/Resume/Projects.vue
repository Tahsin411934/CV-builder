<template>
  <div class="container mt-2 card shadow-sm">
    <div class="col-md-9 d-flex">
      <div class="text-custom pt-3">
        <h5 class="fw-bold">Step-5: Projects</h5>
        <p>
          Provide details about the projects you have worked on. This section helps showcase your skills and expertise.
        </p>
      </div>
    </div>

    <!-- Form for multiple project records -->
    <form @submit.prevent="submitForm">
      <div
        v-for="(project, index) in projects"
        :key="index"
        class="mb-4 p-3 border rounded bg-light"
      >
        <h4 class="text-primary mb-3">
          {{ project.name || "New Project" }}
        </h4>

        <!-- Row 1 -->
        <div class="row mb-3">
          <div class="col-md-6">
            <label class="form-label">Project Name</label>
            <input
              v-model="project.name"
              type="text"
              class="form-control"
              placeholder="Enter project name"
              required
            />
          </div>
          <div class="col-md-6">
            <label class="form-label">Overview</label>
            <textarea
              v-model="project.overview"
              class="form-control"
              placeholder="Enter project overview"
            ></textarea>
          </div>
        </div>

        <!-- Row 2 -->
        <div class="row mb-3">
          <div class="col-md-6">
            <label class="form-label">Features</label>
            <!-- Contenteditable Div for Features -->
            <div
              contenteditable="true"
              class="form-control"
              placeholder="Describe key features"
              style="min-height: 150px; white-space: pre-wrap; outline: none;"
              @input="updateFeatures(project, $event)"
              v-html="project.feature"
            ></div>
            <!-- Simplified Toolbar -->
            <div class="d-flex mt-2">
              <button
                type="button"
                @click="insertList('unordered')"
                class="btn btn-sm btn-outline-secondary"
              >
                UL
              </button>
            </div>
          </div>
          <div class="col-md-6">
            <label class="form-label">Technologies Used</label>
            <input
              v-model="project.technology_used"
              type="text"
              class="form-control"
              placeholder="Enter technologies used"
            />
          </div>
        </div>

        <!-- Row 3 -->
        <div class="row mb-3">
          <div class="col-md-6">
            <label class="form-label">Live Link</label>
            <input
              v-model="project.live_link"
              type="url"
              class="form-control"
              placeholder="Enter live project URL"
            />
          </div>
          <div class="col-md-6">
            <label class="form-label">Client Side Repository</label>
            <input
              v-model="project.client_side"
              type="url"
              class="form-control"
              placeholder="Enter client-side repository URL"
            />
          </div>
        </div>

        <!-- Row 4 -->
        <div class="row mb-3">
          <div class="col-md-6">
            <label class="form-label">Server Side Repository</label>
            <input
              v-model="project.server_side"
              type="url"
              class="form-control"
              placeholder="Enter server-side repository URL"
            />
          </div>
          <div class="col-md-6">
            <label class="form-label">User Email</label>
            <input
              v-model="project.user_email"
              type="email"
              class="form-control"
              placeholder="Enter your email"
              required
            />
          </div>
        </div>

        <!-- Remove and Delete buttons -->
        <div class="d-flex justify-content-between">
          <button @click.prevent="removeProject(index)" class="btn btn-danger btn-sm">
            Remove
          </button>
          <button
            v-if="project.id"
            @click.prevent="deleteProject(project.id, index)"
            class="btn btn-outline-danger btn-sm"
          >
            Delete
          </button>
        </div>
      </div>

      <!-- Add New Project Button -->
      <div class="d-grid gap-2 mb-3 w-25">
        <button @click.prevent="addProject" class="btn btn-success">
          Add Another Project
        </button>
      </div>

      <!-- Navigation and Submit -->
      <div class="row mb-4">
        <div class="col-12 d-flex justify-content-between">
          <router-link
            to="/experience"
            class="text-dark border border-dark btn text-decoration-none mx-3 fw-medium hover-link px-4 fs-4 rounded-5"
          >
            Previous
          </router-link>
          <div>
            <router-link
              style="background: #388e3c"
              to="/resume/review"
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
export default {
  data() {
    return {
      templateId: null,
      projects: [],
      errorMessage: "",
      loading: false,
    };
  },
  methods: {
    async fetchProjects() {
      const user = JSON.parse(localStorage.getItem("user"));
      if (user && user.email) {
        try {
          const response = await axios.get(
            `http://127.0.0.1:8000/api/project/${user.email}`
          );
          this.projects = response.data.data || [];
        } catch (error) {
          this.projects = [
            {
              name: "",
              overview: "",
              feature: "",
              technology_used: "",
              live_link: "",
              client_side: "",
              server_side: "",
              user_email: user.email,
              id: null,
            },
          ];
        }
      }
    },
    async submitForm() {
      this.loading = true;
      try {
        const response = await axios.post(
          "http://127.0.0.1:8000/api/projects",
          { projects: this.projects },
          { headers: { "Content-Type": "application/json" } }
        );
        if (response.status === 201) {
          this.$router.push("/resume/finalize");
          this.$router.push(
                    this.templateId
                        ? `/premiumcv/${this.templateId}/finalize`
                        : "/finalize"
                );
        }
      } catch (error) {
        this.errorMessage = error.response?.data?.message || "An error occurred!";
      } finally {
        this.loading = false;
      }
    },
    async deleteProject(id, index) {
      try {
        await axios.delete(`http://127.0.0.1:8000/api/projects/${id}`);
        this.projects.splice(index, 1);
        alert("Project deleted successfully!");
      } catch (error) {
        alert("Failed to delete the project!");
      }
    },
    addProject() {
      const userEmail = JSON.parse(localStorage.getItem("user"))?.email;
      this.projects.push({
        name: "",
        overview: "",
        feature: "",
        technology_used: "",
        live_link: "",
        client_side: "",
        server_side: "",
        user_email: userEmail || "",
        id: null,
      });
    },
    removeProject(index) {
      this.projects.splice(index, 1);
    },
    updateFeatures(project, event) {
      project.feature = event.target.innerHTML; // Update the project feature with the latest content from the editable div
    },
    insertList(type) {
      if (type === "unordered") {
        document.execCommand("insertUnorderedList", false, null);
      }
    },
  },
  mounted() {
    this.fetchProjects();
    this.templateId = this.$route.params.id;
  },
};
</script>

<style scoped>
/* Add any specific styles here */
</style>
