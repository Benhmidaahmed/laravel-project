<template>
    <div v-if="psy" class="messages-container">
      <!-- Contacts sidebar: here just the one psych -->
      <div class="contacts-list">
        <h5>Psychologist</h5>
        <ul>
          <li class="active">
            <img :src="getImageUrl(psy.urlImage)" class="avatar" />
            <span class="name">{{ psy.firstName }} {{ psy.lastName }}</span>
          </li>
        </ul>
      </div>
  
      <!-- Chat panel -->
      <div class="chat-panel">
        <div class="chat-header">
          <img :src="getImageUrl(psy.urlImage)" class="avatar" />
          <h5>{{ psy.firstName }} {{ psy.lastName }}</h5>
        </div>
        <div ref="body" class="chat-body">
          <div
            v-for="msg in conversation"
            :key="msg.id"
            :class="['message', msg.sender.id === currentUserId ? 'sent' : 'received']"
          >
            {{ msg.content }}
            <span class="ts">{{ formatTime(msg.timestamp) }}</span>
          </div>
        </div>
        <div class="chat-input">
          <input
            v-model="newMessageText"
            placeholder="Type a message…"
            @keyup.enter="sendMessage"
          />
          <button @click="sendMessage">Send</button>
        </div>
      </div>
    </div>
    <div v-else class="empty-state">
      Loading chat…
    </div>
  </template>
  
  <script>
  import axios from 'axios';
  export default {
    name: 'StudentChat',
    data() {
      return {
        currentUserId: Number(localStorage.getItem('userId')),
        psy: null,
        conversation: [],
        newMessageText: '',
      };
    },
    async mounted() {
     
      // load the psychologist
      const psyId = Number(this.$route.params.psyId);
      const { data: allPsys } = await axios.get('/api/psychologists');
      this.psy = allPsys.find(p => p.id === psyId);
  
      // load and scroll
      await this.loadConversation();
      this.scrollToBottom();
    },
    methods: {
        getImageUrl(path) {
    if (!path) {
      return 'https://via.placeholder.com/40';
    }
    // already absolute?
    if (path.startsWith('http')) {
      return path;
    }
    return `http://localhost:8084${path}`;
  },
      async loadConversation() {
        const payload = {
          user1Id: this.currentUserId,
          user2Id: Number(this.$route.params.psyId),
        };
        const { data } = await axios.post('/api/messages/conversation', payload);
        this.conversation = data;
      },
      async sendMessage() {
        if (!this.newMessageText.trim()) return;
        await axios.post('/api/messages/send', {
          senderId: this.currentUserId,
          receiverId: Number(this.$route.params.psyId),
          message: this.newMessageText,
        });
        this.newMessageText = '';
        await this.loadConversation();
        this.$nextTick(this.scrollToBottom);
      },
      scrollToBottom() {
        const el = this.$refs.body;
        if (el) el.scrollTop = el.scrollHeight;
      },
      formatTime(ts) {
        return new Date(ts).toLocaleString();
      },
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
  