<template>
  <div class="section">
    <div class="cv-template-selector container mt-3">
      <h3 class="text-center mb-2 text-black fw-bold pt-4">Job-winning templates for you.</h3>
      <p class="text-center mb-5">Choose one of our most liked templates. Change it anytime.</p>

      <!-- Centered Loader with Message -->
      <div v-if="loading" class="loader-overlay">
        <div class="loader-content">
          <h3 class="loader-message fw-bold">Loading...</h3>
          <div class="loader"></div>
          <div class="loader-details">
            <h5>40+ professional CV designs</h5>
            <h5>100,000+ pre-written phrases</h5>
            <h5>15,000+ job titles</h5>
            <h5>9+ template colour options</h5>
          </div>
        </div>
      </div>

      <!-- Actual Content -->
      <div v-else class="row g-4">
        <div
          v-for="(image, index) in paginatedImages"
          :key="image.id"
          class="col-md-4"
        >
          <div
            class="template card h-100 position-relative shadow-sm card-hover"
            :class="{ 'border-primary border-2': selectedTemplate == image.id }"
            @click="selectTemplate(image.id, userEmail)"
          >
            <!-- Template Image with Hover Effect -->
            <div
              class="image-container position-relative overflow-hidden"
              @mouseover="hoveredIndex = index"
              @mouseleave="hoveredIndex = null"
            >
              <img
                :src="image.image"
                :alt="`CV Template ${image.id}`"
                class="card-img-top img-fluid"
                style="height: 420px; object-fit: cover;"
              />
              <!-- Preview Icon (Top Right) -->
              <div
                class="preview-icon position-absolute top-0 end-0 m-2"
                :class="{ 'show-preview': hoveredIndex === index }"
                @click.stop="openModal(image.image)"
              >
                <i class="fas fa-search-plus text-white bg-primary p-2 rounded-circle" style="font-size: 20px; cursor: pointer;"></i>
              </div>
            </div>
            <!-- Template Title and Description -->
            <div class="text-center">
              <p class="text-muted">{{ image.description }}</p>
            </div>
          </div>
        </div>
      </div>

      <!-- Pagination Controls -->
      <div class="d-flex justify-content-center mt-4">
        <nav aria-label="Page navigation">
          <ul class="pagination">
            <li class="page-item" :class="{ disabled: currentPage === 1 }">
              <a class="page-link" href="#" @click.prevent="prevPage">Previous</a>
            </li>
            <li
              v-for="page in totalPages"
              :key="page"
              class="page-item"
              :class="{ active: currentPage === page }"
            >
              <a class="page-link" href="#" @click.prevent="goToPage(page)">{{ page }}</a>
            </li>
            <li class="page-item" :class="{ disabled: currentPage === totalPages }">
              <a class="page-link" href="#" @click.prevent="nextPage">Next</a>
            </li>
          </ul>
        </nav>
      </div>

      <!-- Bootstrap Modal -->
      <div
        class="modal fade"
        id="imageModal"
        tabindex="-1"
        aria-labelledby="imageModalLabel"
        aria-hidden="true"
      >
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header position-absolute top-0 end-0 border-0" style="z-index: 1056;">
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center p-0">
              <img :src="modalImageSrc" alt="Full-size Template" class="img-fluid rounded" />
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';
import { Modal } from 'bootstrap';

export default {
  data() {
    return {
      images: [], // Initialize images as an empty array
      selectedTemplate: null,
      modalImageSrc: '',
      hoveredIndex: null,
      modal: null,
      currentPage: 1,
      itemsPerPage: 6, // Number of items per page
      loading: true, // Add loading state
      userEmail: '', // Store user email
    };
  },
  computed: {
    totalPages() {
      return Math.ceil(this.images.length / this.itemsPerPage);
    },
    paginatedImages() {
      const start = (this.currentPage - 1) * this.itemsPerPage;
      const end = start + this.itemsPerPage;
      return this.images.slice(start, end);
    },
  },
  methods: {
    async getSelectedTemplateByEmail(email) {
      try {
        const res = await axios.get(`/api/selected-templates/email/${email}`);
        if (res.data && res.data.tamplate_id) {
          this.selectedTemplate = res.data.tamplate_id; // Set the selected template ID
        }
      } catch (error) {
        console.error('Error fetching selected template:', error);
      }
    },
    async getTemplate() {
      try {
        const res = await axios.get('/api/cv-templates'); // Fetch images from API
        this.images = res.data; // Populate the images array with API data
      } catch (error) {
        console.error('Error fetching templates:', error);
      } finally {
        this.loading = false; // Set loading to false after data is fetched
      }
    },
    async selectTemplate(templateId, userEmail) {
  try {
    this.loading = true; // Show loading state
    this.selectedTemplate = templateId;

    // Convert templateId to a string (if it's not already)
    const templateIdString = String(templateId);

    // Log the payload for debugging
    console.log('Sending payload:', { tamplate_id: templateIdString, user_email: userEmail });

    // Make the API call to save the selected template
    await axios.post('/api/selected-templates', { 
      tamplate_id: templateIdString, // Ensure templateId is sent as a string
      user_email: userEmail          // Use the exact key expected by the backend
    });

    // Navigate to the next page
    this.$router.push(`/premiumcv/create/${templateId}`).catch(err => {
      if (err.name !== "NavigationDuplicated") {
        console.error('Navigation error:', err);
      }
    });
  } catch (error) {
    console.error('Error selecting template:', error);
    // Optionally, show an error message to the user
  } finally {
    this.loading = false; // Hide loading state
  }
},
    openModal(imageSrc) {
      this.modalImageSrc = imageSrc;
      this.modal.show();
    },
    prevPage() {
      if (this.currentPage > 1) {
        this.currentPage--;
        this.scrollToTop();
      }
    },
    nextPage() {
      if (this.currentPage < this.totalPages) {
        this.currentPage++;
        this.scrollToTop();
      }
    },
    goToPage(page) {
      this.currentPage = page;
      this.scrollToTop();
    },
    scrollToTop() {
      window.scrollTo({
        top: 0,
        behavior: 'smooth',
      });
    },
  },
  async mounted() {
    this.modal = new Modal(document.getElementById('imageModal'));

    // Get user email from local storage
    const user = JSON.parse(localStorage.getItem('user'));
    if (user && user.email) {
      this.userEmail = user.email;
      await this.getSelectedTemplateByEmail(user.email); // Wait for selected template check
    }

    // Fetch templates after checking for selected template
    await this.getTemplate();
  },
};
</script>

<style lang="scss" scoped>
.section {
  background-color: blanchedalmond;
  margin-top: -16px;
}

.cv-template-selector {
  .template {
    cursor: pointer;
    border-radius: 10px;
    transition: box-shadow 0.3s ease, border-color 0.3s ease;

    &:hover {
      box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
    }
  }

  .border-primary {
    border-color: #007bff !important; /* Blue border for selected template */
  }

  .image-container {
    position: relative;
    display: inline-block;
    cursor: pointer;
    border-radius: 10px 10px 0 0;

    img {
      display: block;
      width: 100%;
      height: auto;
      transition: filter 0.3s ease;
    }

    .preview-icon {
      z-index: 1;
      opacity: 0;
      transform: translateY(-10px);
      transition: opacity 0.3s ease, transform 0.3s ease;
    }

    .show-preview {
      opacity: 1;
      transform: translateY(0);
    }
  }

  .card-title {
    font-size: 1.25rem;
    margin-bottom: 0.1rem;
  }

  .card-text {
    font-size: 0.9rem;
  }
}

.card-hover:hover {
  border: 2px solid blue;
  transition: border 0.5s ease;
}

/* Loader Styles */
.loader-overlay {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(255, 255, 255, 0.9); /* Semi-transparent white background */
  display: flex;
  justify-content: center;
  align-items: center;
  z-index: 1050; /* Ensure it's above other content */
  opacity: 1;
  transition: opacity 0.5s ease;
}

.loader-content {
  text-align: center;
}

.loader-message {
  font-size: 1.5rem;
  font-weight: bold;
  margin-bottom: 1rem;
}

.loader {
  border: 4px solid #f3f3f3; /* Light grey */
  border-top: 4px solid #007bff; /* Blue */
  border-radius: 50%;
  width: 50px;
  height: 50px;
  animation: spin 1s linear infinite;
  margin: 0 auto 1rem;
}

.loader-details {
  font-size: 1rem;
  color: #555;
}

.loader-details p {
  margin: 0.5rem 0;
}

@keyframes spin {
  0% {
    transform: rotate(0deg);
  }
  100% {
    transform: rotate(360deg);
  }
}

/* Modal Fixes */
.modal {
  z-index: 1055; /* Ensure modal is above everything */
}

.modal-backdrop {
  z-index: 1050; /* Ensure backdrop is below modal but above everything else */
}
</style>