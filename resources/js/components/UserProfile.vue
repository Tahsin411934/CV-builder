<template>
    <div class="container py-5">
      <div class="row justify-content-center align-items-stretch">
        <!-- User Profile Card -->
        <div class="col-md-6 mb-4">
          <div class="card shadow-lg d-flex flex-column" style="height: 420px;">
            <div class="card-header bg-color text-white text-center">
              <h1 class="h4 mb-0">User Profile</h1>
            </div>
            <div class="card-body">
              <div v-if="loading" class="text-center">
                <div class="spinner-border text-primary" role="status">
                  <span class="visually-hidden">Loading...</span>
                </div>
              </div>
              <div v-else-if="error" class="alert alert-danger text-center">
                {{ error }}
              </div>
              <div v-else>
                <!-- User Info -->
                <div class="mb-3 text-center">
                  <img
                    src="https://via.placeholder.com/100"
                    alt="User Avatar"
                    class="rounded-circle shadow-sm"
                    style="width: 100px; height: 100px;"
                  />
                </div>
                <div class="mb-3">
                  <label class="fw-bold">Name:</label>
                  <div class="d-flex align-items-center">
                    <input
                      type="text"
                      v-model="editableUser.name"
                      :readonly="!isEditable.name"
                      class="form-control form-control-sm me-2"
                    />
                    <button class="btn btn-sm btn-outline-light" @click="toggleEdit('name')">
                      <i :class="isEditable.name ? 'fas fa-check' : 'fas fa-pencil-alt'"></i>
                    </button>
                  </div>
                </div>
                <div class="mb-3">
                  <label class="fw-bold">Email:</label>
                  <div class="d-flex align-items-center">
                    <input
                      type="email"
                      v-model="editableUser.email"
                      :readonly="!isEditable.email"
                      class="form-control form-control-sm me-2"
                    />
                    <button class="btn btn-sm btn-outline-light" @click="toggleEdit('email')">
                      <i :class="isEditable.email ? 'fas fa-check' : 'fas fa-pencil-alt'"></i>
                    </button>
                  </div>
                </div>
                <div class="mb-3">
                  <span class="fw-bold">Joined on:</span> {{ formatDate(user.created_at) }}
                </div>
                <div v-if="user.email_verified_at" class="mb-3">
                  <span class="fw-bold">Email Verified:</span> Yes
                </div>
                <div v-else class="mb-3">
                  <span class="fw-bold">Email Verified:</span> No
                </div>
                <div class="text-center mt-3">
                  <button class="btn btn-dark btn-sm" @click="updateUserInfo">Save Changes</button>
                </div>
              </div>
            </div>
            <div class="card-footer text-center">
              <button class="btn btn-dark btn-sm" @click="refreshPage">Refresh Profile</button>
            </div>
          </div>
        </div>
  
        <!-- Change Password Card -->
        <div class="col-md-6 mb-4">
          <div class="card shadow-lg d-flex flex-column" style="height: 420px;">
            <div class="card-header bg-color text-white text-center">
              <h5 class="mb-0">Change Password</h5>
            </div>
            <div class="card-body">
              <form @submit.prevent="changePassword">
                <div class="mb-3">
                  <label for="currentPassword" class="form-label">Current Password</label>
                  <input
                    type="password"
                    id="currentPassword"
                    v-model="passwordForm.current_password"
                    class="form-control form-control-sm"
                    required
                  />
                </div>
                <div class="mb-3">
                  <label for="newPassword" class="form-label">New Password</label>
                  <input
                    type="password"
                    id="newPassword"
                    v-model="passwordForm.new_password"
                    class="form-control form-control-sm"
                    required
                  />
                </div>
                <div class="mb-3">
                  <label for="confirmPassword" class="form-label">Confirm Password</label>
                  <input
                    type="password"
                    id="confirmPassword"
                    v-model="passwordForm.confirm_password"
                    class="form-control form-control-sm"
                    required
                  />
                </div>
                <div class="text-center">
                  <button type="submit" class="btn btn-dark btn-sm">Change Password</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </template>
  
  <script>
  import axios from "axios";
  
  export default {
    name: "UserProfile",
    data() {
      return {
        user: {},
        editableUser: {},
        isEditable: { name: false, email: false },
        loading: true,
        error: null,
        passwordForm: {
          current_password: "",
          new_password: "",
          confirm_password: "",
        },
      };
    },
    methods: {
      async fetchUserData() {
        try {
          const user = JSON.parse(localStorage.getItem("user"));
          if (!user || !user.email) {
            throw new Error("User data not found in localStorage.");
          }
          const response = await axios.get(
            `http://127.0.0.1:8000/api/user/${user.email}`
          );
          this.user = response.data.data;
          this.editableUser = { ...this.user }; // Initialize editable fields
        } catch (error) {
          this.error =
            error.response?.data?.message || error.message || "An error occurred.";
        } finally {
          this.loading = false;
        }
      },
      formatDate(date) {
        const options = { year: "numeric", month: "long", day: "numeric" };
        return new Date(date).toLocaleDateString(undefined, options);
      },
      refreshPage() {
        this.loading = true;
        this.error = null;
        this.fetchUserData();
      },
      toggleEdit(field) {
        this.isEditable[field] = !this.isEditable[field];
      },
      async updateUserInfo() {
        try {
          const response = await axios.post(
            `http://127.0.0.1:8000/api/user/update`,
            this.editableUser
          );
          this.user = response.data.data;
          this.editableUser = { ...this.user }; // Sync changes
          alert("User information updated successfully!");
        } catch (error) {
          alert(
            error.response?.data?.message || error.message || "Failed to update user information."
          );
        }
      },
      async changePassword() {
        // Validate new passwords
        if (this.passwordForm.new_password !== this.passwordForm.confirm_password) {
          alert("New passwords do not match.");
          return;
        }
  
        // Ensure the password fields are not empty
        if (
          !this.passwordForm.current_password ||
          !this.passwordForm.new_password ||
          !this.passwordForm.confirm_password
        ) {
          alert("All password fields are required.");
          return;
        }
  
        try {
          const payload = {
            email: this.user.email, // Pass the user's email
            current_password: this.passwordForm.current_password,
            new_password: this.passwordForm.new_password,
            new_password_confirmation: this.passwordForm.confirm_password,
          };
          console.log(payload);
          const response = await axios.post(
            `http://127.0.0.1:8000/api/user/change-password`,
            payload
          );
  
          alert(response.data.message);
          // Clear password fields after success
          this.passwordForm = {
            current_password: "",
            new_password: "",
            confirm_password: "",
          };
        } catch (error) {
          alert(
            error.response?.data?.message || error.message || "Failed to change password."
          );
        }
      },
    },
    created() {
      this.fetchUserData();
    },
  };
  </script>
  
  <style scoped>
  body {
    font-family: Arial, sans-serif;
    background-color: #f8f9fa;
  }
  
  .card {
    border-radius: 10px;
    display: flex;
    flex-direction: column;
  }
  
  .card-body {
    flex: 1; /* Make the body fill the available space */
  }
  
  @media (max-width: 768px) {
    .col-md-6 {
      max-width: 100%;
    }
  }
  .bg-color{
    background-color: #050748;
  }
  </style>
  