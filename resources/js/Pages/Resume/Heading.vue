<template>
  <div class="w-full mx-auto mt-10 p-5 rounded">
    <form @submit.prevent="submitForm" enctype="multipart/form-data">
      <!-- Row with two columns -->
      <div class="row mb-4">
        <!-- Left column for image preview and file upload -->
        <div class="col-md-2 d-flex flex-column">
          <!-- Show default image or preview -->
          <div v-if="!imagePreview && form.image">
            <img
              :src="
                form.image
                  ? `http://127.0.0.1:8000/storage/${form.image}`
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
            <img src="/notfound.jpg" alt="">
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
        <div class="col-md-10 d-flex align-items-center justify-content-center">
          <div class="text-center">
            <h2>Give Your Info For Creating Free CV</h2>
            <p>Fill in the details below to proceed with your CV creation.</p>
          </div>
        </div>
      </div>

      <!-- Other form fields -->
      <div class="row mb-4">
        <div class="col-md-6">
          <label for="name" class="form-label">Name</label>
          <input
            v-model="form.name"
            type="text"
            id="name"
            class="form-control"
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
          <label for="city" class="form-label">City</label>
          <input
            v-model="form.city"
            type="text"
            id="city"
            class="form-control"
            required
          />
        </div>
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
          <label for="profession" class="form-label">Profession</label>
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
        <label for="postal_code" class="form-label">Postal Code</label>
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
        <div class="col-12 d-flex justify-content-end">
          <router-link
            to="/resume"
            class="text-dark border border-blue-950 btn text-decoration-none mx-3 fw-medium hover-link px-4 fs-4 rounded-5"
          >
            Previous
          </router-link>
          <button type="submit" class="btn btn-warning px-4 fs-4 rounded-5">Next</button>
        </div>
      </div>
    </form>

    <!-- Success or error message -->
    <div v-if="message" class="mt-4 p-4 bg-success text-white rounded">
      {{ message }}
    </div>
    <div v-if="errorMessage" class="mt-4 p-4 bg-danger text-white rounded">
      {{ errorMessage }}
    </div>
  </div>
</template>

<script>
import axios from "axios";

export default {
  data() {
    return {
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
      imagePreview: null, // Data property to store image preview URL
    };
  },

  methods: {
    async userEmail() {
      const user = JSON.parse(localStorage.getItem("user"));
      if (user && user.email) {
        try {
          const response = await axios.get(
            `http://127.0.0.1:8000/api/headings/${user.email}`
          );
          const data = response.data?.data || {};
          this.form = {
            ...this.form,
            name: data.name || "",
            email: data.email || user.email, // Set the email if not found in the data
            city: data.city || "",
            phone: data.phone || "",
            country: data.country || "",
            profession: data.profession || "",
            postal_code: data.postal_code || "",
            image: data.image || "",
          };
        } catch (error) {
          // Fallback if data is not fetched
          this.form.email = user.email; // Ensure email is always set
        }
      } else {
        console.error("No user data or email found.");
      }
    },

    handleFileUpload(event) {
      const file = event.target.files[0];
      if (file) {
        this.form.image = file;

        // Create a preview URL for the image
        const reader = new FileReader();
        reader.onload = (e) => {
          this.imagePreview = e.target.result; // Set the imagePreview data property
        };
        reader.readAsDataURL(file);
      }
    },

    async submitForm() {
      const formData = new FormData();
      for (const key in this.form) {
        if (this.form[key]) {
          formData.append(key, this.form[key]);
        }
      }

      try {
        const response = await axios.post("http://127.0.0.1:8000/api/test", formData, {
          headers: {
            "Content-Type": "multipart/form-data",
          },
        });
        this.message = response.data.message;
        this.errorMessage = null;
        this.resetForm();
      } catch (error) {
        console.error("Error submitting form:", error.response?.data || error);
        if (error.response && error.response.data.errors) {
          this.errorMessage = `Validation Error: ${JSON.stringify(
            error.response.data.errors
          )}`;
        } else {
          this.errorMessage = "Failed to submit the form. Please try again.";
        }
        this.message = null;
      }
      this.$router.push("/education");
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
      this.imagePreview = null; // Reset image preview
      this.$refs.fileInput.value = null; // Reset file input
    },
  },

  mounted() {
    this.userEmail();
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
  border: 1px solid #1e3a8a; /* Replace with your desired shade of blue */
}
</style>
