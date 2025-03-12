<template>
    <div class="card shadow-sm">
      <div class="p-3">
        <h5 class="fw-bold mb-3">Step-8: Finalize</h5>
        <p class="mb-4">
          Review your information. Use the "Edit" button to make any changes.
        </p>
      </div>
  
      <!-- Loading Spinner -->
      <div v-if="loading" class="d-flex justify-content-center align-items-center vh-100">
        <div class="spinner-border text-primary" role="status">
          <span class="visually-hidden">Loading...</span>
        </div>
      </div>
  
      <!-- Display Data -->
      <div v-else class="px-3 px-md-5">
        <!-- Personal Information -->
        <section v-if="info.heading" class="mb-4">
          <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="fw-semibold mb-0">Heading Part</h4>
            <router-link to="/previous-step" class="btn btn-sm btn-warning text-dark">
              Edit
            </router-link>
          </div>
          <hr class="mb-4" />
          <div class="row align-items-center">
            <div class="col-4 col-sm-3 text-center">
              <img
                :src="`http://127.0.0.1:8000/storage/${info.heading.image}`"
                alt="Profile Image"
                width="200"
                height="200"
                class="img-fluid "
              />
            </div>
            <div class="col-8 col-sm-9">
              <h3 class="mb-1">{{ info.heading.name }}</h3>
              <p class="mb-1">{{ info.heading.profession }}</p>
              <p class="mb-1"><strong>City:</strong> {{ info.heading.city }}, Bangladesh</p>
              <p class="mb-1"><strong>Phone:</strong> {{ info.heading.phone }}</p>
              <p class="mb-1"><strong>Email:</strong> {{ info.heading.email }}</p>
              <p class="mb-0">
                <strong>Github</strong> | <strong>Linkedin</strong> | <strong>Portfolio</strong>
              </p>
            </div>
          </div>
        </section>
  
        <!-- Objective -->
        <section v-if="info.objective" class="mb-4">
          <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="fw-semibold mb-0">Objective Part</h4>
            <router-link to="/previous-step" class="btn btn-sm btn-warning text-dark">
              Edit
            </router-link>
          </div>
          <hr class="mb-4" />
          <p class="mb-0">{{ info.objective.objective }}</p>
        </section>
  
        <!-- Skills -->
        <section v-if="info.skills" class="mb-4">
          <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="fw-semibold mb-0">Skills Part</h4>
            <router-link to="/previous-step" class="btn btn-sm btn-warning text-dark">
              Edit
            </router-link>
          </div>
          <hr class="mb-4" />
          <p class="mb-1"><strong>Hard Skills:</strong> {{ info.skills.hard_skills }}</p>
          <p class="mb-0"><strong>Soft Skills:</strong> {{ info.skills.soft_skills }}</p>
        </section>
  
        <!-- Experience -->
        <section v-if="info.experience && info.experience.length > 0" class="mb-4">
          <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="fw-semibold mb-0">Experience Part</h4>
            <router-link to="/previous-step" class="btn btn-sm btn-warning text-dark">
              Edit
            </router-link>
          </div>
          <hr class="mb-4" />
          <ul class="list-unstyled">
            <li v-for="(job, index) in info.experience" :key="index" class="mb-3">
              <div class="d-flex justify-content-between">
                <p class="fw-bold mb-1">{{ job.employer }}</p>
                <p class="text-muted">{{ job.start_date }} - {{ job.end_date || "Present" }}</p>
              </div>
              <p class="mb-1"><strong>Job Title:</strong> {{ job.job_title }}</p>
              <p class="mb-0"><strong>Description:</strong> {{ job.short_description }}</p>
            </li>
          </ul>
        </section>
  
        <!-- Education -->
        <section v-if="info.education && info.education.length > 0" class="mb-4">
          <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="fw-semibold mb-0">Education Part</h4>
            <router-link to="/previous-step" class="btn btn-sm btn-warning text-dark">
              Edit
            </router-link>
          </div>
          <hr class="mb-4" />
          <ul class="list-unstyled">
            <li v-for="(education, index) in info.education" :key="index" class="mb-3">
              <p class="mb-1"><strong>Institute:</strong> {{ education.name_of_institute }}</p>
              <p class="mb-1"><strong>Exam Name:</strong> {{ education.name_of_exam }}</p>
              <p class="mb-1"><strong>Institute Type:</strong> {{ education.institute }}</p>
              <p class="mb-1"><strong>Board:</strong> {{ education.board || "N/A" }}</p>
              <p class="mb-0"><strong>CGPA:</strong> {{ education.CGPA }}</p>
            </li>
          </ul>
        </section>
  
        <!-- Languages -->
        <section v-if="info.languageProficiency && info.languageProficiency.length > 0" class="mb-4">
          <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="fw-semibold mb-0">Languages Part</h4>
            <router-link to="/previous-step" class="btn btn-sm btn-warning text-dark">
              Edit
            </router-link>
          </div>
          <hr class="mb-4" />
          <ul class="list-unstyled">
            <li v-for="(language, index) in info.languageProficiency" :key="index" class="mb-3">
              <p class="mb-1"><strong>Language:</strong> {{ language.Language }}</p>
              <p class="mb-0"><strong>Proficiency:</strong> {{ language.Proficiency }}</p>
            </li>
          </ul>
        </section>
  
        <!-- Projects -->
        <section v-if="info.projects && info.projects.length > 0" class="mb-4">
          <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="fw-semibold mb-0">Projects Part</h4>
            <router-link to="/project" class="btn btn-sm btn-warning text-dark">
              Edit
            </router-link>
          </div>
          <hr class="mb-4" />
          <ul class="list-unstyled">
            <li v-for="(project, index) in info.projects" :key="index" class="mb-3">
              <p class="mb-1"><strong>Project Name:</strong> {{ project.name }}</p>
              <p class="mb-1"><strong>Overview:</strong> {{ project.overview }}</p>
              <p class="mb-1"><strong>Feature:</strong> <span v-html="project.feature"></span></p>
              <p class="mb-1"><strong>Technologies Used:</strong> {{ project.technology_used || "N/A" }}</p>
              <p class="mb-1"><strong>Live Link:</strong> {{ project.live_link || "N/A" }}</p>
              <p class="mb-1"><strong>Client Side Repository:</strong> {{ project.client_side || "N/A" }}</p>
              <p class="mb-0"><strong>Server Side Repository:</strong> {{ project.server_side || "N/A" }}</p>
            </li>
          </ul>
        </section>
  
        <!-- Navigation Buttons -->
        <div class="row mb-4">
        <div class="col-12 d-flex justify-content-between">
          <router-link
            to="/resume"
            class="text-custom border border-dark btn text-decoration-none mx-3 fw-medium hover-link px-4 fs-4 rounded-5"
          >
            Previous
          </router-link>
          <router-link
            to="/resume/PDF"
            class="text-white bg-success border border-dark btn text-decoration-none mx-3 fw-medium hover-link px-4 fs-4 rounded-5"
          >
            Order Now
          </router-link>
        </div>
      </div>
      </div>
  
      <!-- Error Message -->
      <div v-if="error" class="alert alert-danger mt-3">
        {{ error }}
      </div>
    </div>
  </template>
  
  <script>
  export default {
    data() {
      return {
        info: {},
        loading: true,
        error: null,
      };
    },
    methods: {
      async fetchData() {
        this.loading = true;
        this.error = null;
        const user = JSON.parse(localStorage.getItem("user"));
        if (user && user.email) {
          try {
            const response = await axios.get(
              `http://127.0.0.1:8000/api/summary/${user.email}`
            );
            this.info = response.data?.data || {};
          } catch (error) {
            console.error("Error fetching data:", error);
            this.error = "Failed to fetch data. Please try again later.";
          } finally {
            this.loading = false;
          }
        } else {
          this.error = "User information is missing.";
          this.loading = false;
        }
      },
    },
    mounted() {
      this.fetchData();
    },
  };
  </script>
  
  <style scoped>
  /* Minimal custom CSS */
  .profile-image {
    width: 120px;
    height: 120px;
  }
  
  @media (max-width: 576px) {
    .profile-image {
      width: 100px;
      height: 100px;
    }
  }
  </style>