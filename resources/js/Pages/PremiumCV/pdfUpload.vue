<template>
    <div class="container mt-3">
        <!-- Step Indicator -->

        <!-- Header Section -->
        <div class="card shadow-sm">
            <div class="d-flex">
                <div class="text-custom p-3">
                    <h5 class="fw-bold">Step-1: Instructions</h5>
                </div>
            </div>
            <hr />
            <!-- Form Section -->
            <div class="">
                <div class=" ">
                    <div class="card-body">
                        <form @submit.prevent="submitForm">
                            <div class="mb-3 text-center">
                                <div
                                    class="file-upload-area p-4 border rounded-3"
                                    @dragover.prevent="dragOver"
                                    @drop.prevent="handleDrop"
                                    @click="triggerFileInput"
                                >
                                    <input
                                        type="file"
                                        id="pdf_file"
                                        ref="fileInput"
                                        @change="handleFileUpload"
                                        class="d-none"
                                        accept=".pdf,.doc,.docx"
                                    />
                                    <i
                                        class="bi bi-upload display-4 text-muted"
                                    ></i>
                                    <p class="mt-2 mb-0">
                                        Drag & drop a PDF or Word file here or
                                        <span class="text-primary"
                                            >click to upload</span
                                        >
                                    </p>
                                    <small class="text-muted"
                                        >Supported formats: .pdf, .doc,
                                        .docx</small
                                    >
                                </div>
                                <div v-if="pdfFileUrl" class="mb-3 text-center text-danger">
                                    <label class="form-label"
                                        >Uploaded File:
                                    </label>
                                    <a
                                        :href="pdfFileUrl"
                                        target="_blank"
                                        class="text-danger "
                                    >
                                        {{ uploadedFileName }}
                                    </a>
                                </div>
                            </div>

                            <!-- Display Uploaded File URL -->

                            <!-- Instruction Field -->
                            <div class="mb-3">
                                <label for="instruction" class="form-label"
                                    >Write or update instructions about where and how to upgrade your CV:
                                </label>
                                <textarea
                                    id="instruction"
                                    v-model="formData.instruction"
                                    class="form-control pb-5"
                                    rows="3"
                                    placeholder="Enter your career instruction or summary"
                                    required
                                ></textarea>
                            </div>

                            <!-- Custom File Upload Area -->

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
                                            <span v-else>Next: Payment</span>
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
    name: "InstructionForm",
    data() {
        return {
            templateId: null,
            formData: {
                instruction: "",
                user_email: "",
                pdf_file: null, // Added for file upload
            },
            pdfFileUrl: null, // Added to store the file URL
            uploadedFileName: "", // Added to display the uploaded file name
            successMessage: "",
            errorMessage: "",
            loading: false,
        };
    },
    methods: {
        async userEmail() {
            const user = JSON.parse(localStorage.getItem("user"));
            if (user && user.email) {
                try {
                    const response = await axios.get(
                        `/api/instruction/${user.email}`
                    );
                    const data = response.data.data;

                    // Update form data with the retrieved data
                    this.formData = {
                        instruction: data.instruction || "",
                        user_email: data.user_email || user.email,
                    };

                    // If a file URL is available, display it
                    if (data.pdf_file_url) {
                        this.pdfFileUrl = data.pdf_file_url;
                        this.uploadedFileName = data.pdf_file_url
                            .split("/")
                            .pop();
                    }
                } catch (error) {
                    this.formData.user_email = user.email;
                    console.error("Error fetching instruction:", error);
                }
            } else {
                console.error("No user data or email found.");
            }
        },
        triggerFileInput() {
            this.$refs.fileInput.click();
        },
        handleFileUpload(event) {
            const file = event.target.files[0];
            this.validateAndSetFile(file);
        },
        handleDrop(event) {
            const file = event.dataTransfer.files[0];
            this.validateAndSetFile(file);
        },
        validateAndSetFile(file) {
            if (
                file &&
                (file.type === "application/pdf" ||
                    file.type === "application/msword" ||
                    file.type ===
                        "application/vnd.openxmlformats-officedocument.wordprocessingml.document")
            ) {
                this.formData.pdf_file = file;
                this.uploadedFileName = file.name;
                this.errorMessage = ""; // Clear any previous error message
            } else {
                this.errorMessage = "Please upload a valid PDF or Word file.";
                this.formData.pdf_file = null;
                this.uploadedFileName = "";
            }
        },
        dragOver(event) {
            event.preventDefault();
            event.currentTarget.classList.add("drag-over");
        },
        async submitForm() {
            this.successMessage = "";
            this.errorMessage = "";
            this.loading = true;

            try {
                const formData = new FormData();
                formData.append("instruction", this.formData.instruction);
                formData.append("user_email", this.formData.user_email);
                if (this.formData.pdf_file) {
                    formData.append("pdf_file", this.formData.pdf_file);
                }

                const response = await axios.post(
                    "/api/instructions",
                    formData,
                    {
                        headers: {
                            "Content-Type": "multipart/form-data",
                        },
                    }
                );

                this.successMessage = response.data.message;
                this.formData.instruction = "";
                this.formData.pdf_file = null;
                this.pdfFileUrl = null; // Clear the file URL after submission
                this.uploadedFileName = ""; // Clear the uploaded file name
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
                this.loading = false;
            }
        },
    },
    mounted() {
        this.userEmail();
        this.templateId = this.$route.params.id;
        console.log(this.templateId);
    },
};
</script>

<style scoped>
.text-custom {
    color: #050748;
}

.file-upload-area {
    background-color: #f8f9fa;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.file-upload-area:hover {
    background-color: #e9ecef;
}

.file-upload-area.drag-over {
    background-color: #dee2e6;
}

.bi-upload {
    font-size: 3rem;
}
</style>
