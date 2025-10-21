<template>
  <!-- The semi-transparent background -->
  <div class="modal-backdrop" @click.self="closeModal">
    <div class="modal-content">
      <button class="close-button" @click="closeModal">&times;</button>
      <img :src="imageUrl" alt="Enlarged exhibition layout">
    </div>
  </div>
</template>

<script>
export default {
  name: 'ImageModal',
  props: {
    imageUrl: {
      type: String,
      required: true
    }
  },
  methods: {
    closeModal() {
      this.$emit('close'); // Emits an event to the parent component to close the modal
    }
  }
}
</script>

<style scoped>
.modal-backdrop {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.8);
  display: flex;
  justify-content: center;
  align-items: center;
  z-index: 1000; /* Ensure it's on top of everything */
}

.modal-content {
  position: relative;
  background-color: #fff;
  padding: 15px;
  border-radius: 8px;
  box-shadow: 0 5px 15px rgba(0,0,0,.5);
  justify-items: center;
  align-content: center;
  width: 50vw;
  height: 50vh;
}

.modal-content img {
  display: block;
  max-width: 100%;
  max-height: calc(90vh - 30px); /* Adjust for padding */
  height: 45vh;
}

.close-button {
  position: absolute;
  top: 10px;
  right: 15px;
  font-size: 2.5rem;
  font-weight: bold;
  color: #333;
  background: none;
  border: none;
  cursor: pointer;
  line-height: 1;
}
</style>