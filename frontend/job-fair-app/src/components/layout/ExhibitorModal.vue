<template>
  <div class="modal-backdrop" @click.self="close">
    <div class="modal-content">
      <button class="close-button" @click="close">&times;</button>
      <h3>Become an Exhibitor</h3>
      <p>Fill out the form below to register your interest. Our team will get in touch with you shortly.</p>

      <!-- Form Submission Status -->
      <div v-if="submissionStatus" class="submission-message" :class="submissionStatus.type">
        {{ submissionStatus.message }}
      </div>

      <form @submit.prevent="handleSubmit">
        <!-- Company Details -->
        <div class="form-row">
          <div class="form-group">
            <label for="company_name">Company Name*</label>
            <input type="text" id="company_name" v-model="form.company_name" required>
          </div>
          <div class="form-group">
            <label for="industry">Industry</label>
            <input type="text" id="industry" v-model="form.industry">
          </div>
        </div>
        
        <!-- Contact Details -->
        <div class="form-row">
          <div class="form-group">
            <label for="contact_person">Contact Person*</label>
            <input type="text" id="contact_person" v-model="form.contact_person" required>
          </div>
           <div class="form-group">
            <label for="email">Email*</label>
            <input type="email" id="email" v-model="form.email" required>
          </div>
        </div>

        <div class="form-row">
          <div class="form-group">
            <label for="phone">Phone Number*</label>
            <input type="tel" id="phone" v-model="form.phone" required>
          </div>
          <div class="form-group">
            <label for="company_size">Company Size</label>
             <select id="company_size" v-model="form.company_size">
              <option value="">Select Size</option>
              <option value="1-10">1-10 employees</option>
              <option value="11-50">11-50 employees</option>
              <option value="51-200">51-200 employees</option>
              <option value="201-500">201-500 employees</option>
              <option value="500+">500+ employees</option>
            </select>
          </div>
        </div>

        <!-- Booth & Requirements -->
         <div class="form-group">
          <label>Booth Preference</label>
          <div class="radio-group">
            <label><input type="radio" value="standard" v-model="form.booth_preference"> Standard</label>
            <label><input type="radio" value="corner" v-model="form.booth_preference"> Corner Lot</label>
            <label><input type="radio" value="premium" v-model="form.booth_preference"> Premium</label>
          </div>
        </div>

        <div class="form-group">
          <label for="requirements">Additional Requirements</label>
          <textarea id="requirements" v-model="form.requirements" rows="3"></textarea>
        </div>

        <button type="submit" class="submit-btn" :disabled="isLoading">
          {{ isLoading ? 'Submitting...' : 'Submit Registration' }}
        </button>
      </form>
    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  name: 'ExhibitorModal',
  data() {
    return {
      form: {
        company_name: '',
        contact_person: '',
        email: '',
        phone: '',
        industry: '',
        company_size: '',
        requirements: '',
        booth_preference: 'standard'
      },
      isLoading: false,
      submissionStatus: null
    };
  },
  methods: {
    close() {
      this.$emit('close');
    },
    async handleSubmit() {
      this.isLoading = true;
      this.submissionStatus = null;

      // Use the exact URL you provided
      const apiUrl = 'http://localhost/job-fair-app/backend/api/exhibitor.php';

      try {
        // =================================================================
        // ======================  THE FIX IS HERE  ======================
        // =================================================================
        // We add a configuration object to explicitly set the Content-Type header.
        const response = await axios.post(apiUrl, this.form, {
          headers: {
            'Content-Type': 'application/json'
          }
        });
        
        this.submissionStatus = { type: 'success', message: response.data.message || 'Registration successful!' };
        console.log('Success:', response.data);

        setTimeout(() => {
          this.resetForm();
          this.close();
        }, 3000);

      } catch (error) {
        let message = 'An error occurred. Please try again.';
        if (error.response && error.response.data && error.response.data.message) {
          message = error.response.data.message;
        }
        this.submissionStatus = { type: 'error', message: message };
        console.error('API Error:', error.response || error);
      } finally {
        this.isLoading = false;
      }
    },
    resetForm() {
      this.form = {
        company_name: '',
        contact_person: '',
        email: '',
        phone: '',
        industry: '',
        company_size: '',
        requirements: '',
        booth_preference: 'standard'
      };
    }
  }
}
</script>

<style scoped>
/* Styles remain unchanged */
.modal-backdrop {
  position: fixed; top: 0; left: 0; width: 100%; height: 100%;
  background-color: rgba(0, 0, 0, 0.7); display: flex;
  justify-content: center; align-items: center; z-index: 1000;
}
.modal-content {
  position: relative; background-color: #fff; padding: 25px 35px;
  border-radius: 8px; width: 90%; max-width: 650px;
  max-height: 90vh; overflow-y: auto;
  box-shadow: 0 5px 15px rgba(0,0,0,.5); font-family: Arial, sans-serif;
}
.close-button {
  position: absolute; top: 10px; right: 15px; font-size: 2.5rem;
  font-weight: bold; background: none; border: none; cursor: pointer;
}
h3 { margin-top: 0; margin-bottom: 5px; }
p { margin-bottom: 20px; font-size: 0.9em; color: #666; }
.form-row { display: flex; gap: 20px; margin-bottom: 15px; }
.form-group { flex: 1; display: flex; flex-direction: column; }
.form-group label { margin-bottom: 5px; font-weight: bold; font-size: 0.9em; }
.form-group input, .form-group select, .form-group textarea {
  width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px;
  box-sizing: border-box;
}
.radio-group { display: flex; gap: 15px; align-items: center; margin-top: 5px; }
.radio-group label { font-weight: normal; }
.submit-btn {
  width: 100%; padding: 12px; background-color: #4CAF50; color: white;
  border: none; border-radius: 4px; cursor: pointer; font-size: 16px;
  font-weight: bold; transition: background-color 0.3s; margin-top: 15px;
}
.submit-btn:hover:not(:disabled) { background-color: #45a049; }
.submit-btn:disabled { background-color: #aaa; cursor: not-allowed; }

.submission-message { padding: 10px; margin-bottom: 15px; border-radius: 4px; }
.submission-message.success { background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb;}
.submission-message.error { background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb;}
</style>