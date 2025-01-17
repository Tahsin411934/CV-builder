<template>
  <div class="container text-center">
    <h4 class="pt-5 text-danger">services</h4>
    <h2 class="my-4 fw-bold custom-text pb-5">Our Design & Development Services</h2>
    <div class="row justify-content-center">
      <div class="col-md-4 mb-4">
        <div class="card">
          <img src="/images/servc-1.jpg" alt="Free CV" class="card-img-top" />
          <div class="card-body">
            <h5 class="card-title mt-2">Free CV</h5>
          </div>
        </div>
      </div>
      <div class="col-md-4 mb-4">
        <div class="card">
          <img src="/images/servc-2.jpg" alt="Premium CV" class="card-img-top" />
          <div class="card-body">
            <h5 class="card-title mt-2">Premium CV</h5>
          </div>
        </div>
      </div>
      <div class="col-md-4 mb-4">
        <div class="card">
          <img src="/images/servc-3.jpg" alt="Professional Resume" class="card-img-top" />
          <div class="card-body">
            <h5 class="card-title mt-2">Professional Resume</h5>
          </div>
        </div>
      </div>
    </div>
    <div class="my-5 container mx-auto px-4">
    <div class="d-flex justify-content-center align-items-center">
      <div class="d-lg-flex gap-5 text-center">
        <div class="fs-2 fw-semibold">Learn how to prepare a KILLER CV</div>
        <div>
          <button class="btn bg-custom text-white btn-lg">Click Here</button>
        </div>
      </div>
    </div>
  </div>
  </div>

  
</template>

<script>
export default {};
</script>

<style scoped>
/* Add transition for smooth effect */
.card-img-top {
  transition: transform 0.8s ease; /* Slower transition duration */
}

/* Decrease size on hover */
.card-img-top:hover {
  transform: scale(0.85); /* Shrink image to 85% of the original size */
}

/* Optional styling for cards */
.card {
  cursor: pointer;
}

.bg-custom {
  background: #050748;
}
</style>
