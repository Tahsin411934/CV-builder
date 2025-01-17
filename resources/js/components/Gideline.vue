<template>
    <div class="container mt-5">
      <!-- Heading -->
      <h1 class="mb-4 text-center">Step-by-Step Resume Guide</h1>
  
      <!-- All Steps -->
      <div class="steps-container">
        <div v-for="(step, index) in steps" :key="index" class="card shadow-sm mb-3">
          <div class="card-body">
            <h5 class="card-title mb-3">{{ step.label }}</h5>
            <p class="card-text">{{ step.instruction }}</p>
            <button
              v-if="step.route"
              class="btn text-white" style="background-color:#050748;"
              @click="navigateTo(step.route)"
            >
              Go to {{ step.label }}
            </button>
          </div>
        </div>
      </div>
    </div>
  </template>
  
  <script>
  export default {
    name: "Guideline",
    data() {
      return {
        currentStep: 0,
        steps: [
          {
            label: "Step 1: Objective",
            instruction:
              "Your CV's objective should clearly define what you are looking for in a job position. It should be a brief statement that highlights your goals and the value you can bring to the company.",
            route: "/resume/objective",
          },
          {
            label: "Step 2: Heading",
            instruction:
              "Include your name, title (optional), and contact details (email, phone number, LinkedIn, etc.) in this section. This information helps recruiters contact you easily.",
            route: "/heading",
          },
          {
            label: "Step 3: Education",
            instruction:
              "List your educational background here. Include the name of the institutions, the degrees you obtained, and your graduation dates. Mention any notable academic achievements or honors.",
            route: "/education",
          },
          {
            label: "Step 4: Experience",
            instruction:
              "Provide details about your work experience. For each job, list the company name, your job title, and the duration of your employment. Include your key responsibilities and accomplishments.",
            route: "/experience",
          },
          {
            label: "Step 5: Skills",
            instruction:
              "This section should highlight your relevant skills. Mention both technical skills (e.g., programming languages, software tools) and soft skills (e.g., leadership, communication).",
            route: "/resume/skills",
          },
          {
            label: "Step 6: Language Proficiency",
            instruction:
              "If you speak more than one language, list the languages and your level of proficiency (e.g., beginner, intermediate, fluent). This can be important for international job opportunities.",
            route: "/resume/language-proficiency",
          },
          {
            label: "Step 7: Projects",
            instruction:
              "Add any relevant projects you have worked on, including personal, academic, or professional projects. Provide a brief description of each project, your role, and any key outcomes.",
            route: "/project",
          },
          {
            label: "Step 8: Summary",
            instruction:
              "Write a short summary that ties together your experience, skills, and career goals. This section serves as a personal statement and should summarize your qualifications succinctly.",
            route: "/resume/finalize",
          },
          {
            label: "Step 9: Finalize & PDF",
            instruction:
              "After completing all the sections, review your CV. Make sure all sections are filled out and well-formatted. Once you're satisfied, you can generate a PDF version of your CV.",
            route: "/resume/PDF",
          },
        ],
      };
    },
    methods: {
      navigateTo(route) {
        this.$router.push(route); // Ensure Vue Router is set up in your project
      },
    },
  };
  </script>
  
  <style scoped>
  .steps-container {
    display: flex;
    flex-direction: column;
  }
  
  .card-body {
    text-align: left; /* Align content to the left */
  }
  
  .card-title {
    font-size: 1.5rem;
  }
  
  .card-text {
    font-size: 1.1rem;
  }
  
  button {
    margin-top: 15px;
    background: #050748; /* Button background color */
    border: none; /* Remove default border */
    color: white; /* Ensure text is visible */
  }
  
  button:hover {
    background: #040637; /* Slightly darker background on hover */
  }
  </style>
  