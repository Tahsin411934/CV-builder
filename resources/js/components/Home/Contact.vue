<template>
  <div class="container my-5 p-4 d-flex flex-column">
    <h2 class="text-center mb-4 fw-bold" style="color: #050748;">Contact Us</h2>
    <form @submit.prevent="handleSubmit" class="d-flex flex-column justify-content-between">
      <!-- Name and Email in the same row -->
      <div class="row mb-4">
        <div class="col-md-6">
          <div class="form-group">
            <label for="name" class="form-label">Name</label>
            <input
              type="text"
              id="name"
              v-model="form.name"
              required
              class="form-control form-control-lg border-0 border-bottom border-secondary"
              placeholder="Your Name"
            />
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label for="email" class="form-label">Email</label>
            <input
              type="email"
              id="email"
              v-model="form.email"
              required
              class="form-control form-control-lg border-0 border-bottom border-secondary"
              placeholder="Your Email"
            />
          </div>
        </div>
      </div>

      <!-- Message -->
      <div class="form-group mb-4 flex-grow-1">
        <label for="message" class="form-label">Message</label>
        <textarea
          id="message"
          v-model="form.message"
          required
          class="form-control form-control-lg border-0 border-bottom border-secondary"
          placeholder="Your Message"
        ></textarea>
      </div>

      <!-- Submit Button -->
      <div class="d-flex justify-content-end" >
        <button
          type="submit"
          class="btn btn-primary btn-lg" style="background-color: #050748;"
        >
          Submit
        </button>
      </div>
    </form>
  </div>
</template>

<script>
export default {
  data() {
    return {
      form: {
        name: '',
        email: '',
        message: '',
      },
    };
  },
  methods: {
    handleSubmit() {
      const { name, email, message } = this.form;

      const mailtoLink = `mailto:abrarfahimtasin@gmail.com?subject=Contract Form Submission&body=Name: ${name}%0AEmail: ${email}%0AMessage: ${message}`;

      // Redirect to the email client with prefilled information
      window.location.href = mailtoLink;

      // Clear the form after submission
      this.form.name = '';
      this.form.email = '';
      this.form.message = '';
    },
  },
};
</script>

<style scoped>
/* Custom styles for input focus transition */
input, textarea {
  transition: border-bottom 0.3s ease;
}

input:focus, textarea:focus {
  border-bottom: 2px solid #007bff !important;
  outline: none;
}

.container {
  position: relative;
}

form {
  display: flex;
  flex-direction: column;
  justify-content: space-between;
  height: 100%;
}

form > .d-flex {
  margin-top: auto;
}
</style>
