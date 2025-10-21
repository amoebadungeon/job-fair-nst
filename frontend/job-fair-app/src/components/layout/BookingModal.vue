<template>
  <div class="modal-backdrop" @click.self="close">
    <div class="modal-content">
      <button class="close-button" @click="close">&times;</button>
      
      <div v-if="session">
        <h3>Reserve Slot</h3>
        <p>
          <strong>{{ session.type === 'jobMatching' ? 'Job Matching' : 'Career Talk' }}</strong><br>
          {{ session.day }}, {{ session.time }}
        </p>
        
        <form @submit.prevent="handleSubmit">
          <div class="form-group">
            <label for="name">Full Name:</label>
            <input type="text" id="name" v-model="name" required>
          </div>
          <div class="form-group">
            <label for="email">Email Address:</label>
            <input type="email" id="email" v-model="email" required>
          </div>
          <button type="submit" class="submit-btn">Reserve My Slot</button>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'BookingModal',
  props: {
    session: {
      type: Object,
      default: null
    }
  },
  data() {
    return {
      name: '',
      email: ''
    };
  },
  methods: {
    close() {
      this.$emit('close');
    },
    handleSubmit() {
      if (!this.name || !this.email) {
        alert('Please fill in all fields.');
        return;
      }
      // Emit the user's details to the parent component
      this.$emit('book-slot', {
        sessionId: this.session.id,
        attendee: {
          name: this.name,
          email: this.email
        }
      });
    }
  }
}
</script>

<style scoped>
/* (Styles are good, no changes needed here) */
.modal-backdrop {
  position: fixed; top: 0; left: 0; width: 100%; height: 100%;
  background-color: rgba(0, 0, 0, 0.7); display: flex;
  justify-content: center; align-items: center; z-index: 1000;
}
.modal-content {
  position: relative; background-color: #fff; padding: 25px 35px;
  border-radius: 8px; width: 90%; max-width: 450px;
  box-shadow: 0 5px 15px rgba(0,0,0,.5);
}
.close-button {
  position: absolute; top: 10px; right: 15px; font-size: 2.5rem;
  font-weight: bold; background: none; border: none; cursor: pointer;
}
.form-group { margin-bottom: 15px; }
.form-group label { display: block; margin-bottom: 5px; font-weight: bold; }
.form-group input { width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; }
.submit-btn {
  width: 100%; padding: 12px; background-color: #4CAF50; color: white;
  border: none; border-radius: 4px; cursor: pointer; font-size: 16px;
}
</style>