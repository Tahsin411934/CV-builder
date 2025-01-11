<template>
  <div class="container-sm mx-auto w-50 shadow-lg p-5 mt-5">
    <h2 class="text-center mb-4">Login</h2>

    <!-- Login Form -->
    <form @submit.prevent="submitForm">
      <!-- Email -->
      <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input
          type="email"
          id="email"
          class="form-control"
          v-model="form.email"
          :class="{'is-invalid': errors.email}"
          required
        />
        <div v-if="errors.email" class="invalid-feedback">{{ errors.email }}</div>
      </div>

      <!-- Password -->
      <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input
          type="password"
          id="password"
          class="form-control"
          v-model="form.password"
          :class="{'is-invalid': errors.password}"
          required
        />
        <div v-if="errors.password" class="invalid-feedback">{{ errors.password }}</div>
      </div>

      <button type="submit" class="btn btn-primary w-100">Login</button>
    </form>
  </div>
</template>

<script>
import axios from 'axios';
import Toastify from 'toastify-js';
import 'toastify-js/src/toastify.css'; // Import the CSS for Toastify

export default {
  data() {
    return {
      form: {
        email: '',
        password: ''
      },
      errors: {},
    };
  },
  methods: {
    async submitForm() {
      // Reset errors before sending the form
      this.errors = {};

      try {
        // Send login request to the Laravel API
        const response = await axios.post('/api/login', this.form);

        // Save token and user data in localStorage or Vuex store
        localStorage.setItem('token', response.data.token);
        localStorage.setItem('user', JSON.stringify(response.data.user));

        // Show Toastify success message
        Toastify({
          text: "Login successful!",
          duration: 3000,  // Show for 3 seconds
          gravity: "top",  // Position top or bottom
          position: "right", // Position left or right
          backgroundColor: "green",
        }).showToast();

        // Redirect after successful login
        this.$router.push('/resume');
      } catch (error) {
        // Handle error response
        if (error.response && error.response.status === 422) {
          this.errors = error.response.data.errors;
        } else {
          alert('Something went wrong! Please try again.');
        }

        // Show Toastify error message
        Toastify({
          text: "Login failed! Please check your credentials.",
          duration: 3000,  // Show for 3 seconds
          gravity: "top",  // Position top or bottom
          position: "right", // Position left or right
          backgroundColor: "red",
        }).showToast();
      }
    }
  }
};
</script>

<style scoped>
/* Bootstrap handles the layout, no additional custom styles needed */
</style>
