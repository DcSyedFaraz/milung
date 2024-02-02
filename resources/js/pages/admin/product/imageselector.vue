<template>
    <div class="container-fluid d-flex flex-column min-vh-100 justify-content-center align-items-start">
        <div class="row">
          <div class="col-12">
            <!-- Your content here -->
          </div>
        </div>
        <div class="row">
          <div class="col-12">
            <input ref="fileInput" type="file" @change="handleFileChange" multiple accept=".jpg,.png" style="display: none;">

            <div v-if="showCarousel" class="carousel-container">
              <!-- Bootstrap Carousel -->
              <div id="imageCarousel" class="carousel carousel-dark slide" data-bs-ride="carousel">
                <ol class="carousel-indicators">
                  <li v-for="(image, index) in selectedImages" :key="index" :data-bs-target="'#imageCarousel'"
                    :data-bs-slide-to="index" :class="{ 'active': index === 0 }"></li>
                </ol>
                <div class="carousel-inner">
                  <div v-for="(image, index) in selectedImages" :key="index"
                    :class="{ 'carousel-item': true, 'active': index === 0 }">
                    <img :src="image" class="d-block w-100" style="height: 300px; object-fit: cover;" alt="Image">
                  </div>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#imageCarousel" data-bs-slide="prev">
                  <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                  <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#imageCarousel" data-bs-slide="next">
                  <span class="carousel-control-next-icon" aria-hidden="true"></span>
                  <span class="visually-hidden">Next</span>
                </button>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-12">
            <button class="btn btn-primary mt-3" type="button" style="background-color: #009de1; border-color: #009de1;" @click="triggerFileInput">Browse Images</button>
          </div>
        </div>
      </div>
</template>

<script>
export default {
    data() {
        return {
            selectedImages: [],
            showCarousel: false,
        };
    },
    methods: {
        handleFileChange(event) {
        // Handle file selection and update selectedImages array
        const files = event.target.files;
        this.selectedImages = [];
        for (let i = 0; i < files.length; i++) {
            const imageURL = URL.createObjectURL(files[i]);
            this.selectedImages.push(imageURL);
        }

        // Update parent component with selected images
        this.$emit("imagesSelected", this.selectedImages); // <-- Corrected this line
        this.showCarousel = true;
    },
        triggerFileInput() {
            this.$refs.fileInput.click();
        },
    },
};
</script>

<style scoped>
.carousel-container {
    width: 100%;
    max-width: 600px;
    /* Adjust the maximum width as needed */
    margin: auto;
}</style>
