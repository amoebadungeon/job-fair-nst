<template>
  <header class="app-header">
    <div class="container">
      <div class="logo">
        <img src="@/assets/images/logo.jpg" alt="myStarJob Fair Logo">
      </div>
      <nav class="main-nav">
        <a href="#home" class="nav-link">HOME</a>
        <a href="#contact" class="nav-link">CONTACT US</a>
        
        <!-- Changed to a button and added a click event -->
        <button @click="openModal" class="nav-button">BE OUR EXHIBITOR</button>
      </nav>
    </div>

    <!-- Conditionally render the modal component -->
    <ExhibitorModal v-if="isModalVisible" @close="closeModal" />
  </header>
</template>

<script>
// 1. Import the modal component
import ExhibitorModal from './ExhibitorModal.vue';

export default {
  name: 'AppHeader',
  // 2. Register the component
  components: {
    ExhibitorModal
  },
  // 3. Add data to control modal visibility
  data() {
    return {
      isModalVisible: false
    }
  },
  // 4. Add methods to open and close the modal
  methods: {
    openModal() {
      this.isModalVisible = true;
    },
    closeModal() {
      this.isModalVisible = false;
    }
  }
}
</script>

<style scoped>
.app-header {
  background-color: #fff;
  padding: 15px 0;
  border-bottom: 1px solid #eaeaea;
}

.container {
  display: flex;
  justify-content: space-between;
  align-items: center;
  max-width: 1200px;
  margin: 0 auto;
  padding: 0 20px;
}

.logo img {
  height: 50px;
}

.main-nav {
  display: flex;
  align-items: center;
}

.nav-link {
  color: #333;
  text-decoration: none;
  font-weight: bold;
  margin: 0 15px;
  padding: 8px 12px;
  border: 2px solid #000;
  border-radius: 20px;
  transition: all 0.3s ease;
}

.nav-link:hover {
  background-color: #f0f0f0;
}

/* This is a <button>, but we style it like the old <a> tag */
.nav-button {
  background-color: #4CAF50;
  color: white;
  padding: 10px 20px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 16px;
  margin-left: 15px;
  cursor: pointer;
  border: none;
  border-radius: 25px;
  font-weight: bold;
  transition: background-color 0.3s ease;
}

.nav-button:hover {
  background-color: #45a049;
}
</style>