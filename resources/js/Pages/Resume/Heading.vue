<template>
    <div class="card shadow-sm m-2">
        <div class="w-full mx-auto py-3 rounded card-body">
            <form @submit.prevent="submitForm" enctype="multipart/form-data">
                <!-- Row with two columns -->
                <div class="row">
                    <div class="col-md-9 d-flex">
                        <div class="text-custom pt-3">
                            <h5 class="fw-bold">Step-2:Heading</h5>
                            <p>
                                Fill in the details below to proceed with your
                                CV creation. Follow all the steps carefully to
                                build a professional CV tailored just for you
                            </p>
                        </div>
                    </div>

                    <!-- Left column for image preview and file upload -->
                    <div class="col-md-3 d-flex flex-column">
                        <!-- Show default image or preview -->
                        <div v-if="!imagePreview && form.image">
                            <img
                                :src="
                                    form.image
                                        ? `http://127.0.0.1:8000/storage/app/public/${form.image}`
                                        : '/notfound.jpg'
                                "
                                style="width: 150px; height: 120px"
                                alt="User Image"
                                class="img-fluid border"
                            />
                        </div>

                        <!-- Show image preview if available -->
                        <div v-if="imagePreview">
                            <img
                                :src="imagePreview"
                                alt="Image Preview"
                                style="width: 150px; height: 120px"
                                class="img-fluid border"
                            />
                        </div>

                        <!-- Show a border if no image or preview is set -->
                        <div
                            v-if="!form.image && !imagePreview"
                            class="img-fluid border"
                            style="width: 150px; height: 120px"
                        >
                            <img src="/notfound.jpg" alt="Not Found" />
                        </div>

                        <!-- File input for uploading the image -->
                        <input
                            type="file"
                            id="image"
                            class="mt-2 border-none"
                            @change="handleFileUpload"
                            ref="fileInput"
                        />
                    </div>

                    <!-- Right column for the info text -->
                </div>

                <!-- Other form fields -->
                <div class="row mb-4">
                    <div class="col-md-6">
                        <label for="name" class="form-label">Name</label>
                        <input
                            v-model="form.name"
                            type="text"
                            id="name"
                            class="form-control rounded-none"
                            required
                        />
                    </div>
                    <div class="col-md-6">
                        <label for="email" class="form-label">Email</label>
                        <input
                            v-model="form.email"
                            type="email"
                            id="email"
                            class="form-control"
                            required
                            readonly
                        />
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-6">
                        <label for="phone" class="form-label">Phone</label>
                        <input
                            v-model="form.phone"
                            type="text"
                            id="phone"
                            class="form-control"
                            required
                        />
                    </div>
                    <div class="col-md-6">
                        <label for="city" class="form-label">City</label>
                        <input
                            v-model="form.city"
                            type="text"
                            id="city"
                            class="form-control"
                            required
                        />
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-6">
                        <label for="country" class="form-label">Country</label>
                        <input
                            v-model="form.country"
                            type="text"
                            id="country"
                            class="form-control"
                            required
                        />
                    </div>
                    <div class="col-md-6">
                        <label for="profession" class="form-label"
                            >Designation/Profession</label
                        >
                        <input
                            v-model="form.profession"
                            type="text"
                            id="profession"
                            class="form-control"
                            required
                        />
                    </div>
                </div>

                <div class="mb-4">
                    <label for="postal_code" class="form-label"
                        >Postal Code</label
                    >
                    <input
                        v-model="form.postal_code"
                        type="text"
                        id="postal_code"
                        class="form-control"
                        required
                    />
                </div>

                <!-- Submit button -->
                <div class="row mb-4">
                    <div class="col-12 d-flex justify-content-between">
                        <router-link
                            :to="
                                templateId
                                    ? `/premiumcv/${templateId}/objective`
                                    : '/objective'
                            "
                            class="text-custom border border-dark btn text-decoration-none mx-3 fw-medium hover-link px-4 fs-4 rounded-5"
                        >
                            Previous
                        </router-link>

                        <!-- Skip and Next Buttons -->
                        <div>
                            <!-- Skip Button -->
                            <router-link
                                style="background: #388e3c"
                                :to="
                                    templateId
                                        ? `/premiumcv/${templateId}/education`
                                        : '/education'
                                "
                                class="text-white btn text-decoration-none mx-3 fw-medium hover-link px-4 fs-4 rounded-5"
                            >
                                Skip
                            </router-link>
                            <button
                                type="submit"
                                class="btn btn-warning px-4 fs-4 rounded-5"
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

            <!-- Success or error message -->
            <div v-if="message" class="mt-4 p-4 bg-success text-white rounded">
                {{ message }}
            </div>
            <div
                v-if="errorMessage"
                class="mt-4 p-4 bg-danger text-white rounded"
            >
                {{ errorMessage }}
            </div>
        </div>
    </div>
</template>

<script>
import axios from "axios";

export default {
    data() {
        return {
            templateId: null,
            form: {
                name: "",
                email: "",
                city: "",
                phone: "",
                country: "",
                profession: "",
                postal_code: "",
                image: null,
            },
            message: null,
            errorMessage: null,
            imagePreview: null,
            loading: false, // Add loading state
        };
    },
    methods: {
        async userEmail() {
            const user = JSON.parse(localStorage.getItem("user"));
            if (user && user.email) {
                try {
                    const response = await axios.get(
                        `/api/headings/${user.email}`
                    );
                    const data = response.data?.data || {};
                    console.log(data);
                    this.form = {
                        ...this.form,
                        name: data.name || "",
                        email: data.email || user.email,
                        city: data.city || "",
                        phone: data.phone || "",
                        country: data.country || "",
                        profession: data.profession || "",
                        postal_code: data.postal_code || "",
                        image: data.image || "",
                    };
                } catch (error) {
                    console.error(error);
                    this.form.email = user.email;
                }
            } else {
                console.error("No user data or email found.");
            }
        },

        handleFileUpload(event) {
            const file = event.target.files[0];
            if (file) {
                this.form.image = file;
                const reader = new FileReader();
                reader.onload = (e) => {
                    this.imagePreview = e.target.result;
                };
                reader.readAsDataURL(file);
            } else {
                this.form.image = null;
                this.imagePreview = null;
            }
        },

        async submitForm() {
            this.loading = true;
            const formData = new FormData();

            // Append fields to the formData, skipping the image if it's empty or null
            for (const key in this.form) {
                if (this.form[key] !== null && this.form[key] !== undefined) {
                    // Skip appending the image field if no image is selected
                    if (
                        key === "image" &&
                        (!this.form[key] || this.form[key] === "")
                    ) {
                        continue; // Skip appending the image if it's null or empty
                    }
                    formData.append(key, this.form[key]);
                }
            }

            try {
                const response = await axios.post(
                    "/api/test",
                    formData,
                    {
                        headers: {
                            "Content-Type": "multipart/form-data",
                        },
                    }
                );
                this.message = response.data.message;
                this.errorMessage = null;
                this.resetForm();
                // this.$router.push("/education");
                this.$router.push(
                    this.templateId
                        ? `/premiumcv/${this.templateId}/education`
                        : "/education"
                );
            } catch (error) {
                console.error(
                    "Error submitting form:",
                    error.response?.data || error
                );
                this.errorMessage = error.response?.data?.errors
                    ? `Validation Error: ${JSON.stringify(
                          error.response.data.errors
                      )}`
                    : "Failed to submit the form. Please try again.";
                this.message = null;
            } finally {
                this.loading = false; // Hide spinner
            }
        },

        resetForm() {
            this.form = {
                name: "",
                email: "",
                city: "",
                phone: "",
                country: "",
                profession: "",
                postal_code: "",
                image: null,
            };
            this.imagePreview = null;
            this.$refs.fileInput.value = null;
        },
    },

    mounted() {
        this.userEmail();
        this.templateId = this.$route.params.id;
    },
};
</script>

<style scoped>
.form-control {
    border: 1px solid #ccc;
    border-radius: 4px;
    padding: 10px;
}
.form-control:focus {
    border-color: #007bff;
    outline: none;
}
.bg-success {
    background-color: #28a745 !important;
}
.bg-danger {
    background-color: #dc3545 !important;
}
.border-blue-950 {
    border: 1px solid #1e3a8a;
}
.text-custom {
    color: #050748;
}
</style>
