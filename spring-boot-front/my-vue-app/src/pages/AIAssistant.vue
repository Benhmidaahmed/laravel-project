<template>
    <div class="ai-assistant-container">
      <!-- Floating Particles Background -->
      <div class="particles">
        <div v-for="i in 30" :key="i" class="particle" :style="particleStyle(i)"></div>
      </div>
  
      <!-- Main Card -->
      <div class="ai-assistant-card">
        <!-- Header with Glow Effect -->
        <div class="assistant-header glow">
          <div class="header-content">
            <div class="logo-container">
              <ion-icon name="logo-reddit" class="logo-icon"></ion-icon>
              <div class="logo-glow"></div>
            </div>
            <div class="header-text">
              <h2>UniWell AI Assistant</h2>
              <p>Your 24/7 virtual campus companion</p>
            </div>
          </div>
          <div class="header-decoration">
            <div class="decoration-line"></div>
            <div class="decoration-dots">
              <span v-for="i in 3" :key="i"></span>
            </div>
          </div>
        </div>
  
        <!-- Chat Container with Glass Morphism Effect -->
        <div class="chat-container-glass">
          <div class="chat-iframe-container">
            <iframe
              src="https://www.chatbase.co/chatbot-iframe/lR8CFH6F6R50cktx2LDnc"
              width="100%"
              height="100%"
              frameborder="0"
              class="chat-iframe"
            ></iframe>
          </div>
        </div>
  
        <!-- Floating Action Buttons -->
        <div class="fab-container">
          <button class="fab-button" @click="toggleTheme">
            <ion-icon :name="darkMode ? 'sunny' : 'moon'"></ion-icon>
          </button>
          <button class="fab-button" @click="fullscreenChat">
            <ion-icon name="expand"></ion-icon>
          </button>
        </div>
  
        <!-- Status Bar -->
        <div class="status-bar">
          <div class="status-item">
            <ion-icon name="time"></ion-icon>
            <span>24/7 Available</span>
          </div>
          <div class="status-item">
            <ion-icon name="lock-closed"></ion-icon>
            <span>Secure Chat</span>
          </div>
          <div class="status-item">
            <ion-icon name="school"></ion-icon>
            <span>Academic Support</span>
          </div>
        </div>
      </div>
    </div>
  </template>
  
  <script>
  export default {
    name: 'AIAssistant',
    data() {
      return {
        darkMode: false,
        particles: []
      }
    },
    mounted() {
      this.loadIonicons();
      this.initParticles();
    },
    methods: {
      loadIonicons() {
        const script = document.createElement('script');
        script.src = 'https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js';
        document.head.appendChild(script);
      },
      particleStyle(i) {
        const size = Math.random() * 10 + 5;
        return {
          width: `${size}px`,
          height: `${size}px`,
          left: `${Math.random() * 100}%`,
          top: `${Math.random() * 100}%`,
          opacity: Math.random() * 0.3 + 0.1,
          animationDelay: `${Math.random() * 5}s`
        };
      },
      initParticles() {
        this.particles = Array.from({ length: 30 }, (_, i) => this.particleStyle(i));
      },
      toggleTheme() {
        this.darkMode = !this.darkMode;
        document.documentElement.setAttribute('data-theme', this.darkMode ? 'dark' : 'light');
      },
      fullscreenChat() {
        const iframe = document.querySelector('.chat-iframe');
        if (!document.fullscreenElement) {
          iframe.requestFullscreen().catch(err => {
            console.error(`Error attempting to enable fullscreen: ${err.message}`);
          });
        } else {
          document.exitFullscreen();
        }
      }
    }
  }
  </script>
  
  <style scoped>
  /* Base Variables */
  :root {
    --primary-color: #6c5ce7;
    --secondary-color: #a29bfe;
    --accent-color: #fd79a8;
    --text-color: #2d3436;
    --bg-color: #f9f9f9;
    --card-bg: rgba(255, 255, 255, 0.9);
    --glass-bg: rgba(255, 255, 255, 0.25);
    --shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
  }
  
  [data-theme="dark"] {
    --primary-color: #a29bfe;
    --secondary-color: #6c5ce7;
    --text-color: #f9f9f9;
    --bg-color: #1a1a2e;
    --card-bg: rgba(26, 26, 46, 0.9);
    --glass-bg: rgba(30, 30, 60, 0.25);
    --shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
  }
  
  /* Base Styles */
  .ai-assistant-container {
    position: relative;
    min-height: 100vh;
    background: var(--bg-color);
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 2rem;
    overflow: hidden;
    transition: background 0.5s ease;
  }
  
  /* Particles Animation */
  .particles {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    z-index: 0;
  }
  
  .particle {
    position: absolute;
    background: var(--primary-color);
    border-radius: 50%;
    filter: blur(1px);
    animation: float 15s infinite ease-in-out;
  }
  
  @keyframes float {
    0%, 100% { transform: translateY(0) translateX(0); }
    25% { transform: translateY(-20px) translateX(10px); }
    50% { transform: translateY(10px) translateX(-10px); }
    75% { transform: translateY(-10px) translateX(20px); }
  }
  
  /* Main Card */
  .ai-assistant-card {
    position: relative;
    width: 100%;
    max-width: 900px;
    background: var(--card-bg);
    border-radius: 20px;
    box-shadow: var(--shadow);
    backdrop-filter: blur(10px);
    z-index: 1;
    overflow: hidden;
    transition: all 0.5s ease;
  }
  
  /* Header Styles */
  .assistant-header {
    padding: 1.5rem 2rem;
    background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
    color: white;
    position: relative;
  }
  
  .glow::after {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 2px;
    background: var(--accent-color);
    box-shadow: 0 0 10px var(--accent-color), 0 0 20px var(--accent-color);
    animation: pulse 2s infinite;
  }
  
  @keyframes pulse {
    0%, 100% { opacity: 0.7; }
    50% { opacity: 1; }
  }
  
  .header-content {
    display: flex;
    align-items: center;
    gap: 1rem;
  }
  
  .logo-container {
    position: relative;
    width: 50px;
    height: 50px;
  }
  
  .logo-icon {
    font-size: 2.5rem;
    position: relative;
    z-index: 2;
    color: white;
  }
  
  .logo-glow {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: var(--accent-color);
    border-radius: 50%;
    filter: blur(10px);
    opacity: 0.7;
    animation: pulse 3s infinite alternate;
  }
  
  .header-text h2 {
    margin: 0;
    font-size: 1.5rem;
    font-weight: 700;
  }
  
  .header-text p {
    margin: 0.25rem 0 0;
    font-size: 0.9rem;
    opacity: 0.9;
  }
  
  .header-decoration {
    margin-top: 1rem;
  }
  
  .decoration-line {
    height: 2px;
    background: rgba(255, 255, 255, 0.2);
  }
  
  .decoration-dots {
    display: flex;
    gap: 6px;
    margin-top: 8px;
  }
  
  .decoration-dots span {
    display: block;
    width: 6px;
    height: 6px;
    background: white;
    border-radius: 50%;
    opacity: 0.6;
  }
  
  /* Chat Container */
  .chat-container-glass {
    height: 500px;
    margin: 1.5rem;
    background: var(--glass-bg);
    border-radius: 15px;
    backdrop-filter: blur(5px);
    border: 1px solid rgba(255, 255, 255, 0.1);
    overflow: hidden;
    box-shadow: inset 0 0 10px rgba(0, 0, 0, 0.05);
  }
  
  .chat-iframe-container {
    width: 100%;
    height: 100%;
  }
  
  .chat-iframe {
    border: none;
    border-radius: 15px;
  }
  
  /* FAB Buttons */
  .fab-container {
    position: absolute;
    top: 1rem;
    right: 1rem;
    display: flex;
    gap: 0.5rem;
    z-index: 10;
  }
  
  .fab-button {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.2);
    backdrop-filter: blur(5px);
    border: none;
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.3s ease;
  }
  
  .fab-button:hover {
    background: rgba(255, 255, 255, 0.3);
    transform: translateY(-2px);
  }
  
  .fab-button ion-icon {
    font-size: 1.2rem;
  }
  
  /* Status Bar */
  .status-bar {
    display: flex;
    justify-content: space-around;
    padding: 1rem;
    background: rgba(0, 0, 0, 0.05);
    border-top: 1px solid rgba(0, 0, 0, 0.1);
  }
  
  .status-item {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.8rem;
    color: var(--text-color);
    opacity: 0.8;
  }
  
  .status-item ion-icon {
    font-size: 1rem;
  }
  
  /* Responsive Design */
  @media (max-width: 768px) {
    .ai-assistant-container {
      padding: 1rem;
    }
    
    .assistant-header {
      padding: 1rem;
    }
    
    .chat-container-glass {
      height: 400px;
      margin: 1rem;
    }
    
    .status-bar {
      flex-direction: column;
      gap: 0.5rem;
      align-items: center;
    }
  }
  </style>