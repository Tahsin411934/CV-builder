<template>
  <button
    class="btn btn-primary mt-4 justify-end"
    @click="generatePDF"
    style="float: right; margin-right: 20px"
  >
    Download PDF
  </button>
  <div>
    <div ref="contentToPrint" class="pdf-content">
      <div class="shadow-sm font-times" style="width: 76%">
        <div v-if="loading" class="loader-container">
          <div class="spinner"></div>
        </div>

        <div v-else class="">
          <!-- Personal Information -->
          <section v-if="info.heading">
            <div class="row w-100 mb-0">
              <div class="col-2 d-flex justify-content-between align-items-center">
                <img
                  :src="`http://127.0.0.1:8000/storage/${info.heading.image}`"
                  alt="Profile of {{ info.heading.name }}"
                  class="w-100 mb-0"
                  style="height: 90%"
                />
              </div>
              <div class="col-9 flex h-50 justify-start items-center">
                <div>
                  <p class="text-center fw-bold fs-5 mb-0" style="margin: 0">
                    {{ info.heading.name }}
                  </p>
                  <p class="text-center mb-0" style="margin: 0; font-size: 12px">
                    {{ info.heading.profession }}
                  </p>
                  <p class="mb-0" style="margin: 0; font-size: 12px">
                    <strong>City:</strong> {{ info.heading.city }} |
                    <strong>Phone:</strong> {{ info.heading.phone }} |
                    <strong>Email:</strong> {{ info.heading.email }}
                  </p>
                  <p class="text-center mb-0" style="margin: 0; font-size: 12px">
                    <strong>Github</strong> | <strong>Linkedin</strong> |
                    <strong>Portfolio</strong>
                  </p>
                </div>
              </div>
            </div>
          </section>

          <!-- Objective -->
          <section class="m-0 p-0" v-if="info.objective">
            <h2 class="mb-0 border-bottom fs-6" style="margin-top: -2px">Objective</h2>

            <p class="pt-1 text-justify" style="font-size: 11px">
              {{ info.objective.objective }}
            </p>
          </section>
          <!-- Skills -->
          <section v-if="info.skills">
            <h2 class="border-bottom fs-6" style="margin-top: -10px">Skills</h2>

            <p style="font-size: 11px; margin-top: -5px">
              <strong>Hard Skills:</strong> {{ info.skills.hard_skills }}
            </p>
            <p style="font-size: 11px; margin-top: -11px">
              <strong>Soft Skills:</strong> {{ info.skills.soft_skills }}
            </p>
          </section>
          <!-- Experience -->
          <section v-if="info.experience && info.experience.length > 0">
            <h2 class="border-bottom fs-6" style="margin-top: -10px">Experience</h2>

            <div class="mb-3" v-for="(job, index) in info.experience" :key="index">
              <div class="mb-0 d-flex justify-content-between">
                <p class="custom-text border-bottom border-dark fw-bold mb-0" style="font-size: 12px">
                  {{ job.employer }}
                </p>

                <p style="margin-bottom: 0; font-size: 12px">
                  {{ job.start_date }} - {{ job.end_date || "Present" }}
                </p>
              </div>

              <p
                class="mb-0"
                style="margin: 0; font-size: 11px; margin-top: 0; padding: 0"
              >
                <strong>Job Title:</strong> {{ job.job_title }}
              </p>

              <p style="margin: 0; font-size: 11px">
                <strong>Description:</strong> {{ job.short_description }}
              </p>
            </div>
          </section>

          <section v-if="info.projects && info.projects.length > 0">
            <h2 class="border-bottom fs-6" style="margin-top: -10px">Projects</h2>

            <div class="mb-3" v-for="(project, index) in info.projects" :key="index">
              <div class="mb-0 d-flex justify-content-between">
                <p class="custom-text fw-bold mb-0 border-bottom border-dark" style="font-size: 12px">
                  {{ project.name }}
                </p>

                <p style="margin-bottom: 0; font-size: 12px">
                  <a :href="project.live_link" target="_blank" v-if="project.live_link"
                    >Live Link</a
                  >
                  |
                  <a
                    :href="project.client_side"
                    target="_blank"
                    v-if="project.client_side"
                    >Client Side</a
                  >
                  |
                  <a
                    :href="project.server_side"
                    target="_blank"
                    v-if="project.server_side"
                    >Server Side</a
                  >
                  
                </p>
              </div>

              <p
                class="mb-0"
                style="margin: 0; font-size: 11px; margin-top: 0; padding: 0"
              >
                <strong>Overview:</strong> {{ project.overview }}
              </p>

              <p style="margin: 0; font-size: 11px">
                <strong>Feature:</strong> <span v-html="project.feature"></span>
                
              </p>
              <p style="font-size:11px; margin-top: -11px"><strong>Technologies Used::</strong> {{ project.technology_used || "" }}</p>
            </div>
          </section>

          <section v-if="info.education && info.education.length > 0">
            <h2 class="border-bottom fs-6">Education</h2>

            <div v-for="(education, index) in info.education" :key="index">
              <div class="mb-0 d-flex justify-content-between">
                <p class="fw-bold mb-0" style="font-size: 11px">
                  {{ education.name_of_exam }} in {{ education.institute }} -
                  {{ education.name_of_institute }}
                </p>

                <p style="margin-bottom: 0; font-size: 11px">
                  CGPA: {{ education.CGPA || "Present" }}
                </p>
              </div>
            </div>
          </section>
          <section
            class="mt-3"
            v-if="info.languageProficiency && info.languageProficiency.length > 0"
          >
            <h2 class="border-bottom pb-1 fs-6">Language Proficiency</h2>

            <div v-for="(language, index) in info.languageProficiency" :key="index">
              <div class="mb-0 d-flex justify-content-between">
                <p class="fw-bold mb-0" style="font-size: 12px">
                  {{ language.Language }} | {{ language.Proficiency }}
                </p>
              </div>
            </div>
          </section>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import jsPDF from "jspdf";
import axios from "axios";

export default {
  data() {
    return {
      info: {}, // Data for the CV.
      loading: true, // Tracks if the data is loading.
    };
  },
  methods: {
    async fetchData() {
      this.loading = true;
      const user = JSON.parse(localStorage.getItem("user"));
      if (user && user.email) {
        try {
          const response = await axios.get(
            `http://127.0.0.1:8000/api/summary/${user.email}`
          );
          this.info = response.data?.data || {};
        } catch (error) {
          console.error("Error fetching data:", error);
        } finally {
          this.loading = false;
        }
      }
    },
    generatePDF() {
      const doc = new jsPDF({
        orientation: "portrait",
        unit: "px",
        format: "a4",
      });

      const content = this.$refs.contentToPrint;

      // Ensure content is rendered before generating PDF
      if (content) {
        // Adjust content scaling and page margins
        doc.html(content, {
          callback: (doc) => {
            const fileName =
              `${this.info.heading?.name} - ${this.info.heading?.profession}` ||
              "document";

            doc.save(`${fileName}.pdf`);
          },
          x: 10,
          y: 10,
          width: 570, // Set the width to leave room for the margins (A4 width is 595px)
          windowWidth: 800, // Ensure window width is large enough for content
          autoPaging: true, // Automatically handle page breaks
          html2canvas: {
            scale: 0.7, // Scale down the content to ensure it fits within the page
            letterRendering: true,
          },
        });
      } else {
        console.error("Content to print not found.");
      }
    },
  },
  mounted() {
    this.fetchData();
  },
};
</script>

<style scoped>
section {
  margin: 0;
  padding: 0;
}

.spinner {
  width: 50px;
  height: 50px;
  border: 5px solid rgba(0, 0, 0, 0.1);
  border-top: 5px solid #3498db;
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

.pdf-content {
  margin: 0;
  padding: 10px;
}
</style>
