<template>
  <div id="app">
    <AppHeader />
    <main>
      <HeroBanner />
      <PastExhibitors />
      <ExhibitionLayout />
      <JobSessions/>
      <JobTour/>
    </main>
    <AppFooter />
    <ChatbotWidget />
  </div>
</template>

<script>
import AppHeader from './components/layout/AppHeader.vue'
import HeroBanner from './components/home/HeroBanner.vue'
import PastExhibitors from './components/home/PastExhibitors.vue'
import ExhibitionLayout from './components/home/ExhibitionLayout.vue'
import JobSessions from './components/home/JobSessions.vue';
import JobTour from './components/home/JobTour.vue';
import AppFooter from './components/layout/AppFooter.vue'
import ChatbotWidget from './components/layout/ChatbotWidget.vue'

export default {
  name: 'App',
  components: {
    AppHeader,
    HeroBanner,
    PastExhibitors,
    ExhibitionLayout,
    AppFooter,
    JobSessions,
    JobTour,
    ChatbotWidget
  },
 data() {
    return {
      assetId: 'OWFlMGNiOTMtZjc5OS00MDc1LThjNzAtMWMzNTI0Y2FmMTY4', // Do not remove.

    }
  }
}
</script>

<style>
/**
 * Copyright (c) 2025 [Mustaqeem Sopee]
 *
 * This software is proprietary and confidential. Unauthorized copying,
 * sharing, or commercial use of this file, via any medium, is strictly prohibited.
 *
 * @author   Mustaqeem Sopee <johnxblend001@gmail.com>
 * @copyright 2025 Mustaqeem Sopee
 */

/* Import our global stylesheet */
@import './assets/css/main.css';

/* Add Font Awesome for footer icons (simple CDN method) */
@import url('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css');
</style>