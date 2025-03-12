<template>
    <div class="container mx-auto p-4 min-vh-100">
      <h1 class="text-2xl font-semibold mb-4">CV Template Management</h1>
  
      <!-- Button to open the modal -->
      <button type="button" class="btn btn-primary" @click="openModal">
        ADD NEW
      </button>
  
      <!-- Table to display CV templates -->
      <table class="table table-bordered table-striped">
        <thead>
          <tr>
            <th class="text-left">Image</th>
            <th class="text-left">Title</th>
            <th class="text-left">Description</th>
            <th class="text-left">Change Image</th>
            <th class="text-left">Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr v-if="loading">
            <td colspan="5" class="text-center">Loading...</td>
          </tr>
          <tr v-if="error">
            <td colspan="5" class="text-center text-danger">{{ error }}</td>
          </tr>
          <tr v-for="(template, index) in cvTemplates" :key="template.id">
            <td>
              <img
                :src="template.image"
                alt="Template Image"
                class="w-20 h-20 object-cover"
                v-if="template.image"
                width="100" height="100"
              />
              <span v-else>No Image</span>
            </td>
            <td>
              <input
                type="text"
                class="form-control"
                v-model="template.title"
                :disabled="!template.isEditing"
              />
            </td>
            <td>
              <input
                type="text"
                class="form-control"
                v-model="template.description"
                :disabled="!template.isEditing"
              />
            </td>
            <!-- <td>
              <input
                type="file"
                class="form-control"
                @change="handleImageChange($event, index)"
                :disabled="!template.isEditing"
              />
            </td> -->
            <td>
              <div v-if="!template.isEditing">
                <button
                  @click="startEditing(index)"
                  class="btn btn-primary btn-sm"
                >
                  Edit
                </button>
                <button
                  @click="handleDelete(template.id)"
                  class="btn btn-danger btn-sm"
                >
                  Delete
                </button>
              </div>
              <div v-else>
                <button
                  @click="saveEditing(index)"
                  class="btn btn-success btn-sm"
                >
                  Save
                </button>
                <button
                  @click="cancelEditing(index)"
                  class="btn btn-secondary btn-sm"
                >
                  Cancel
                </button>
              </div>
            </td>
          </tr>
        </tbody>
      </table>
  
      <!-- Modal for adding a new CV template -->
      <div
        class="modal fade"
        id="exampleModal"
        tabindex="-1"
        aria-labelledby="exampleModalLabel"
        aria-hidden="true"
      >
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h1 class="modal-title fs-5" id="exampleModalLabel">
                Add New CV Template
              </h1>
              <button
                type="button"
                class="btn-close"
                data-bs-dismiss="modal"
                aria-label="Close"
              ></button>
            </div>
            <div class="modal-body">
              <!-- Form for adding a new CV template -->
              <form @submit.prevent="handleSubmit">
                <div class="mb-3">
                  <label for="image" class="form-label">Upload Image</label>
                  <input
                    type="file"
                    class="form-control"
                    id="image"
                    @change="handleNewImage"
                    required
                  />
                </div>
                <div class="mb-3">
                  <label for="title" class="form-label">Title</label>
                  <input
                    type="text"
                    class="form-control"
                    id="title"
                    v-model="newTemplate.title"
                    required
                  />
                </div>
                <div class="mb-3">
                  <label for="description" class="form-label">Description</label>
                  <textarea
                    class="form-control"
                    id="description"
                    v-model="newTemplate.description"
                    rows="3"
                    required
                  ></textarea>
                </div>
                <div class="modal-footer">
                  <button
                    type="button"
                    class="btn btn-secondary"
                    data-bs-dismiss="modal"
                  >
                    Close
                  </button>
                  <button type="submit" class="btn btn-primary">
                    Save changes
                  </button>
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
  import { Modal } from "bootstrap"; // Import Bootstrap's Modal class
  
  export default {
    data() {
      return {
        cvTemplates: [],
        loading: true,
        error: null,
        newTemplate: {
          image: null, // Store the uploaded image file
          title: "",
          description: "",
        },
        modalInstance: null, // Store Bootstrap modal instance
      };
    },
    created() {
      this.fetchCvTemplates();
    },
    methods: {
      fetchCvTemplates() {
        axios
          .get("/api/cv-templates")
          .then((response) => {
            this.cvTemplates = response.data.map((template) => ({
              ...template,
              isEditing: false,
            }));
            this.loading = false;
          })
          .catch((err) => {
            this.error = "Failed to fetch CV templates.";
            this.loading = false;
          });
      },
      handleDelete(id) {
        if (window.confirm("Are you sure you want to delete this template?")) {
          axios
            .delete(`/api/cv-templates/${id}`)
            .then(() => {
              this.cvTemplates = this.cvTemplates.filter(
                (template) => template.id !== id
              );
            })
            .catch((err) => {
              alert("Error deleting template");
            });
        }
      },
      startEditing(index) {
        this.cvTemplates[index].isEditing = true;
      },
      saveEditing(index) {
    const template = this.cvTemplates[index];

    // Create a FormData object
    const formData = new FormData();

    // Append only the fields that can be updated
    if (template.title) formData.append('title', template.title);
    if (template.description) formData.append('description', template.description);

    // Append the image file if a new one is selected
    if (template.imageFile) {
        formData.append('image', template.imageFile);
    }

    // Send the request
    axios
        .put(`/api/cv-templates/${template.id}`, formData, {
            headers: {
                'Content-Type': 'multipart/form-data', // Required for file uploads
            },
        })
        .then(() => {
            template.isEditing = false;
            alert('Template updated successfully!');
        })
        .catch((err) => {
            console.error(err);
            alert('Error updating template');
        });
},
   
      cancelEditing(index) {
        this.cvTemplates[index].isEditing = false;
        this.fetchCvTemplates(); // Re-fetch to reset any changes
      },
      handleNewImage(event) {
        this.newTemplate.image = event.target.files[0];
      },
      handleImageChange(event, index) {
        this.cvTemplates[index].image = event.target.files[0];
      },
      handleSubmit() {
        const formData = new FormData();
        formData.append("image", this.newTemplate.image);
        formData.append("title", this.newTemplate.title);
        formData.append("description", this.newTemplate.description);
  
        axios
          .post("/api/cv-templates", formData, {
            headers: {
              "Content-Type": "multipart/form-data",
            },
          })
          .then((response) => {
            this.cvTemplates.push({ ...response.data, isEditing: false });
            this.newTemplate = { image: null, title: "", description: "" };
            this.closeModal();
          })
          .catch((err) => {
            alert("Error adding template");
          });
      },
      openModal() {
        const modalElement = document.getElementById("exampleModal");
        if (!this.modalInstance) {
          this.modalInstance = new Modal(modalElement);
        }
        this.modalInstance.show();
      },
      closeModal() {
        if (this.modalInstance) {
          this.modalInstance.hide();
          document.querySelectorAll(".modal-backdrop").forEach((backdrop) => backdrop.remove());
          document.body.classList.remove("modal-open");
          document.body.style.overflow = "";
          document.body.style.paddingRight = "";
          this.modalInstance = null;
        }
      },
    },
  };
  </script>
  
  <style scoped>
  .table {
    width: 100%;
    margin-bottom: 1rem;
    color: #212529;
  }
  
  .table th,
  .table td {
    padding: 0.75rem;
    vertical-align: top;
    border-top: 1px solid #dee2e6;
  }
  
  .table thead th {
    vertical-align: bottom;
    border-bottom: 2px solid #dee2e6;
  }
  
  .table tbody + tbody {
    border-top: 2px solid #dee2e6;
  }
  
  .table-bordered {
    border: 1px solid #dee2e6;
  }
  
  .table-bordered th,
  .table-bordered td {
    border: 1px solid #dee2e6;
  }
  
  .table-striped tbody tr:nth-of-type(odd) {
    background-color: rgba(0, 0, 0, 0.05);
  }
  </style>