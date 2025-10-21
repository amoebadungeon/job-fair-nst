<template>
  <section class="job-tour-section">
    <div class="container">
      <img src="@/assets/images/find_talent.jpg" alt="A collage showing logos of past exhibitors and photos from the event.">
    </div>
  </section>
</template>

<script>
export default {
  name: 'JobTour'
}
</script>

<style scoped>
.job-tour-section {
  background-color: #ffffff; /* Sets a background color */
}

.container {
  max-width: 1200px; /* Adjust this width to match your design */
  text-align: center; /* This centers the image within the container */
}

.container img {
  height: auto;   /* Maintains the image's aspect ratio */
  width: 100%;
}
</style>