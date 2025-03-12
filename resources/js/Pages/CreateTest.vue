<template>
    <div>
      <h1>Test List</h1>
      <!-- Button to open modal to add new test -->
      <button class="btn btn-primary" @click="openCreateModal">Add New Test</button>
  
      <table class="table mt-3">
        <thead>
          <tr>
            <th>#</th>
            <th>Image</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="test in tests" :key="test.id">
            <td>{{ test.id }}</td>
            <td><img :src="'/storage/' + test.image" alt="Test Image" width="100"></td>
            <td>
              <button class="btn btn-warning" @click="openEditModal(test)">Edit</button>
              <button class="btn btn-danger" @click="deleteTest(test.id)">Delete</button>
            </td>
          </tr>
        </tbody>
      </table>
  
      <!-- Custom Modal for Adding a New Test -->
      <div v-if="isModalVisible" class="modal-overlay" @click="closeModal">
        <div class="modal-content" @click.stop>
          <div class="modal-header">
            <h5 class="modal-title">{{ modalTitle }}</h5>
            <button type="button" class="btn-close" @click="closeModal"></button>
          </div>
          <div class="modal-body">
            <form @submit.prevent="submitForm">
              <div class="mb-3">
                <label for="image" class="form-label">Test Image</label>
                <input type="file" class="form-control" id="image" @change="handleFileChange" required />
              </div>
              <button type="submit" class="btn btn-primary">{{ modalAction }}</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </template>
  
  <script>
  export default {
    data() {
      return {
        tests: [],
        form: {
          image: null,
          id: null,
        },
        modalTitle: 'Add New Test',
        modalAction: 'Save',
        isModalVisible: false, // Controls modal visibility
      };
    },
    methods: {
      fetchTests() {
        axios.get('/api/tests1')
          .then(response => {
            this.tests = response.data;
          });
      },
      deleteTest(id) {
        axios.delete(`/api/tests1/${id}`)
          .then(response => {
            this.fetchTests();
          });
      },
      // Open modal to add a new test
      openCreateModal() {
        this.form = { image: null, id: null };
        this.modalTitle = 'Add New Test';
        this.modalAction = 'Save';
        this.isModalVisible = true;
      },
      // Open modal to edit a test
      openEditModal(test) {
        this.form = { image: null, id: test.id };
        this.modalTitle = 'Edit Test';
        this.modalAction = 'Update';
        this.isModalVisible = true;
      },
      // Submit form to create or update test
      submitForm() {
        const formData = new FormData();
        formData.append('image', this.form.image);
  
        if (this.form.id) {
          // Update existing test
          axios.put(`/api/tests1/${this.form.id}`, formData)
            .then(response => {
              this.fetchTests();
              this.closeModal();
            });
        } else {
          // Create new test
          axios.post('/api/tests1', formData)
            .then(response => {
              this.fetchTests();
              this.closeModal();
            });
        }
      },
      handleFileChange(event) {
        this.form.image = event.target.files[0];
      },
      closeModal() {
        this.isModalVisible = false;
      }
    },
    mounted() {
      this.fetchTests();
    }
  };
  </script>
  
  <style scoped>
  .table th, .table td {
    text-align: center;
  }
  
  /* Modal styles */
  .modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    display: flex;
    justify-content: center;
    align-items: center;
  }
  
  .modal-content {
    background-color: white;
    padding: 20px;
    border-radius: 8px;
    width: 400px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
  }
  
  .modal-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
  }
  
  .btn-close {
    background: none;
    border: none;
    font-size: 1.5rem;
    cursor: pointer;
  }
  </style>
  