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
                                
                                <!-- File Name Display Section -->
                                <div v-if="uploadedFileName" class="mt-3">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <label class="form-label fw-bold">Uploaded File:</label>
                                        <button 
                                            type="button" 
                                            class="btn btn-sm btn-outline-danger"
                                            @click="removeFile"
                                        >
                                            Remove
                                        </button>
                                    </div>
                                    
                                    <div class="border rounded p-3 bg-light">
                                        <p class="mb-0">
                                            <i :class="fileIconClass"></i>
                                            {{ uploadedFileName }}
                                        </p>
                                    </div>
                                </div>
                            </div>

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
                                            :disabled="loading"
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
                pdf_file: null,
            },
            uploadedFileName: "",
            fileType: "",
            successMessage: "",
            errorMessage: "",
            loading: false,
        };
    },
    computed: {
        fileIconClass() {
            if (this.uploadedFileName.endsWith('.pdf')) {
                return 'bi bi-file-earmark-pdf-fill text-danger';
            } else if (this.uploadedFileName.endsWith('.doc') || this.uploadedFileName.endsWith('.docx')) {
                return 'bi bi-file-earmark-word-fill text-primary';
            }
            return 'bi bi-file-earmark-fill';
        }
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

                    this.formData = {
                        instruction: data.instruction || "",
                        user_email: data.user_email || user.email,
                    };

                    if (data.pdf_file_url) {
                        this.uploadedFileName = data.pdf_file_url.split("/").pop();
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
            this.processFile(file);
        },
        handleDrop(event) {
            const file = event.dataTransfer.files[0];
            this.processFile(file);
        },
        processFile(file) {
            if (!file) return;

            const validTypes = [
                'application/pdf',
                'application/msword',
                'application/vnd.openxmlformats-officedocument.wordprocessingml.document'
            ];
            
            if (!validTypes.includes(file.type)) {
                this.errorMessage = "Please upload a valid PDF or Word file.";
                return;
            }

            this.formData.pdf_file = file;
            this.uploadedFileName = file.name;
            this.errorMessage = "";
        },
        removeFile() {
            this.formData.pdf_file = null;
            this.uploadedFileName = "";
            this.$refs.fileInput.value = '';
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
                this.uploadedFileName = "";
                
                // Navigate to next step
                this.$router.push(
                    this.templateId
                        ? `/premiumcv/payment/${this.templateId}`
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
        this.templateId = this.$route.params.templateId;
        console.log(this.templateId);
    }
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
    border: 2px dashed #0d6efd;
}

.bi-upload {
    font-size: 3rem;
}

/* File icon colors */
.bi-file-earmark-pdf-fill {
    color: #d93a33;
}
.bi-file-earmark-word-fill {
    color: #2b579a;
}
</style>