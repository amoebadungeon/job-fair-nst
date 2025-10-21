<template>
  <section class="hero-banner">
    <div class="container">
  <div class="container">
      <img src="@/assets/images/hero_banner.jpg" alt="A collage showing logos of past exhibitors and photos from the event.">
    </div>
    </div>
  </section>
</template>

<script>
export default {
  name: 'HeroBanner'
}
</script>

<style scoped>
.hero-banner {
  background-color: #ffffff;
}

.container {
  max-width: 1200px; /* Adjust this width to match your design */
  text-align: center; /* This centers the image within the container */
}

.container img {
  height: auto;   /* Maintains the image's aspect ratio */
  width: 100%;
}

.banner-content {
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 40px;
}

.banner-text {
  flex: 1;
}

.banner-text h1 {
  font-size: 4rem;
  font-weight: 900;
  color: #0056b3;
  margin-bottom: 20px;
  line-height: 1.1;
  text-transform: uppercase;
}

.banner-text h2 {
  font-size: 1.8rem;
  font-weight: 700;
  margin-bottom: 20px;
}

.banner-text p {
  font-size: 1rem;
  line-height: 1.6;
  color: #555;
}

.banner-image {
  flex: 1;
  text-align: center;
}

.banner-image img {
  max-width: 100%;
  height: auto;
}
</style>