<template>
  <section class="sessions-container">
    <img src="@/assets/images/job_matching.jpg" alt="Job Fair Sessions" class="background-image">
    <div 
      v-for="session in sessions" 
      :key="session.id"
      class="session-slot"
      :class="{ 'booked': session.isBooked }"
      :style="{ top: session.position.top, left: session.position.left, width: session.position.width, height: session.position.height }"
      @click="!session.isBooked && openModal(session)"
    >
      <div class="slot-content">
        <span class="session-time">{{ session.time }}</span>
        <!-- We can now optimistically update the UI -->
        <span v-if="session.isBooked" class="status">Booked!</span>
        <span v-else class="status">Available</span>
      </div>
    </div>
    <BookingModal 
      v-if="isModalVisible" 
      :session="selectedSession"
      @close="closeModal"
      @book-slot="handleBooking"
    />
  </section>
</template>

<script>
import axios from 'axios'; // 1. Import axios
import BookingModal from '@/components/layout/BookingModal.vue';

// ==============================================================
// === SET THE URL TO YOUR PHP SCRIPT HERE ===
// ==============================================================
const API_URL = 'http://localhost/job-fair-app/backend/api/create_reservation.php';

export default {
  name: 'JobSessions',
  components: {
    BookingModal
  },
  data() {
    return {
      isModalVisible: false,
      selectedSession: null,
      sessions: [
        { id: 1, type: 'jobMatching', day: 'Day 1 - 24 May 2025, Saturday', time: '10:00 - 11:00', isBooked: false, position: { top: '30.7%', left: '15%', width: '21.4%', height: '4.5%' } },
        { id: 2, type: 'jobMatching', day: 'Day 1 - 24 May 2025, Saturday', time: '11:30 - 12:30', isBooked: false, position: { top: '30.7%', left: '41%', width: '21.4%', height: '4.5%' } },
        { id: 3, type: 'jobMatching', day: 'Day 1 - 24 May 2025, Saturday', time: '14:00 - 15:00', isBooked: false, position: { top: '30.7%', left: '67.2%', width: '21.4%', height: '4.5%' } },
        { id: 4, type: 'jobMatching', day: 'Day 2 - 25 May 2025, Sunday', time: '10:00 - 11:00', isBooked: false, position: { top: '41.3%', left: '15%', width: '21.4%', height: '4.5%' } },
        { id: 5, type: 'careerTalk', day: 'Day 1 - 24 May 2025, Saturday', time: '10:30 - 11:00', isBooked: false, position: { top: '61%', left: '13.5%', width: '21.4%', height: '4.5%' } },
        { id: 6, type: 'careerTalk', day: 'Day 1 - 24 May 2025, Saturday', time: '13:30 - 14:00', isBooked: false, position: { top: '61%', left: '39.6%', width: '21.4%', height: '4.5%' } },
        { id: 7, type: 'careerTalk', day: 'Day 1 - 24 May 2025, Saturday', time: '15:30 - 16:00', isBooked: false, position: { top: '61%', left: '65.7%', width: '21.4%', height: '4.5%' } },
        { id: 8, type: 'careerTalk', day: 'Day 2 - 25 May 2025, Sunday', time: '10:30 - 11:00', isBooked: false, position: { top: '71.7%', left: '13.6%', width: '21.4%', height: '4.5%' } },
        { id: 9, type: 'careerTalk', day: 'Day 2 - 25 May 2025, Sunday', time: '13:30 - 14:00', isBooked: false, position: { top: '71.7%', left: '39.5%', width: '21.4%', height: '4.5%' } },
        { id: 10, type: 'careerTalk', day: 'Day 2 - 25 May 2025, Sunday', time: '15:30 - 16:00', isBooked: false, position: { top: '71.7%', left: '65.7%', width: '21.4%', height: '4.5%' } },
      ]
    };
  },
  methods: {
    openModal(session) {
      this.selectedSession = session;
      this.isModalVisible = true;
    },
    closeModal() {
      this.isModalVisible = false;
      this.selectedSession = null;
    },
    // 2. This method now sends the data to the PHP API
    async handleBooking(bookingData) {
      const session = this.sessions.find(s => s.id === bookingData.sessionId);
      if (!session) return;

      // Prepare the data payload for the API
      const payload = {
        user_name: bookingData.attendee.name,
        email: bookingData.attendee.email,
        session_type: session.type,
        session_date: session.day,
        session_time: session.time,
        notes: '' // Optional notes
      };

      try {
        // Send the POST request to the API
        const response = await axios.post(API_URL, payload, {
          headers: { 'Content-Type': 'application/json' }
        });

        // SUCCESS!
        // Update the UI to show the slot is booked
        session.isBooked = true; 
        alert(response.data.message || 'Success!');
        this.closeModal();

      } catch (error) {
        // FAILURE!
        // Show the specific error message from the PHP script
        const message = error.response?.data?.message || "An error occurred. Please try again.";
        console.error("Booking Error:", error);
        alert(`Error: ${message}`);
      }
    }
  }
}
</script>

<style scoped>
/* (Your existing styles are perfect, no changes needed) */
.sessions-container { position: relative; width: 100%; margin: 0 auto; }
.background-image { display: block; width: 100%; height: auto; }
.session-slot {
  position: absolute; background-color: rgba(255, 255, 255, 0.7);
  border: 2px dashed #007bff; border-radius: 25px; cursor: pointer;
  transition: all 0.3s ease; display: flex; justify-content: center;
  align-items: center; text-align: center; color: #003366;
  font-family: Arial, sans-serif; font-weight: bold;
}
.session-slot:hover {
  background-color: rgba(255, 255, 255, 0.9); border-style: solid;
  transform: scale(1.05);
}
.session-slot.booked {
  background-color: rgba(40, 167, 69, 0.7); /* Green for successfully booked */
  border: 2px solid #218838; cursor: not-allowed; color: #fff;
}
.session-slot.booked:hover { transform: scale(1); }
.slot-content { display: flex; flex-direction: column; }
.session-time { font-size: 1.1em; }
.status { font-size: 13px; margin-top: 5px; text-transform: uppercase; }
</style>