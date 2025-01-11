<template>
  <div class="w-full mx-auto mt-10 p-5 rounded">
    <form @submit.prevent="submitForm" enctype="multipart/form-data">
      <!-- First row with two columns -->
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

      <!-- Second row with two columns -->
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

      <!-- Third row with two columns -->
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

      <!-- Fourth row with one column for postal code -->
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

      <!-- Image upload row -->
      <div class="mb-4">
        <label for="image" class="form-label">Upload Image</label>
        <input
          type="file"
          id="image"
          class="form-control"
          @change="handleFileUpload"
          ref="fileInput"
        />
        
        <!-- Image Preview -->
        <div v-if="imagePreview" class="mt-3 ">
          <img :src="imagePreview" width="100" alt="Image Preview" class="img-fluid" />
        </div>
      </div>

      <!-- Submit button -->
      <div class="row mb-4">
        <div class="col-12 d-flex justify-content-end">
           <router-link
          to="/resume"
          class="text-dark bg-info btn text-decoration-none mx-3 fw-medium hover-link"
        >
          Previous
        </router-link>
          <button type="submit" class="btn btn-primary">Next</button>
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
</style>
