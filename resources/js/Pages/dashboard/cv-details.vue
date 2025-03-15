<template>
    <div class="card shadow-sm">
      <div class="text-custom p-3">
        <h5 class="fw-bold">Step-8: Finalize</h5>
        <p>
          Check your all info. You can make any necessary edits through an “Edit” button in
          your CV builder or template
        </p>
      </div>
      <!-- Display loading message -->
      <div v-if="loading" class="loader-container">
        <div class="spinner"></div>
      </div>
  
      <!-- Show fetched data -->
      <div v-else class="px-5">
        <!-- Personal Information -->
        <section v-if="info.heading">
          <div class="d-flex align-items-center justify-content-between mb-3">
            <h4 class="fw-semibold m-0">Heading Part</h4>
            <router-link
              to="/previous-step"
              class="btn btn-sm btn-warning text-dark text-decoration-none"
            >
              Edit
            </router-link>
          </div>
  
          <hr />
          <div class="row w-100">
            <div class="col-4 col-sm-3 d-flex justify-content-start align-items-center">
              <img
                :src="`http://127.0.0.1:8000/storage/${info.heading.image}`"
                alt=""
                class="profile-image mb-0"
              />
            </div>
            <div class="col-8 col-sm-9 d-flex justify-content-start align-items-center">
              <div>
                <h3 class="mb-0 text-center">{{ info.heading.name }}</h3>
                <p class="text-center mb-0">{{ info.heading.profession }}</p>
                <p class="mb-0">
                  <strong>City:</strong> {{ info.heading.city }}, Bangladesh |
                  <strong>Phone:</strong> {{ info.heading.phone }} |
                  <strong>Email:</strong> {{ info.heading.email }}
                </p>
                <p class="text-center pt-n3">
                  <strong>Github</strong> | <strong>Linkedin</strong> |
                  <strong>Portfolio</strong>
                </p>
              </div>
            </div>
          </div>
        </section>
  
        <!-- Objective -->
        <section v-if="info.objective">
          <div class="d-flex align-items-center justify-content-between mb-3">
            <h4 class="fw-semibold  m-0">Objective Part</h4>
            <router-link
              to="/previous-step"
              class="btn btn-sm btn-warning text-dark text-decoration-none"
            >
              Edit
            </router-link>
          </div>
  
          <hr />
          <p>{{ info.objective.objective }}</p>
        </section>
  
        <!-- Skills -->
        <section v-if="info.skills">
          <div class="d-flex align-items-center justify-content-between mb-3">
            <h4 class="fw-semibold m-0">Skills Part</h4>
            <router-link
              to="/previous-step"
              class="btn btn-sm btn-warning text-dark text-decoration-none"
            >
              Edit
            </router-link>
          </div>
          <hr />
          <p><strong>Hard Skills:</strong> {{ info.skills.hard_skills }}</p>
          <p><strong>Soft Skills:</strong> {{ info.skills.soft_skills }}</p>
        </section>
  
        <!-- Experience -->
        <section v-if="info.experience && info.experience.length > 0">
          <div class="d-flex align-items-center justify-content-between mb-3">
            <h4 class="fw-semibold m-0">Experience Part</h4>
            <router-link
              to="/previous-step"
              class="btn btn-sm btn-warning text-dark text-decoration-none"
            >
              Edit
            </router-link>
          </div>
          <hr />
          <ul>
            <li v-for="(job, index) in info.experience" :key="index">
              <div class="d-flex justify-content-between">
                <div>
                  <p class="fs-3 fw-bold custom-text text-decoration-underline mb-0">
                    {{ job.employer }}
                  </p>
                </div>
                <div>
                  <p>{{ job.start_date }} - {{ job.end_date || "Present" }}</p>
                </div>
              </div>
  
              <p class="mb-0"><strong>Job Title:</strong> {{ job.job_title }}</p>
  
              <p><strong>Description:</strong> {{ job.short_description }}</p>
            </li>
          </ul>
        </section>
  
        <!-- Education -->
        <section v-if="info.education && info.education.length > 0">
          <div class="d-flex align-items-center justify-content-between mb-3">
            <h4 class="fw-semibold m-0">Education Part</h4>
            <router-link
              to="/previous-step"
              class="btn btn-sm btn-warning text-dark text-decoration-none"
            >
              Edit
            </router-link>
          </div>
          <hr />
          <ul>
            <li v-for="(education, index) in info.education" :key="index">
              <p><strong>Institute:</strong> {{ education.name_of_institute }}</p>
              <p><strong>Exam Name:</strong> {{ education.name_of_exam }}</p>
              <p><strong>Institute Type:</strong> {{ education.institute }}</p>
              <p><strong>Board:</strong> {{ education.board || "N/A" }}</p>
              <p><strong>CGPA:</strong> {{ education.CGPA }}</p>
            </li>
          </ul>
        </section>
  
        <!-- Languages -->
        <section v-if="info.languageProficiency && info.languageProficiency.length > 0">
          <div class="d-flex align-items-center justify-content-between mb-3">
            <h4 class="fw-semibold m-0">Languages Part</h4>
            <router-link
              to="/previous-step"
              class="btn btn-sm btn-warning text-dark text-decoration-none"
            >
              Edit
            </router-link>
          </div>
          <hr />
          <ul>
            <li
              v-for="(languageProficiency, index) in info.languageProficiency"
              :key="index"
            >
              <p><strong>Language:</strong> {{ languageProficiency.Language }}</p>
              <p><strong>Proficiency:</strong> {{ languageProficiency.Proficiency }}</p>
            </li>
          </ul>
        </section>
        <section v-if="info.projects && info.projects.length > 0">
    <div class="d-flex align-items-center justify-content-between mb-3">
      <h4 class="fw-semibold m-0">Projects Part</h4>
      <router-link
        to="/project"
        class="btn btn-sm btn-warning text-dark text-decoration-none"
      >
        Edit
      </router-link>
    </div>
    <hr />
    <ul>
      <li v-for="(project, index) in info.projects" :key="index">
        <p><strong>Project Name:</strong> {{ project.name }}</p>
        <p><strong>Overview:</strong> {{ project.overview }}</p>
        <p><strong>Feature:</strong> <span v-html="project.feature"></span></p>
        <p><strong>Technologies Used:</strong> {{ project.technology_used || "N/A" }}</p>
        <p><strong>Live Link:</strong> {{ project.live_link || "N/A" }}</p>
        <p><strong>Client Side Repository:</strong> {{ project.client_side || "N/A" }}</p>
        <p><strong>Server Side Repository:</strong> {{ project.server_side || "N/A" }}</p>
        <p><strong>User Email:</strong> {{ project.user_email || "Not provided" }}</p>
      </li>
    </ul>
  </section>
  
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
              class="text-custom bg-warning border border-dark btn text-decoration-none mx-3 fw-medium hover-link px-4 fs-4 rounded-5"
            >
              Next
            </router-link>
          </div>
        </div>
      </div>
  
      <!-- Display error message if something goes wrong -->
      <div v-if="error" class="error">{{ error }}</div>
    </div>
  </template>
  
  <script>
  
  export default {
    data() {
      return {
        info: {}, // To store fetched data.
        loading: true, // Tracks whether data is being fetched.
        error: null, // To store any errors that occur during fetching.
      };
    },
    methods: {
      async fetchData() {
        this.loading = true; // Set loading to true before starting the fetch.
        this.error = null; // Clear previous errors.
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
            this.loading = false; // Stop the loading indicator once done.
          }
        } else {
          this.error = "User information is missing.";
          this.loading = false; // Stop the loading indicator.
        }
      },
    },
    mounted() {
      this.fetchData();
    },
  };
  </script>
  
  <style scoped>
  /* Add styles for better layout and presentation */
  h1 {
    text-align: center;
    margin-bottom: 2rem;
  }
  
  section {
    margin-bottom: 2rem;
  }
  
  h2 {
    margin-bottom: 1rem;
    color: #333;
  }
  
  ul {
    list-style-type: none;
    padding: 0;
  }
  
  li {
    background: #f4f4f4;
    margin: 0.5rem 0;
    padding: 0.5rem;
    border-radius: 4px;
  }
  
  strong {
    font-weight: bold;
  }
  
  .profile-image {
    width: 150px;
    height: 150px;
    border-radius: 50%;
    margin-top: 1rem;
  }
  
  .error {
    color: red;
    margin-top: 1rem;
  }
  .loader-container {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh; /* Full page height */
    background-color: rgba(255, 255, 255, 0.8); /* Optional backdrop */
  }
  
  .spinner {
    width: 50px;
    height: 50px;
    border: 5px solid rgba(0, 0, 0, 0.1);
    border-top-color: #3498db; /* Customize color */
    border-radius: 50%;
    animation: spin 1s linear infinite;
  }
  
  @keyframes spin {
    0% {
      transform: rotate(0deg);
    }
    100% {
      transform: rotate(360deg);
    }
  }
  
  @media (max-width: 576px) {
    .profile-image {
      width: 120px;
      height: 120px;
    }
  
    .text-custom p {
      font-size: 14px;
    }
  
    h3 {
      font-size: 18px;
    }
  
    .btn {
      font-size: 12px;
    }
  
    .fw-semibold {
      font-size: 18px;
    }
  
    .row {
      flex-direction: column;
    }
  }
  
  @media (min-width: 577px) and (max-width: 768px) {
    .profile-image {
      width: 130px;
      height: 130px;
    }
  
    h3 {
      font-size: 22px;
    }
  
    .btn {
      font-size: 14px;
    }
  }
  </style>