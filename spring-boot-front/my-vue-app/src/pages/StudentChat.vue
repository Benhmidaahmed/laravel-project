<template>
  <div v-if="psy" class="messages-container">
    <!-- Contacts sidebar -->
    <div class="contacts-list">
      <h5>Psychologist</h5>
      <ul>
        <li class="active">
          <img :src="getImageUrl(psy.url_image)" :alt="psy.first_name" class="avatar" />
          <span class="name">{{ psy.first_name }} {{ psy.last_name }}</span>
        </li>
      </ul>
    </div>

    <!-- Chat panel -->
    <div class="chat-panel">
      <div class="chat-header">
        <img :src="getImageUrl(psy.url_image)" :alt="psy.first_name" class="avatar" />
        <h5>{{ psy.first_name }} {{ psy.last_name }}</h5>
      </div>
      <div ref="chatBody" class="chat-body">
        <div
          v-for="msg in conversation"
          :key="msg.id"
          :class="['message', msg.sender_id === currentUserId ? 'sent' : 'received']"
        >
          <p>{{ msg.content }}</p>
          <span class="ts">{{ formatTime(msg.timestamp) }}</span>
        </div>
      </div>
      <div class="chat-input">
        <input
          v-model="newMessageText"
          placeholder="Type a message..."
          @keyup.enter="sendMessage"
          :disabled="isSending"
        />
        <button @click="sendMessage" :disabled="!newMessageText.trim() || isSending">
          {{ isSending ? 'Sending...' : 'Send' }}
        </button>
      </div>
    </div>
  </div>
  
  <div v-else class="loading-state">
    <p v-if="!error">Loading chat session...</p>
    <p v-else class="error-message">{{ error }}</p>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  name: 'StudentChat',
  data() {
    return {
      currentUserId: null,
      psy: null,
      conversation: [],
      newMessageText: '',
      isSending: false,
      error: null,
      isLoading: true
    };
  },
  async created() {
    try {
      this.currentUserId = parseInt(localStorage.getItem('userId'));
      if (!this.currentUserId) {
        throw new Error('User ID not found');
      }

      await this.initializeChat();
    } catch (err) {
      this.error = err.message || 'Failed to initialize chat';
      console.error('Initialization error:', err);
    } finally {
      this.isLoading = false;
    }
  },
  methods: {
    getImageUrl(path) {
      if (!path) return '/default-avatar.png';
      if (path.startsWith('http')) return path;
      return `${process.env.VUE_APP_API_URL || 'http://localhost:8084'}/storage/${path}`;
    },

    async initializeChat() {
      try {
        const psyId = parseInt(this.$route.params.psyId);
        if (!psyId) throw new Error('Invalid psychologist ID');

        const response = await axios.get('/api/psychologists', {
          headers: {
            'Authorization': `Bearer ${localStorage.getItem('token')}`
          }
        });
        
        this.psy = response.data.find(p => p.id === psyId);
        if (!this.psy) throw new Error('Psychologist not found');

        await this.loadConversation();
        this.scrollToBottom();
      } catch (err) {
        this.error = err.response?.data?.message || err.message || 'Failed to load chat';
        throw err;
      }
    },

    async loadConversation() {
      try {
        const response = await axios.post('/api/messages/conversation', {
          user1Id: this.currentUserId,
          user2Id: parseInt(this.$route.params.psyId)
        }, {
          headers: {
            'Authorization': `Bearer ${localStorage.getItem('token')}`
          }
        });

        this.conversation = response.data || [];
      } catch (err) {
        console.error('Error loading conversation:', err);
        this.error = err.response?.data?.message || 'Failed to load messages';
        this.conversation = [];
      }
    },

    async sendMessage() {
      if (!this.newMessageText.trim() || this.isSending) return;

      this.isSending = true;
      try {
        await axios.post('/api/messages/send', {
          senderId: this.currentUserId,
          receiverId: parseInt(this.$route.params.psyId),
          message: this.newMessageText.trim()
        }, {
          headers: {
            'Authorization': `Bearer ${localStorage.getItem('token')}`
          }
        });

        this.newMessageText = '';
        await this.loadConversation();
        this.$nextTick(this.scrollToBottom);
      } catch (err) {
        console.error('Error sending message:', {
          error: err.response?.data,
          config: err.config
        });
        alert(`Error: ${err.response?.data?.message || err.message}`);
      } finally {
        this.isSending = false;
      }
    },

    scrollToBottom() {
      const container = this.$refs.chatBody;
      if (container) {
        container.scrollTop = container.scrollHeight;
      }
    },

    formatTime(timestamp) {
      if (!timestamp) return '';
      return new Date(timestamp).toLocaleTimeString([], {
        hour: '2-digit',
        minute: '2-digit'
      });
    }
  }
};
</script>


  
  <style scoped>
  .messages-container {
    display: flex;
    height: calc(100vh );
    background: #fff;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: var(--shadow);
  }
  
  /* ---- Contacts List ---- */
  .contacts-list {
    width: 240px;
    border-right: 1px solid #eee;
    overflow-y: auto;
    padding: 1rem 0.5rem;
    background: #fafafa;
  }
  .contacts-list h5 {
    margin: 0 0 0.5rem 0.5rem;
    font-size: 1rem;
    color: #333;
  }
  .contacts-list ul {
    list-style: none;
    padding: 0;
    margin: 0;
  }
  .contacts-list li {
    display: flex;
    align-items: center;
    padding: 0.5rem;
    cursor: pointer;
    border-radius: 4px;
    transition: background 0.2s;
  }
  .contacts-list li.active,
  .contacts-list li:hover {
    background: #e4e6eb;
  }
  .contacts-list .avatar {
    width: 36px;
    height: 36px;
    border-radius: 50%;
    object-fit: cover;
    margin-right: 0.5rem;
  }
  .contacts-list .name {
    font-size: 0.9rem;
    color: #333;
  }
  
  /* ---- Chat Panel ---- */
  .chat-panel {
    flex: 1;
    display: flex;
    flex-direction: column;
  }
  .empty-state {
    margin: auto;
    color: #999;
    font-style: italic;
  }
  
  /* Header */
  .chat-header {
    display: flex;
    align-items: center;
    padding: 0.75rem 1rem;
    border-bottom: 1px solid #eee;
  }
  .chat-header .avatar {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    object-fit: cover;
    margin-right: 0.75rem;
  }
  .chat-header h5 {
    margin: 0;
    font-size: 1rem;
    color: #333;
  }
  
  /* Body */
  .chat-body {
    flex: 1;
    padding: 1rem;
    overflow-y: auto;
    background: #f5f5f5;
  }
  .message {
    max-width: 65%;
    margin-bottom: 0.75rem;
    padding: 0.75rem 1rem;
    border-radius: 24px;        /* more rounded */
    text-align: left;           /* align text left inside bubble */
    position: relative;
    word-break: break-word;
  }
  .message.sent {
    background: #4a76a8;
    color: #fff;
    margin-left: auto;
    border-bottom-right-radius: 6px;  /* keep a slight “tail” */
  }
  .message.received {
    background: #fff;
    color: #333;
    margin-right: auto;
    border-bottom-left-radius: 6px;
  }
  .message .ts {
    display: block;
    font-size: 0.7rem;
    margin-top: 0.25rem;
    text-align: right;
    color: rgba(255, 255, 255, 0.7);
  }
  .message.received .ts {
    color: rgba(0, 0, 0, 0.45);
  }
  
  /* Input */
  .chat-input {
    display: flex;
    padding: 0.75rem 1rem;
    border-top: 1px solid #eee;
    background: #fafafa;
  }
  .chat-input input {
    flex: 1;
    padding: 0.5rem 0.75rem;
    border: 1px solid #ccc;
    border-radius: 20px;
    outline: none;
  }
  .chat-input button {
    margin-left: 0.5rem;
    padding: 0 1rem;
    background: #4a76a8;
    border: none;
    border-radius: 20px;
    color: #fff;
    cursor: pointer;
    transition: background 0.2s;
  }
  .chat-input button:hover {
    background: #3b5c83;
  }
  </style>
  