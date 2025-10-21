<template>
  <footer class="app-footer">
    <div class="container">
      <div class="footer-links">
        <div class="link-column">
          <h4>Subscriptions</h4>
          <ul>
            <li><a href="#">The Star Digital Access</a></li>
            <li><a href="#">Newsstand</a></li>
          </ul>
        </div>
        <div class="link-column">
          <h4>Advertising</h4>
          <ul>
            <li><a href="#">Our Rate Card</a></li>
            <li><a href="#">Classifieds</a></li>
          </ul>
        </div>
        <div class="link-column">
          <h4>Company Info</h4>
          <ul>
            <li><a href="#">About Us</a></li>
            <li><a href="#">Job Opportunities</a></li>
            <li><a href="#">Investor Relations</a></li>
          </ul>
        </div>
        <div class="link-column">
          <h4>Help</h4>
          <ul>
            <li><a href="#">Contact Us</a></li>
            <li><a href="#">FAQs</a></li>
          </ul>
        </div>
        <div class="link-column">
          <h4>Policies</h4>
          <ul>
            <li><a href="#">Privacy Statement</a></li>
            <li><a href="#">Terms & Conditions</a></li>
          </ul>
        </div>
      </div>
      <div class="footer-bottom">
        <div class="social-media">
          <a href="#"><i class="fab fa-youtube"></i></a>
          <a href="#"><i class="fab fa-instagram"></i></a>
          <a href="#"><i class="fab fa-xing"></i></a>
          <a href="#"><i class="fab fa-facebook-f"></i></a>
          <a href="#"><i class="fab fa-telegram-plane"></i></a>
        </div>
        <div class="app-stores">
          <a href="#"><img src="https://developer.apple.com/assets/elements/badges/download-on-the-app-store.svg" alt="App Store"></a>
          <a href="#"><img src="https://play.google.com/intl/en_us/badges/static/images/badges/en_badge_web_generic.png" alt="Google Play"></a>
          <a href="#"><img src="https://upload.wikimedia.org/wikipedia/commons/thumb/5/5b/Huawei_AppGallery_black_badge_v3.svg/1280px-Huawei_AppGallery_black_badge_v3.svg.png" alt="AppGallery"></a>
        </div>
      </div>
      <div class="newsletter">
        <p>Subscribe to our FREE newsletter:</p>
        <form @submit.prevent="subscribe">
          <input type="email" placeholder="Enter Your Email Address Here" v-model="email">
          <button type="submit">Subscribe</button>
        </form>
      </div>
    </div>
    <div class="copyright">
      <p>Copyright © 1995-2025 Star Media Group Berhad (197101000523 (10894-T))</p>
    </div>
  </footer>
</template>

<script>
export default {
  name: 'AppFooter',
  data() {
    return {
      email: ''
    }
  },
  methods: {
    subscribe() {
      if (this.email) {
        alert(`Thank you for subscribing with ${this.email}!`);
        this.email = '';
      } else {
        alert('Please enter a valid email address.');
      }
    }
  }
}
</script>

<style scoped>
.app-footer {
  background-color: #333;
  color: #fff;
  padding: 40px 0 20px;
}

.container {
  max-width: 1200px;
  margin: 0 auto;
  padding: 0 20px;
}

.footer-links {
  display: flex;
  justify-content: space-between;
  flex-wrap: wrap;
  margin-bottom: 30px;
}

.link-column {
  flex: 1;
  min-width: 150px;
  margin: 10px;
}

.link-column h4 {
  font-size: 1.1rem;
  margin-bottom: 15px;
  text-transform: uppercase;
}

.link-column ul {
  list-style: none;
  padding: 0;
}

.link-column ul li a {
  color: #ccc;
  text-decoration: none;
  line-height: 2;
  transition: color 0.3s ease;
}

.link-column ul li a:hover {
  color: #fff;
}

.footer-bottom {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 20px 0;
  border-top: 1px solid #555;
  border-bottom: 1px solid #555;
}

.social-media a {
  color: #fff;
  margin: 0 10px;
  font-size: 1.5rem;
}

.app-stores a img {
  height: 40px;
  margin: 0 5px;
}

.newsletter {
  padding: 20px 0;
  text-align: center;
}

.newsletter form {
  display: flex;
  justify-content: center;
  margin-top: 10px;
}

.newsletter input {
  padding: 10px;
  width: 300px;
  border: none;
  border-radius: 5px 0 0 5px;
}

.newsletter button {
  padding: 10px 20px;
  background-color: #555;
  color: #fff;
  border: none;
  cursor: pointer;
  border-radius: 0 5px 5px 0;
}

.copyright {
  text-align: center;
  padding-top: 20px;
  font-size: 0.9rem;
  color: #aaa;
}
</style>