<template>
  <section class="exhibitors-section">
    <h1 style="font-weight: bolder;">EXHIBITION LAYOUT</h1>
    <div class="container">
      <!-- Each image now opens the modal with its own source -->
      <img :src="layoutImage1" alt="Layout 1" @click="openModal(layoutImage1)">
      <img :src="layoutImage2" alt="Layout 2" @click="openModal(layoutImage2)">
      <img :src="layoutImage3" alt="Layout 3" @click="openModal(layoutImage3)">
    </div>

 <div class="container">
      <img style="transform: none; box-shadow: none; transition: none;" src="@/assets/images/click_2_view.jpg" alt="layout1.">
    </div>
     
    <div class="container">
      <!-- Each image now opens the modal with its own source -->
      <img style="width: 100%;" :src="floorPlan" alt="Layout 1" @click="openModal(floorPlan)">
    </div>
    <!-- Conditionally render the modal component -->
    <ImageModal
      v-if="isModalVisible"
      :image-url="selectedImage"
      @close="closeModal"
    />
  </section>
 
</template>

<script>
// 1. Import the modal component
import ImageModal from "@/components/layout/ImageModal"; // Adjust the path if necessary

// 2. Import images to ensure they are processed correctly by the build system
import layout1 from '@/assets/images/layout_1.jpg';
import layout2 from '@/assets/images/layout_2.jpg';
import layout3 from '@/assets/images/layout_3.jpg';
import floorPlan from '@/assets/images/floor.jpg';

export default {
  name: 'ExhibitionLayout',
  components: {
    ImageModal // 3. Register the component
  },
  data() {
    return {
      isModalVisible: false,
      selectedImage: null,
      // 4. Make images available in the component's data
      layoutImage1: layout1,
      layoutImage2: layout2,
      layoutImage3: layout3,
      floorPlan: floorPlan
    }
  },
  methods: {
    // 5. Methods to control the modal
    openModal(imageUrl) {
      this.selectedImage = imageUrl;
      this.isModalVisible = true;
    },
    closeModal() {
      this.isModalVisible = false;
      this.selectedImage = null;
    }
  }
}
</script>

<style scoped>
.exhibitors-section {
  background-color: #ffffff;
  font-size: 38px;
  text-align: center;
}

.container {
  max-width: 1200px;
  margin: 0 auto;
  padding: 0 20px;
  text-align: center;
}

.container img {
  max-width: 100%; 
  height: auto; 
  width: 30%;
  cursor: pointer; /* Add pointer to show it's clickable */
  transition: transform 0.2s ease, box-shadow 0.2s ease; /* Add a nice hover effect */
  margin: 5px;
}

.container img:hover {
  transform: scale(1.05); /* Slightly enlarge on hover */
  box-shadow: 0 4px 8px rgba(0,0,0,0.2);
}
</style>