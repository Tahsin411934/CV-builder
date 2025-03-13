<template>
    <div class="container mt-3">
        <!-- Step Indicator -->

        <!-- Header Section -->
        <div class="d-flex align-items-center justify-content-center">
            <div class="text-center">
                <h2 class="text-custom">Create Your Resume Now!</h2>
                <p>
                    Follow all the steps carefully to build a professional CV
                    tailored just for you. Provide your details below to
                    continue. <br />
                    Once you complete all steps, you will have access to
                    download your CV for free!
                </p>
            </div>
        </div>
        <div class="card shadow-sm">
            <div class="d-flex">
                <div class="text-custom p-3">
                    <h5 class="fw-bold">Step-1:Objective</h5>
                </div>
            </div>
            <hr />
            <!-- Form Section -->
            <div class="">
                <div class=" ">
                    <div class="card-body">
                        <form @submit.prevent="submitForm">
                            <!-- Objective Field -->
                            <div class="mb-3">
                                <label for="objective" class="form-label"
                                    >Write or update Objective:
                                </label>
                                <textarea
                                    id="objective"
                                    v-model="formData.objective"
                                    class="form-control pb-5"
                                    rows="3"
                                    placeholder="Enter your career objective or summary "
                                    required
                                ></textarea>
                            </div>

                            <!-- Email Field (Hidden but populated) -->
                            <div class="mb-3 d-none">
                                <label for="user_email" class="form-label"
                                    >Email</label
                                >
                                <input
                                    type="email"
                                    id="user_email"
                                    v-model="formData.user_email"
                                    class="form-control"
                                    placeholder="Enter your email"
                                    required
                                    readonly
                                />
                            </div>

                            <!-- Submit and Navigation Buttons -->
                            <div class="row mb-4">
                                <div
                                    class="col-12 d-flex justify-content-between"
                                >
                                    <!-- Previous Button -->
                                    <router-link
                                        to="/overview"
                                        class="text-custom border d-none d-md-block border-dark btn btn-lg text-decoration-none mx-3 fw-medium hover-link px-4 rounded-5"
                                    >
                                        Previous
                                    </router-link>
                                    <router-link
                                        to="/overview"
                                        class="text-custom d-block d-md-none btn btn-sm text-decoration-none mx-3 fw-medium hover-link rounded-5"
                                    >
                                        ⬅️
                                    </router-link>

                                    <!-- Skip and Next Buttons -->
                                    <div class="d-flex">
                                        <router-link
                                            style="background: #388e3c"
                                            :to="
                                                templateId
                                                    ? `/premiumcv/${templateId}/heading`
                                                    : '/heading'
                                            "
                                            class="text-white btn btn-lg d-none d-md-block text-decoration-none mx-3 fw-medium hover-link px-4 rounded-5"
                                        >
                                            Skip
                                        </router-link>
                                        <router-link
                                            style="background: #388e3c"
                                            to="
                                                templateId
                                                    ? `/premiumcv/${templateId}/heading`
                                                    : '/heading'
                                            "
                                            class="text-white btn d-block d-md-none text-decoration-none mx-3 fw-medium hover-link px-4 rounded-5"
                                        >
                                            Skip
                                        </router-link>

                                        <button
                                            type="submit"
                                            class="btn btn-warning px-4 rounded-5 btn-lg d-none d-md-block"
                                        >
                                            <span
                                                v-if="loading"
                                                class="spinner-border spinner-border-sm"
                                                role="status"
                                                aria-hidden="true"
                                            ></span>
                                            <span v-else>Next</span>
                                        </button>
                                        <button
                                            type="submit"
                                            class="btn btn-warning px-4 rounded-5 d-block d-md-none"
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

                        <!-- Success Message -->
                        <div
                            v-if="successMessage"
                            class="alert alert-success mt-4"
                        >
                            {{ successMessage }}
                        </div>

                        <!-- Error Message -->
                        <div
                            v-if="errorMessage"
                            class="alert alert-danger mt-4"
                        >
                            {{ errorMessage }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from "axios";

export default {
    name: "ObjectiveForm",
    data() {
        return {
            templateId: null,
            formData: {
               
                objective: "",
                user_email: "",
            },
            successMessage: "",
            errorMessage: "",
            loading: false, // Added loading variable
        };
    },
    methods: {
        async userEmail() {
            const user = JSON.parse(localStorage.getItem("user"));
            if (user && user.email) {
                try {
                    const response = await axios.get(
                        `/api/objective/${user.email}`
                    );
                    const data = response.data?.data || {};
                    console.log(data);
                    this.formData = {
                        ...this.formData,
                        objective: data.objective || "",
                        user_email: data.user_email || user.email,
                    };
                } catch (error) {
                    this.formData.user_email = user.email;
                }
            } else {
                console.error("No user data or email found.");
            }
        },
        async submitForm() {
            this.successMessage = "";
            this.errorMessage = "";
            this.loading = true; // Start loading
            try {
                const response = await axios.post(
                    "/api/objectives",
                    this.formData
                );
                this.successMessage = response.data.message;
                this.formData.objective = "";
                this.$router.push(
                    this.templateId
                        ? `/premiumcv/${this.templateId}/heading`
                        : "/heading"
                );
            } catch (error) {
                if (error.response && error.response.data) {
                    this.errorMessage =
                        error.response.data.message || "An error occurred.";
                } else {
                    this.errorMessage = "Unable to connect to the server.";
                }
            } finally {
                this.loading = false; // Stop loading
            }
        },
    },
    mounted() {
        this.userEmail(); // Fetch the user's email and data on mount
        this.templateId = this.$route.params.id;
        console.log(this.templateId);
    },
};
</script>

<style scoped>
.text-custom {
    color: #050748;
}
</style>
