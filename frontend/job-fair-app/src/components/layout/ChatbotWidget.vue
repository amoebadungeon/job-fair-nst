<template>
  <div class="chatbot-widget">
    <!-- Chat Window -->
    <div class="chat-window" :class="{ 'is-open': isOpen }">
      <div class="chat-header">
        Job Fair Assistant
        <button class="close-btn" @click="toggleChat">&times;</button>
      </div>
      <div class="chat-body" ref="chatBody">
        <!-- Loop through all messages and display them -->
        <div v-for="(msg, index) in messages" :key="index" class="message" :class="msg.sender">
          {{ msg.text }}
        </div>
        <!-- Show a "typing..." indicator when the bot is thinking -->
        <div v-if="isLoading" class="message bot">
          <span class="typing-indicator"></span>
        </div>
      </div>
      <div class="chat-footer">
        <form @submit.prevent="sendMessage">
          <input type="text" v-model="userInput" placeholder="Ask a question..." :disabled="isLoading" autocomplete="off" />
          <button type="submit" :disabled="isLoading || !userInput.trim()">Send</button>
        </form>
      </div>
    </div>
    
    <!-- Floating Toggle Button -->
    <button class="chat-toggle-btn" @click="toggleChat">
      <!-- You can use an SVG or an <img> tag here -->
      <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-chat-dots-fill" viewBox="0 0 16 16">
        <path d="M16 8c0 3.866-3.582 7-8 7a9.06 9.06 0 0 1-2.347-.306c-.584.296-1.925.864-4.181 1.234-.2.032-.352-.176-.273-.362.354-.836.674-1.95.77-2.966C.744 11.37 0 9.76 0 8c0-3.866 3.582-7 8-7s8 3.134 8 7zM5 8a1 1 0 1 0-2 0 1 1 0 0 0 2 0zm4 0a1 1 0 1 0-2 0 1 1 0 0 0 2 0zm3 1a1 1 0 1 0 0-2 1 1 0 0 0 0 2z"/>
      </svg>
    </button>
  </div>
</template>

<script>
import axios from 'axios';

// ================================================================
// === CONFIGURE YOUR BACKEND API AND PROJECT ID HERE ===
// ================================================================
// The full URL to the PHP script you created
const CHATBOT_API_URL = 'http://localhost/job-fair-app/backend/api/chatbot.php';

// The Project ID from your Dialogflow Agent's settings
const DIALOGFLOW_PROJECT_ID = 'jobfairhelper-wcvk'; // <-- REPLACE with your actual Project ID

export default {
  name: 'ChatbotWidget',
  data() {
    return {
      isOpen: false,
      isLoading: false,
      userInput: '',
      sessionId: null, // To maintain conversation context for Dialogflow
      messages: [
        // The conversation starts with a welcome message from the bot
        { sender: 'bot', text: 'Hello! Ask me anything about the job fair.' }
      ]
    };
  },
  methods: {
    toggleChat() {
      this.isOpen = !this.isOpen;
      if (this.isOpen) {
        this.scrollToBottom();
      }
    },
    async sendMessage() {
      const userMessage = this.userInput.trim();
      if (!userMessage) return; // Don't send empty messages

      // 1. Add the user's message to the chat window immediately
      this.messages.push({ sender: 'user', text: userMessage });
      this.userInput = ''; // Clear the input field
      this.isLoading = true; // Show the "typing..." indicator
      this.scrollToBottom();

      try {
        // 2. Send the message to your PHP backend
        const response = await axios.post(CHATBOT_API_URL, {
          message: userMessage,
          projectId: DIALOGFLOW_PROJECT_ID,
          sessionId: this.sessionId // Send the current session ID (or null if it's the first message)
        });
        
        // 3. Add the bot's reply from the API response
        this.messages.push({ sender: 'bot', text: response.data.reply });
        
        // 4. Save the session ID from the response to maintain context for the next message
        this.sessionId = response.data.sessionId;

      } catch (error) {
        console.error("Error communicating with chatbot API:", error);
        this.messages.push({ sender: 'bot', text: "Sorry, I'm having technical difficulties." });
      } finally {
        // 5. Hide the "typing..." indicator and scroll to the new message
        this.isLoading = false;
        this.scrollToBottom();
      }
    },
    scrollToBottom() {
      // This helper function ensures the chat window always shows the latest message
      this.$nextTick(() => {
        const chatBody = this.$refs.chatBody;
        if (chatBody) {
          chatBody.scrollTop = chatBody.scrollHeight;
        }
      });
    }
  }
};
</script>

<style scoped>
/* Scoped CSS for the chat widget */
.chatbot-widget {
  position: fixed;
  bottom: 20px;
  right: 20px;
  z-index: 1000;
}

.chat-toggle-btn {
  background-color: #007bff;
  color: white;
  border: none;
  border-radius: 50%;
  width: 100px;
  height: 100px;
  cursor: pointer;
  box-shadow: 0 4px 10px rgba(0,0,0,0.2);
  display: flex;
  justify-content: center;
  align-items: center;
  transition: transform 0.2s ease;
}

.chat-toggle-btn:hover {
  transform: scale(1.1);
}

.chat-window {
  position: absolute;
  bottom: 80px;
  right: 0;
  width: 350px;
  height: 500px;
  background-color: white;
  border-radius: 15px;
  box-shadow: 0 5px 15px rgba(0,0,0,0.3);
  display: flex;
  flex-direction: column;
  overflow: hidden;
  /* Start hidden and scale up on open */
  transform: scale(0);
  transform-origin: bottom right;
  transition: transform 0.3s ease-in-out;
}

.chat-window.is-open {
  transform: scale(1);
}

.chat-header {
  background-color: #007bff;
  color: white;
  padding: 15px;
  font-weight: bold;
  font-size: 1.1rem;
  display: flex;
  justify-content: space-between;
  align-items: center;
  flex-shrink: 0;
}

.close-btn {
  background: none;
  border: none;
  color: white;
  font-size: 1.5rem;
  cursor: pointer;
  line-height: 1;
}

.chat-body {
  flex: 1;
  padding: 15px;
  overflow-y: auto;
  background-color: #f4f7f9;
}

.message {
  padding: 10px 15px;
  border-radius: 20px;
  margin-bottom: 10px;
  max-width: 85%;
  line-height: 1.4;
  clear: both; /* Ensure messages don't overlap */
}

.message.bot {
  background-color: #e9ebee;
  color: #333;
  float: left;
}

.message.user {
  background-color: #007bff;
  color: white;
  float: right;
}

.chat-footer {
  padding: 10px;
  border-top: 1px solid #ddd;
  background-color: #fff;
  flex-shrink: 0;
}

.chat-footer form {
  display: flex;
}

.chat-footer input {
  flex: 1;
  border: 1px solid #ccc;
  border-radius: 20px;
  padding: 10px 15px;
  margin-right: 10px;
  font-size: 1rem;
}
.chat-footer input:focus {
  outline: none;
  border-color: #007bff;
}

.chat-footer button {
  background-color: #007bff;
  color: white;
  border: none;
  border-radius: 20px;
  padding: 10px 20px;
  cursor: pointer;
  font-weight: bold;
  transition: background-color 0.2s;
}

.chat-footer button:hover {
  background-color: #0056b3;
}

.chat-footer button:disabled {
  background-color: #aaa;
  cursor: not-allowed;
}

/* Typing indicator animation */
.typing-indicator {
  display: inline-block;
  padding: 10px;
}
.typing-indicator::after {
  content: '●';
  animation: typing 1.5s infinite;
  box-shadow: 5px 0 0 -2px, 10px 0 0 -4px; /* Creates the dots */
  opacity: 0.5;
}
@keyframes typing {
  0%, 100% { box-shadow: 5px 0 0 -2px, 10px 0 0 -4px; opacity: 0.5; }
  33% { box-shadow: 5px 0 0 0px, 10px 0 0 -4px; opacity: 1; }
  66% { box-shadow: 5px 0 0 -2px, 10px 0 0 0px; opacity: 1; }
}
</style>