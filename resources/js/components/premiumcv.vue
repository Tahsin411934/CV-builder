<template>
  <div class="section">
    <div class="cv-template-selector container mt-3">
      <h3 class="text-center mb-2 text-black fw-bold pt-4">Job-winning templates for you.</h3>
      <p class="text-center mb-5">Choose one of our most liked templates. Change it anytime.</p>
      <div class="row g-4">
        <div
          v-for="(image, index) in paginatedImages"
          :key="index"
          class="col-md-4"
        >
          <div
            class="template card h-100 position-relative shadow-sm card-hover"
            :class="{ 'border-primary border-2': selectedTemplate === image.src }"
          >
            <!-- Template Image with Hover Effect -->
            <div class="image-container position-relative overflow-hidden" @mouseover="showPreview(index)" @mouseleave="hidePreview">
              <img
                :src="image.src"
                :alt="`CV Template ${index + 1}`"
                class="card-img-top img-fluid"
                style="height: 420px; object-fit: cover;"
              />
              <!-- Preview Overlay (Only on Image) -->
              <div
                :class="{ 'show-overlay': hoveredIndex === index }"
                class="preview-overlay position-absolute top-0 start-0 w-100 h-100 d-flex flex-column align-items-center justify-content-center"
                style="background: rgba(0, 0, 0, 0.6);"
              >
                <i class="fas fa-search-plus text-white mb-3" style="font-size: 32px;" @click.stop="openModal(image.src)"></i>
                <button class="btn btn-outline-light btn-lg" @click.stop="openModal(image.src)">
                  Preview
                </button>
              </div>
            </div>
            <!-- Template Title and Description -->
            <div class="text-center">
              <p class="text-muted">{{ image.description }}</p>
            </div>
            <!-- Radio Button for Selection -->
            <div class="text-center pb-3">
              <button
                class="btn btn-primary"
                @click="selectTemplate(image.src)"
              >
                Choose Template
              </button>
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

      <!-- Selected Template Confirmation -->
      <div v-if="selectedTemplate" class="text-center m-5 pb-5">
        <p class="text-primary fw-bold fs-5">"You have selected: {{ selectedImage.description }}"</p>
        <button class="btn btn-success btn-lg px-5 float-end " @click="confirmSelection">
          Next
        </button>
      </div>

      <!-- Bootstrap Modal -->
      <div
        class="modal fade"
        id="imageModal"
        tabindex="-1"
        aria-labelledby="imageModalLabel"
        aria-hidden="true"
      >
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-body text-center">
              <img :src="modalImageSrc" alt="Full-size Template" class="img-fluid rounded" />
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { Modal } from 'bootstrap';

export default {
  data() {
    return {
      images: [
        { src: '/resume/1.jpg', title: 'Template 1', description: 'Professional layout for corporate jobs.' },
        { src: '/resume/2.jpg', title: 'Template 2', description: 'Modern design with a creative touch.' },
        { src: '/resume/3.jpg', title: 'Template 3', description: 'Elegant and clean format.' },
        { src: '/resume/4.jpg', title: 'Template 4', description: 'Perfect for freelancers and designers.' },
        { src: '/resume/5.jpg', title: 'Template 5', description: 'Minimalist style with a focus on content.' },
        { src: '/resume/6.jpg', title: 'Template 6', description: 'Bold and stylish layout for standout resumes.' },
        { src: '/resume/7.jpg', title: 'Template 5', description: 'Minimalist style with a focus on content.' },
        { src: '/resume/6.jpg', title: 'Template 6', description: 'Bold and stylish layout for standout resumes.' },
      ],
      selectedTemplate: null,
      modalImageSrc: '',
      hoveredIndex: null,
      modal: null,
      currentPage: 1,
      itemsPerPage: 6, // Number of items per page
    };
  },
  computed: {
    selectedImage() {
      return this.images.find(image => image.src === this.selectedTemplate);
    },
    totalPages() {
      return Math.ceil(this.images.length / this.itemsPerPage);
    },
    paginatedImages() {
      const start = (this.currentPage - 1) * this.itemsPerPage;
      const end = start + this.itemsPerPage;
      return this.images.slice(start, end);
    }
  },
  methods: {
  showPreview(index) {
    this.hoveredIndex = index;
  },
  hidePreview() {
    this.hoveredIndex = null;
  },
  selectTemplate(imageSrc) {
    this.selectedTemplate = imageSrc;
  },
  openModal(imageSrc) {
    this.modalImageSrc = imageSrc;
    this.modal.show();
  },
  confirmSelection() {
    alert(`You have confirmed the selection: ${this.selectedImage.description}`);
  },
  prevPage() {
    if (this.currentPage > 1) {
      this.currentPage--;
      this.scrollToTop(); // Scroll to top
    }
  },
  nextPage() {
    if (this.currentPage < this.totalPages) {
      this.currentPage++;
      this.scrollToTop(); // Scroll to top
    }
  },
  goToPage(page) {
    this.currentPage = page;
    this.scrollToTop(); // Scroll to top
  },
  scrollToTop() {
    window.scrollTo({
      top: 0,
      behavior: 'smooth', // Optional: Adds smooth scrolling
    });
  },
},
  mounted() {
    this.modal = new Modal(document.getElementById('imageModal'));
  }
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

    &:hover {
      box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
    }
  }

  .border-primary {
    border-color: #007bff !important;
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

    .preview-overlay {
      transition: opacity 0.3s;
      opacity: 0;
    }

    .show-overlay {
      opacity: 1;
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
  border: 3px solid blue;
}
</style>