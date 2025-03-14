<template>
    <div>
        <!-- Loader Overlay -->

        <div
            v-if="loading"
            class="loader-overlay position-fixed w-100 h-100 d-flex justify-content-center align-items-center"
        >
            <div class="loader-content text-center bg-white p-5 rounded shadow">
                <h3 class="loader-message fw-bold mb-4">Loading...</h3>

                <div class="loader spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>

                <div class="loader-details mt-4">
                    <h5 class="text-muted">40+ professional CV designs</h5>

                    <h5 class="text-muted">100,000+ pre-written phrases</h5>

                    <h5 class="text-muted">15,000+ job titles</h5>

                    <h5 class="text-muted">9+ template colour options</h5>
                </div>
            </div>
        </div>

        <!-- Main Content -->

        <div v-if="!loading" class="container mx-auto">
            <div class="row align-items-center">
                <!-- Left Section -->

                <div class="col-md-6 rounded p-4">
                    <div
                        class="h-100 d-flex flex-column justify-content-center"
                    >
                        <p class="fw-semibold fs-4 mb-2 text-custom">
                            Fast. Easy. Effective.
                        </p>

                        <h1 class="font-weight-bold">
                            The Best CV Maker Online.
                        </h1>

                        <p class="mt-3 text-muted">
                            We provide cutting-edge design solutions to bring
                            your ideas to life. From concept to creation, we're
                            here to innovate and inspire.
                        </p>

                        <div class="d-flex gap-2">
                            <router-link
                                :to="`/premiumcv/${templateId}/objective`"
                                class="btn btn-warning rounded-5 w-50 btn-lg mt-4"
                            >
                                Create Your CV
                            </router-link>

                            <router-link
                                to="/premiumcv/pdf-upload"
                                class="btn border border-secondary rounded-5 w-50 btn-lg mt-4"
                            >
                            Upload Exiting File
                            </router-link>
                        </div>
                    </div>
                </div>

                <!-- Right Section -->

                <div class="col-md-6 text-center bg-custom my-3 shadow">
                    <!-- Dynamic Image -->

                    <img
                        :src="template.image || '/hero-image.avif'"
                        alt="Creative Design"
                        class="img-fluid rounded"
                        width="430"
                        height="200"
                    />
                </div>
            </div>

            <Gideline />
        </div>
    </div>
</template>

<script lang="ts">
export default {
    data() {
        return {
            templateId: null,

            template: {
                imageUrl: "", // Add imageUrl to the template object
            },

            loading: true, // Add loading state
        };
    },

    mounted() {
        // Access the templateId from the route

        this.templateId = this.$route.params.templateId;

        // Fetch template data based on templateId

        this.fetchTemplate();
    },

    methods: {
        async fetchTemplate() {
            try {
                // Fetch template data from the API

                const response = await fetch(
                    `/api/cv-templates/${this.templateId}`
                );

                // Check if the response is OK (status code 200-299)

                if (!response.ok) {
                    throw new Error(`HTTP error! Status: ${response.status}`);
                }

                // Check if the response is JSON

                const contentType = response.headers.get("content-type");

                if (!contentType || !contentType.includes("application/json")) {
                    // If the response is not JSON, log the raw response text

                    const text = await response.text();

                    console.error(
                        "Response is not JSON. Actual response:",

                        text
                    );

                    throw new Error("Response is not JSON");
                }

                // Parse the JSON data

                const data = await response.json();

                this.template = {
                    ...data,

                    imageUrl: data.imageUrl || "/hero-image.avif",
                }; // Set imageUrl dynamically

                console.log("Template data:", this.template);
            } catch (error) {
                console.error("Error fetching template:", error);
            } finally {
                this.loading = false; // Set loading to false after data is fetched
            }
        },
    },
};
</script>

<style scoped>
.bg-custom {
    background: #f9faff;
}

.text-custom {
    color: #050748;
}

/* Loader Overlay Styles */

.loader-overlay {
    background-color: rgba(
        255,
        255,
        255,
        0.9
    ); /* Semi-transparent white background */

    z-index: 1050; /* Ensure it's above other content */
}

.loader-content {
    max-width: 500px;

    width: 100%;
}

.loader-message {
    font-size: 1.5rem;

    color: #050748;
}

.loader-details h5 {
    font-size: 1rem;

    margin: 0.5rem 0;
}
</style>
