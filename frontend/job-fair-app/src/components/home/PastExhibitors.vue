<template>
  <section class="exhibitors-section">
    <div class="container">
      <img src="@/assets/images/exhibitors.jpg" alt="A collage showing logos of past exhibitors and photos from the event.">
    </div>
    
    <div class="container upcoming-fair-container">
          
      <!-- Live Countdown Timer -->
      <div class="countdown-timer">
        <h2 class="countdown-title">Next Fair in Johor Bahru Begins In:</h2>
        <div v-if="!isFairLive" class="timer-grid">
          <div class="time-block">
            <span class="number">{{ days }}</span>
            <span class="label">Days</span>
          </div>
          <div class="time-block">
            <span class="number">{{ hours }}</span>
            <span class="label">Hours</span>
          </div>
          <div class="time-block">
            <span class="number">{{ minutes }}</span>
            <span class="label">Minutes</span>
          </div>
          <div class="time-block">
            <span class="number">{{ seconds }}</span>
            <span class="label">Seconds</span>
          </div>
        </div>
        <div v-else class="fair-live-message">
          <h2>The Fair is Live! Join Us Now!</h2>
        </div>
      </div>

      <img src="@/assets/images/upcoming-fair.jpg" alt="A collage showing logos of upcoming fair.">
    </div>
  </section>
</template>

<script>
export default {
  name: 'PastExhibitors',
  data() {
    return {
      fairDate: new Date('2025-12-24T09:00:00'),

      days: '00',
      hours: '00',
      minutes: '00',
      seconds: '00',
      isFairLive: false,
      countdownInterval: null
    };
  },
  methods: {
    updateCountdown() {
      const now = new Date();
      const distance = this.fairDate.getTime() - now.getTime();

      if (distance <= 0) {
        this.isFairLive = true;
        clearInterval(this.countdownInterval);
        return;
      }

      const days = Math.floor(distance / (1000 * 60 * 60 * 24));
      const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
      const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
      const seconds = Math.floor((distance % (1000 * 60)) / 1000);

      this.days = days < 10 ? '0' + days : days;
      this.hours = hours < 10 ? '0' + hours : hours;
      this.minutes = minutes < 10 ? '0' + minutes : minutes;
      this.seconds = seconds < 10 ? '0' + seconds : seconds;
    }
  },
  mounted() {
    this.updateCountdown();
    this.countdownInterval = setInterval(this.updateCountdown, 1000);
  },
  beforeUnmount() {
 
    clearInterval(this.countdownInterval);
  }
}
</script>

<style scoped>
.exhibitors-section {
  padding: 60px 0;
  background-color: #ffffff;
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
}

.upcoming-fair-container {
  margin-top: 40px; 
}

/* --- Countdown Timer Styles --- */
.countdown-timer {
  font-family: Arial, sans-serif;
  color: #333;
  margin-top: 30px;
  padding: 20px;
  border-radius: 10px;
  background-color: #f4f4f4;
}

.countdown-title {
  font-size: 2rem;
  font-weight: bold;
  margin-bottom: 20px;
  color: #2c3e50;
}

.timer-grid {
  display: flex;
  justify-content: center;
  gap: 20px;
}

.time-block {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  background-color: #007bff;
  color: #fff;
  border-radius: 8px;
  padding: 15px;
  min-width: 100px;
  box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}

.number {
  font-size: 3rem;
  font-weight: bold;
  line-height: 1;
}

.label {
  font-size: 1rem;
  text-transform: uppercase;
  margin-top: 5px;
}

.fair-live-message h2 {
  font-size: 2.5rem;
  color: #28a745;
  animation: pulse 1.5s infinite;
}

@keyframes pulse {
  0% {
    transform: scale(1);
  }
  50% {
    transform: scale(1.05);
  }
  100% {
    transform: scale(1);
  }
}
</style>