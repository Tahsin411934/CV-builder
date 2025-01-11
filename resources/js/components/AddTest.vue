<template>
  <div class="max-w-md mx-auto mt-10 p-5 border rounded">
    <h1 class="text-xl font-bold mb-4">Add Test Data</h1>
    <form @submit.prevent="submitForm" enctype="multipart/form-data">
      <div class="mb-4">
        <label for="name" class="block text-sm font-medium">Name</label>
        <input
          v-model="form.name"
          type="text"
          id="name"
          class="form-input w-full border rounded px-3 py-2"
          required
        />
      </div>
      <div class="mb-4">
        <label for="email" class="block text-sm font-medium">Email</label>
        <input
          v-model="form.email"
          type="email"
          id="email"
          class="form-input w-full border rounded px-3 py-2"
          required
        />
      </div>
      <div class="mb-4">
        <label for="city" class="block text-sm font-medium">City</label>
        <input
          v-model="form.city"
          type="text"
          id="city"
          class="form-input w-full border rounded px-3 py-2"
          required
        />
      </div>
      <div class="mb-4">
        <label for="phone" class="block text-sm font-medium">Phone</label>
        <input
          v-model="form.phone"
          type="text"
          id="phone"
          class="form-input w-full border rounded px-3 py-2"
          required
        />
      </div>
      <div class="mb-4">
        <label for="country" class="block text-sm font-medium">Country</label>
        <input
          v-model="form.country"
          type="text"
          id="country"
          class="form-input w-full border rounded px-3 py-2"
          required
        />
      </div>
      <div class="mb-4">
        <label for="profession" class="block text-sm font-medium">Profession</label>
        <input
          v-model="form.profession"
          type="text"
          id="profession"
          class="form-input w-full border rounded px-3 py-2"
          required
        />
      </div>
      <div class="mb-4">
        <label for="postal_code" class="block text-sm font-medium">Postal Code</label>
        <input
          v-model="form.postal_code"
          type="text"
          id="postal_code"
          class="form-input w-full border rounded px-3 py-2"
          required
        />
      </div>
      <div class="mb-4">
        <label for="image" class="block text-sm font-medium">Upload Image</label>
        <input
          type="file"
          id="image"
          class="form-input w-full border rounded px-3 py-2"
          @change="handleFileUpload"
        />
      </div>
      <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">
        Submit
      </button>
    </form>
    <div v-if="message" class="mt-4 p-4 bg-green-100 border border-green-400 text-green-700">
      {{ message }}
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
        image: null, // New field for image
      },
      message: null,
    };
  },

  methods: {
    handleFileUpload(event) {
      const file = event.target.files[0];
      if (file) {
        this.form.image = file; // Store the selected file in the form data
      }
    },

    async submitForm() {
      const formData = new FormData();
      // Append all form fields to FormData
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
        this.resetForm();
      } catch (error) {
        console.error(error);
      }
    },

    resetForm() {
      // Reset form fields after successful submission
      this.form.name = "";
      this.form.email = "";
      this.form.city = "";
      this.form.phone = "";
      this.form.country = "";
      this.form.profession = "";
      this.form.postal_code = "";
      this.form.image = ''; // Reset image
    },
  },
};
</script>

<style>
.form-input {
  outline: none;
  border: 1px solid #ccc;
}
.form-input:focus {
  border-color: #007bff;
}
</style>
