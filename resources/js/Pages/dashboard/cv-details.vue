<template>
    <div class="card shadow-sm">
        <!-- Display loading message -->
        <div v-if="loading" class="loader-container">
            <div class="spinner"></div>
        </div>

        <!-- Show fetched data -->
        <div v-else class="px-5">
            <section>

              <div
                    class="d-flex align-items-center justify-content-between mb-3"
                >
                    <h5 class="fw-semibold m-0">Selected Tamplate</h5>
                </div>
                <hr />
              {{ info?.tamplete }}
            </section>
            <!-- Personal Information -->
            <section v-if="info.heading">
                <div
                    class="d-flex align-items-center justify-content-between mb-3"
                >
                    <h5 class="fw-semibold m-0">Heading</h5>
                </div>

                <hr />
                <div class="row w-100">
                    <div class="col-4 col-sm-3">
                        <!-- Add click event to download the image -->
                        <img
                            :src="`http://127.0.0.1:8000/storage/${info.heading.image}`"
                            alt="Profile Image"
                            class="profile-image mb-0"
                            @click="downloadImage(info.heading.image)"
                            style="cursor: pointer"
                        />
                        <button @click="downloadImage(info.heading.image)">
                            download Image
                        </button>
                    </div>

                    <div
                        class="col-8 col-sm-9 d-flex justify-content-start align-items-center"
                    >
                        <div>
                            <h3 class="mb-0 text-center">
                                {{ info.heading.name }}
                            </h3>
                            <p class="text-center mb-0">
                                {{ info.heading.profession }}
                            </p>
                            <p class="mb-0">
                                <strong>City:</strong> {{ info.heading.city }},
                                Bangladesh | <strong>Phone:</strong>
                                {{ info.heading.phone }} |
                                <strong>Email:</strong> {{ info.heading.email }}
                            </p>
                            <p class="text-center pt-n3">
                                <strong>Github</strong> |
                                <strong>Linkedin</strong> |
                                <strong>Portfolio</strong>
                            </p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Objective -->
            <section v-if="info.objective">
                <div
                    class="d-flex align-items-center justify-content-between mt-2"
                >
                    <h5 class="fw-semibold">Objective</h5>
                </div>

                <hr />
                <p>{{ info.objective.objective }}</p>
            </section>

            <!-- Skills -->
            <section v-if="info.skills">
                <div
                    class="d-flex align-items-center justify-content-between mb-3"
                >
                    <h5 class="fw-semibold m-0">Skills</h5>
                </div>
                <hr />
                <p>
                    <strong>Hard Skills:</strong> {{ info.skills.hard_skills }}
                </p>
                <p>
                    <strong>Soft Skills:</strong> {{ info.skills.soft_skills }}
                </p>
            </section>

            <!-- Experience -->
            <section v-if="info.experience && info.experience.length > 0">
                <div
                    class="d-flex align-items-center justify-content-between mb-3"
                >
                    <h5 class="fw-semibold m-0">Experience</h5>
                </div>
                <hr />
                <ul class="row align-items-center justify-content-around">
                    <li
                        class="col-6"
                        v-for="(job, index) in info.experience"
                        :key="index"
                    >
                        <div class="d-flex justify-content-between">
                            <div>
                                <p
                                    class="fw-bold custom-text text-decoration-underline mb-0"
                                >
                                    {{ job.employer }}
                                </p>
                            </div>
                            <div>
                                <p>
                                    {{ job.start_date }} -
                                    {{ job.end_date || "Present" }}
                                </p>
                            </div>
                        </div>

                        <p class="mb-0">
                            <strong>Job Title:</strong> {{ job.job_title }}
                        </p>

                        <p>
                            <strong>Description:</strong>
                            {{ job.short_description }}
                        </p>
                    </li>
                </ul>
            </section>

            <!-- Education -->
            <section v-if="info.education && info.education.length > 0">
                <div
                    class="d-flex align-items-center justify-content-between mb-3"
                >
                    <h5 class="fw-semibold m-0">Education</h5>
                </div>
                <hr />
                <ul class="row align-items-center justify-content-around">
                    <!-- Apply flex here -->
                    <li
                        class="col-6"
                        v-for="(education, index) in info.education"
                        :key="index"
                    >
                        <div>
                            <div>
                                <p>
                                    <strong>Exam Name:</strong>
                                    {{ education.name_of_exam }}
                                </p>
                                <p>
                                    <strong>Institute:</strong>
                                    {{ education.name_of_institute }}
                                </p>

                                <p>
                                    <strong>Institute Type:</strong>
                                    {{ education.institute }}
                                </p>
                                <p>
                                    <strong>Board:</strong>
                                    {{ education.board || "N/A" }}
                                </p>
                                <p>
                                    <strong>CGPA:</strong> {{ education.CGPA }}
                                </p>
                            </div>
                        </div>
                    </li>
                </ul>
            </section>

            <!-- Languages -->
            <section
                v-if="
                    info.languageProficiency &&
                    info.languageProficiency.length > 0
                "
            >
                <div
                    class="d-flex align-items-center justify-content-between mb-3"
                >
                    <h5 class="fw-semibold m-0">Languages</h5>
                </div>
                <hr />
                <ul class="row align-items-center justify-content-around">
                    <li
                        class="col-4"
                        v-for="(
                            languageProficiency, index
                        ) in info.languageProficiency"
                        :key="index"
                    >
                        <p>
                            <strong>Language:</strong>
                            {{ languageProficiency.Language }}
                        </p>
                        <p>
                            <strong>Proficiency:</strong>
                            {{ languageProficiency.Proficiency }}
                        </p>
                    </li>
                </ul>
            </section>
            <section v-if="info.projects && info.projects.length > 0">
                <div
                    class="d-flex align-items-center justify-content-between mb-3"
                >
                    <h5 class="fw-semibold m-0">Projects</h5>
                </div>
                <hr />
                <ul class="row align-items-center justify-content-around">
                    <li
                        class="col-6"
                        v-for="(project, index) in info.projects"
                        :key="index"
                    >
                        <p><strong>Project Name:</strong> {{ project.name }}</p>
                        <p><strong>Overview:</strong> {{ project.overview }}</p>
                        <p>
                            <strong>Feature:</strong>
                            <span v-html="project.feature"></span>
                        </p>
                        <p>
                            <strong>Technologies Used:</strong>
                            {{ project.technology_used || "N/A" }}
                        </p>
                        <p>
                            <strong>Live Link:</strong>
                            {{ project.live_link || "N/A" }}
                        </p>
                        <p>
                            <strong>Client Side Repository:</strong>
                            {{ project.client_side || "N/A" }}
                        </p>
                        <p>
                            <strong>Server Side Repository:</strong>
                            {{ project.server_side || "N/A" }}
                        </p>
                        <p>
                            <strong>User Email:</strong>
                            {{ project.user_email || "Not provided" }}
                        </p>
                    </li>
                </ul>
            </section>
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
            const email = this.$route.params.email; // Get email from route parameters
            if (email) {
                try {
                    const response = await axios.get(
                        `http://127.0.0.1:8000/api/summary/${email}`
                    );
                    this.info = response.data?.data || {};
                } catch (error) {
                    console.error("Error fetching data:", error);
                    this.error =
                        "Failed to fetch data. Please try again later.";
                } finally {
                    this.loading = false; // Stop the loading indicator once done.
                }
            } else {
                this.error = "User email is missing.";
                this.loading = false; // Stop the loading indicator.
            }
        },
        // Method to download the image
        downloadImage(imagePath) {
            const imageUrl = `http://127.0.0.1:8000/storage/${imagePath}`;
            const link = document.createElement("a");
            link.href = imageUrl;
            link.download = imagePath.split("/").pop(); // Extract the filename from the path
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        },
    },
    mounted() {
        this.fetchData();
    },
};
</script>
