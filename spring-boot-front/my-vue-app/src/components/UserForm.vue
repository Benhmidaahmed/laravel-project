<template>
  <div class="dashboard-container">
    <div class="navigation">
      <ul>
        <li>
          <a href="#" @click.prevent="currentView = 'dashboard'">
            <span class="icon">
              <ion-icon name="laptop-sharp"></ion-icon>
            </span>
            <span class="title">UniWell</span>
          </a>
        </li>
        <li>
          <a
            href="#"
            @click.prevent="currentView = 'dashboard'"
            :class="{ hovered: currentView === 'dashboard' }"
          >
            <span class="icon">
              <ion-icon name="home-outline"></ion-icon>
            </span>
            <span class="title">Dashboard</span>
          </a>
        </li>
        <li>
          <a
            href="#"
            @click.prevent="currentView = 'students'"
            :class="{ hovered: currentView === 'students' }"
          >
            <span class="icon">
              <ion-icon name="people-outline"></ion-icon>
            </span>
            <span class="title">Students</span>
          </a>
        </li>
        <li>
          <a
            href="#"
            @click.prevent="currentView = 'messages'"
            :class="{ hovered: currentView === 'messages' }"
          >
            <span class="icon">
              <ion-icon name="chatbubble-outline"></ion-icon>
            </span>
            <span class="title">Messages</span>
          </a>
        </li>
        <li>
          <a
            href="#"
            @click.prevent="currentView = 'chatbot'"
            :class="{ hovered: currentView === 'chatbot' }"
          >
            <span class="icon">
              <ion-icon name="logo-reddit"></ion-icon>
            </span>
            <span class="title">Chat with AI</span>
          </a>
        </li>
        <!-- <li>
          <a
            href="#"
            @click.prevent="currentView = 'password'"
            :class="{ hovered: currentView === 'password' }"
          >
            <span class="icon">
              <ion-icon name="lock-closed-outline"></ion-icon>
            </span>
            <span class="title">Password</span>
          </a>
        </li> -->
        <li>
          <a href="#" @click.prevent="signOut">
            <span class="icon">
              <ion-icon name="log-out-outline"></ion-icon>
            </span>
            <span class="title">Sign Out</span>
          </a>
        </li>
      </ul>
    </div>

    <div class="main">
      <div class="topbar">
        <div class="toggle" @click="toggleMenu">
          <ion-icon name="menu-outline"></ion-icon>
        </div>
        <div class="search">
          <label>
            <input
              type="text"
              placeholder="Search here"
              v-model="searchQuery"
              @keyup.enter="performSearch"
            />
          </label>
        </div>
        <div class="user" @click="toggleUserDropdown">
          <div class="dropdown" v-if="showUserDropdown">
            <a href="#" @click.prevent>Profile</a>
            <a href="#" @click.prevent>Settings</a>
            <a href="#" @click.prevent="signOut">Logout</a>
          </div>
        </div>
      </div>

      <!-- Dashboard View -->
      <div v-if="currentView === 'dashboard'">
        <div class="details">
          <div class="recentOrders">
            <div class="cardHeader">
              <h2>Appointments</h2>
              <a href="#" class="btn" @click.prevent="currentView = 'allAppointments'">View All</a>
            </div>
            <table class="appointments-table">
              <thead>
                <tr>
                  <td>Name</td>
                  <td>E-mail</td>
                  <td>Time</td>
                  <td>Status</td>
                </tr>
              </thead>
              <tbody>
                <tr v-for="appointment in limitedAppointments" :key="appointment.id">
                  <td>{{ appointment.client }}</td>
                  <td>{{ appointment.email }}</td>
                  <td>{{ formatTime(appointment.date) }}</td>
                  <td>
                    <span :class="'status ' + (appointment.status || 'pending')">
                      {{ appointment.status || 'Pending' }}
                    </span>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>

          <div class="recentCustomers">
            <div class="cardHeader">
              <h2>Students List</h2>
            </div>
            <table>
              <tr
                v-for="student in recentStudents"
                :key="student.id"
                @click="viewStudent(student.id)"
              >
                <td width="60px">
                  <div class="imgBx">
                    <img :src="getImageUrl(student.avatar)" :alt="student.name" class="student-avatar" />
                  </div>
                </td>
                <td>
                  <h4>
                    {{ student.name }}<br />
                    <span>{{ student.email }}</span>
                  </h4>
                </td>
              </tr>
            </table>
          </div>
        </div>
      </div>

      <!-- Student Detail View -->
      <div v-if="currentView === 'student-detail' && selectedStudent" class="student-detail-view">
        <div class="cardHeader">
          <h2>Student Details</h2>
          <button @click="currentView = 'students'" class="back-btn">Back to Students</button>
        </div>
        <div class="student-profile">
          <div class="profile-header">
            <div class="avatar">
                          <img
              :src="getImageUrl(selectedStudent.urlImage)"
              :alt="`${selectedStudent.firstName} ${selectedStudent.lastName}`"
              class="detail-avatar"
            />
            </div>
            <div class="profile-info">
              <h1>{{ selectedStudent.firstName }} {{ selectedStudent.lastName }}</h1>
              <p class="email">{{ selectedStudent.email }}</p>
            </div>
          </div>
          <div class="profile-details">
            <div class="detail-card">
              <h3>Personal Information</h3>
              <div class="detail-row">
                <span class="detail-label">First Name:</span>
                <span class="detail-value">{{ selectedStudent.firstName }}</span>
              </div>
              <div class="detail-row">
                <span class="detail-label">Last Name:</span>
                <span class="detail-value">{{ selectedStudent.lastName }}</span>
              </div>
              <div class="detail-row">
                <span class="detail-label">Email:</span>
                <span class="detail-value">{{ selectedStudent.email }}</span>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- All Students View -->
      <div v-if="currentView === 'students'" class="students-view">
        <div class="cardHeader">
          <h2>All Students</h2>
          <button @click="currentView = 'dashboard'" class="back-btn">Back to Dashboard</button>
        </div>
        <table class="students-table">
          <thead>
            <tr>
              <th>Photo</th>
              <th>Name</th>
              <th>Email</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="student in allStudents" :key="student.id">
              <td>
                <div class="imgBx">
                                  <img
                  :src="getImageUrl(student.urlImage)"
                  :alt="student.firstName"
                  class="student-avatar"
                />
                </div>
              </td>
              <td>{{ student.firstName }} {{ student.lastName }}</td>
              <td>{{ student.email }}</td>
              <td>
                <button @click="viewStudent(student.id)" class="view-btn">View</button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
      <!-- All Appointments View -->
      <div v-if="currentView === 'allAppointments'" class="all-appointments-view">
        <div class="cardHeader">
          <h2>All Appointments</h2>
          <button @click="currentView = 'dashboard'" class="back-btn" style="margin-top:10px">Back to Dashboard</button>
          
        </div>
        <table class="appointments-table full-view">
          <thead>
            <tr>
              <th>Name</th>
              <th>E-mail</th>
              <th>Time</th>
              <th>Status</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="appointment in appointments" :key="appointment.id">
              <td>{{ appointment.client }}</td>
              <td>{{ appointment.email }}</td>
              <td>{{ formatTime(appointment.date) }}</td>
              <td>
                <span :class="'status ' + (appointment.status || 'pending')">
                  {{ appointment.status || 'Pending' }}
                </span>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
<!-- ==================== Messages View ==================== -->
<div v-if="currentView === 'messages'" class="view-content messages-view">
  <div class="messages-container">
    <!-- Left: Contacts list -->
    <aside class="contacts-list">
      <h5>Students</h5>
      <ul>
        <li
          v-for="stu in allStudents"
          :key="stu.id"
          :class="{ active: selectedContact?.id === stu.id }"
          @click="loadConversation(stu)"
        >
          <img :src="getImageUrl(stu.urlImage)" alt="" class="avatar" />
          <span class="name">{{ stu.firstName }} {{ stu.lastName }}</span>
        </li>
      </ul>
    </aside>

    <!-- Right: Chat panel -->
    <section class="chat-panel">
      <div v-if="!selectedContact" class="empty-state">
        Select a student to start chatting
      </div>
      <div v-else class="chat-inner">
        <!-- Header -->
        <header class="chat-header">
          <img :src="getImageUrl(selectedContact.urlImage)" alt="" class="avatar" />
          <h5>{{ selectedContact.firstName }} {{ selectedContact.lastName }}</h5>
        </header>
        <!-- Message history -->
        <div class="chat-body">
          <div
            v-for="msg in conversation"
            :key="msg.id"
            :class="['message', msg.sender.id === currentUserId ? 'sent' : 'received']"
          >
            <p>{{ msg.content }}</p>
            <span class="ts">{{ formatTime(msg.timestamp) }}</span>
          </div>
        </div>
        <!-- Input bar -->
        <footer class="chat-input">
          <input
            v-model="newMessageText"
            @keyup.enter="sendMessage"
            placeholder="Type a message…"
          />
          <button @click="sendMessage">Send</button>
        </footer>
      </div>
    </section>
  </div>
</div>

      <!-- Chatbot View -->
      <div v-if="currentView === 'chatbot'" class="chatbot-container">
        <iframe
          src="https://www.chatbase.co/chatbot-iframe/lR8CFH6F6R50cktx2LDnc"
          width="100%"
          style="height: 70%; min-height: 550px"
          frameborder="0"
        ></iframe>
        <button @click="currentView = 'dashboard'" class="back-btn">Back to Dashboard</button>
      </div>

      <!-- Generic View for other menu items
      <div v-if="isGenericView" class="generic-view">
        <h2>{{ currentView.charAt(0).toUpperCase() + currentView.slice(1) }}</h2>
        <p>This section is under development.</p>
        <button @click="currentView = 'dashboard'" class="back-btn">Back to Dashboard</button>
      </div> -->
    </div>
  </div>
</template>

<script>
import axios from 'axios'   
axios.defaults.baseURL = 'http://localhost:8084'
    axios.defaults.headers.common['Authorization'] = `Bearer ${localStorage.getItem('token')}`
export default {
  data() {
    return {
      currentView: 'dashboard',
      searchQuery: '',
      showUserDropdown: false,
      selectedStudent: null,
      allStudents: [],
      recentStudents: [],
      appointments: [],
      currentUserId: Number(localStorage.getItem('userId')), 
      selectedContact: null,
      conversation: [],
      newMessageText: ''
     
    };
  },
  computed: {
    limitedAppointments() {
      return this.appointments.slice(0, 5);
    },
    isGenericView() {
      return !['dashboard', 'students', 'student-detail', 'allAppointments', 'chatbot', 'messages'].includes(this.currentView);
    }
  },
  methods: {
    async loadConversation(student) {
      this.selectedContact = student
        // immediately switch the UI into your messages view
  this.currentView = 'messages'

      try {
        const payload = {
          user1Id: this.currentUserId,
          user2Id: student.id
        }
        const { data } = await axios.post('/api/messages/conversation', payload)
        this.conversation = data
      } catch (e) {
        console.error('Error loading conversation', e)
      }
    },

    async sendMessage() {
      console.log('sendMessage() called', { 
     to: this.selectedContact, 
     text: this.newMessageText 
  });
      if (!this.selectedContact || !this.newMessageText.trim()) return
      try {
        const payload = {
          senderId: this.currentUserId,
          receiverId: this.selectedContact.id,
          message: this.newMessageText
        };
        console.log('→ payload:', payload);
        await axios.post('/api/messages/send', payload)
        this.newMessageText = ''
        // reload so you see your new message
        await this.loadConversation(this.selectedContact)
      } catch (e) {
        console.error('Error sending message', e)
      }
    },
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
    async fetchAllStudents() {
      try {
        const response = await fetch("http://localhost:8084/api/users/students");
        this.allStudents = await response.json();
        this.prepareRecentStudents();
      } catch (error) {
        console.error("Error fetching students:", error);
        this.allStudents = [];
        this.recentStudents = [];
      }
    },
    prepareRecentStudents() {
      this.recentStudents = this.allStudents.slice(0, 5).map(student => ({
        id: student.id,
        name: `${student.firstName} ${student.lastName}`,
        email: student.email,
        avatar: this.getImageUrl(student.urlImage)
      }));
    },
    async fetchAppointments() {
      try {
        const response = await fetch("http://localhost:8084/api/appointments");
        this.appointments = await response.json();
      } catch (error) {
        console.error("Error fetching appointments:", error);
        this.appointments = [];
      }
    },
    viewStudent(id) {
      this.selectedStudent = this.allStudents.find(student => student.id === id);
      if (this.selectedStudent) {
        this.currentView = 'student-detail';
      }
    },
    formatTime(dateString) {
      if (!dateString) return 'N/A';
      return new Date(dateString).toLocaleString('fr-FR');
    },
    toggleMenu() {
      const navigation = document.querySelector(".navigation");
      const main = document.querySelector(".main");
      navigation.classList.toggle("active");
      main.classList.toggle("active");
    },
    toggleUserDropdown() {
      this.showUserDropdown = !this.showUserDropdown;
    },
    performSearch() {
      if (this.searchQuery.trim()) {
        console.log("Searching for:", this.searchQuery);
        // Implémentez ici la logique de recherche
      }
    },
    signOut() {
      localStorage.removeItem('token');
      if (window.caches) {
    caches.keys().then(names => {
      names.forEach(name => caches.delete(name));
    });
  }
      window.location.replace('/');
      // Redirigez vers la page de login si nécessaire
    }
  },
  async mounted() {
    await Promise.all([
      this.fetchAllStudents(),
      this.fetchAppointments()
    ]);
    console.log("Initial data loaded");
    
  }
};
</script>
<style scoped >

.messages-container {
  display: flex;
  height: calc(100vh - 160px); /* adjust if your topbar is taller */
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
.chat-inner {
  display: flex;
  flex-direction: column;
  height: 100%;
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
  padding: 0.5rem 0.75rem;
  border-radius: 16px;
  position: relative;
  word-break: break-word;
}
.message.sent {
  background: #4a76a8;
  color: #fff;
  margin-left: auto;
  border-bottom-right-radius: 4px;
}
.message.received {
  background: #fff;
  color: #333;
  margin-right: auto;
  border-bottom-left-radius: 4px;
}
.message .ts {
  display: block;
  font-size: 0.7rem;
  color: rgba(255,255,255,0.7);
  margin-top: 0.25rem;
  text-align: right;
}
.message.received .ts {
  color: rgba(0,0,0,0.45);
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

/* Student Detail View Styles */
.student-detail-view {
  padding: 20px;
}

.student-profile {
  background: var(--white);
  border-radius: 20px;
  box-shadow: var(--shadow);
  padding: 30px;
  margin-top: 20px;
}

.profile-header {
  display: flex;
  align-items: center;
  margin-bottom: 30px;
  padding-bottom: 20px;
  border-bottom: 1px solid rgba(0, 0, 0, 0.1);
}

.profile-header .avatar {
  width: 150px;
  height: 150px;
  border-radius: 50%;
  overflow: hidden;
  margin-right: 30px;
}

.profile-header .avatar img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.profile-info h1 {
  font-size: 2rem;
  color: var(--blue);
  margin-bottom: 5px;
}

.profile-info .email {
  color: var(--black2);
  font-size: 1.1rem;
}

.profile-details {
  display: grid;
  grid-template-columns: 1fr;
  gap: 20px;
}

.detail-card {
  background: var(--gray);
  padding: 20px;
  border-radius: 10px;
}

.detail-card h3 {
  color: var(--blue);
  margin-bottom: 15px;
  font-size: 1.3rem;
}

.detail-row {
  display: flex;
  margin-bottom: 10px;
}

.detail-label {
  font-weight: 600;
  color: var(--black1);
  width: 150px;
}

.detail-value {
  color: var(--black2);
  flex: 1;
}

/* Responsive adjustments */
@media (max-width: 768px) {
  .profile-header {
    flex-direction: column;
    text-align: center;
  }
  
  .profile-header .avatar {
    margin-right: 0;
    margin-bottom: 20px;
  }
  
  .detail-row {
    flex-direction: column;
  }
  
  .detail-label {
    width: 100%;
    margin-bottom: 5px;
  }
}
.students-view {
  padding: 20px;
}

.students-table {
  width: 100%;
  border-collapse: collapse;
  margin-top: 20px;
}

.students-table th,
.students-table td {
  padding: 12px 15px;
  text-align: left;
  border-bottom: 1px solid rgba(0, 0, 0, 0.1);
}

.students-table th {
  font-weight: 600;
  color: var(--blue);
  background-color: rgba(42, 33, 133, 0.05);
}

.students-table tbody tr:hover {
  background: rgba(42, 33, 133, 0.1);
}

.students-table .imgBx {
  width: 40px;
  height: 40px;
  border-radius: 50%;
  overflow: hidden;
}

.students-table .imgBx img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.view-btn {
  padding: 8px 16px;
  background: var(--blue);
  color: white;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  transition: var(--transition);
}

.view-btn:hover {
  background: #1a1668;
}
.appointments-table {
  table-layout: auto; /* Allow columns to adjust based on content */
  width: 100%; /* Ensure the table takes full width */
}

.appointments-table td:nth-child(2), /* Email column */
.appointments-table th:nth-child(2) {
  white-space: normal; /* Allow wrapping of email text */
  word-break: break-word; /* Break long words if necessary */
  max-width: 300px; /* Set a reasonable max width for the email column */
}

.appointments-table td:nth-child(3), /* Time column */
.appointments-table th:nth-child(3) {
  white-space: nowrap; /* Prevent wrapping for the time column */
  text-align: center; /* Center-align the time column */
}

.appointments-table td:nth-child(2) {  /* Email column */
  padding-right: 40px; /* Adds space after email column */
}

#app > div,
#app > nav,
#app > div > div {
  margin: 0;
  padding: 0;
}
nav {
  margin: 0;
  padding: 0;
  height: 0;
}



.dashboard-container {
  position: relative;
  width: 100%;
  margin: 0;
  padding: 0;
  top: 0;
}




/* =============== Navigation ================ */
.navigation {
  position: fixed;
  width: 300px;
  height: 100%;
  background: var(--blue);
  border-left: 10px solid var(--blue);
  transition: var(--transition);
  overflow: hidden;
  z-index: 1000;
  top: 0;
}
.navigation.active {
  width: 80px;
}
.navigation ul {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  padding-top: 0;
}
.navigation ul li {
  position: relative;
  width: 100%;
  list-style: none;
  border-top-left-radius: 30px;
  border-bottom-left-radius: 30px;
  margin-bottom: 5px;
}
.navigation ul li:hover,
.navigation ul li.hovered {
  background-color: var(--white);
}
.navigation ul li:nth-child(1) {
  margin-bottom: 40px;
  pointer-events: none;
}
.navigation ul li a {
  position: relative;
  display: block;
  width: 100%;
  display: flex;
  text-decoration: none;
  color: var(--white);
  transition: var(--transition);
}
.navigation ul li:hover a,
.navigation ul li.hovered a {
  color: var(--blue);
}
.navigation ul li a .icon {
  position: relative;
  display: block;
  min-width: 60px;
  height: 60px;
  line-height: 75px;
  text-align: center;
}
.navigation ul li a .icon ion-icon {
  font-size: 1.75rem;
}
.navigation ul li a .title {
  position: relative;
  display: block;
  padding: 0 10px;
  height: 60px;
  line-height: 60px;
  text-align: start;
  white-space: nowrap;
}
/* --------- curve outside ---------- */
.navigation ul li:hover a::before,
.navigation ul li.hovered a::before {
  content: "";
  position: absolute;
  right: 0;
  top: -50px;
  width: 50px;
  height: 50px;
  background-color: transparent;
  border-radius: 50%;
  box-shadow: 35px 35px 0 10px var(--white);
  pointer-events: none;
}
.navigation ul li:hover a::after,
.navigation ul li.hovered a::after {
  content: "";
  position: absolute;
  right: 0;
  bottom: -50px;
  width: 50px;
  height: 50px;
  background-color: transparent;
  border-radius: 50%;
  box-shadow: 35px -35px 0 10px var(--white);
  pointer-events: none;
}





.appointments-table {
  width: 100%;
  border-collapse: collapse;
  margin: 0;
  display: block;
  overflow: auto;
  table-layout: auto;

}

.appointments-table thead {
  display: table-header-group;;
  width: 100%;
  table-layout: fixed;
  position: sticky;
  top: 0;
  background: var(--white);
  z-index: 10;
  text-align: left;
}
.appointments-table tbody {
  display: table;
  width: 100%;
  table-layout: fixed;
}

.appointments-table tr {
  display: table-row-group;
  width: 100%;
  table-layout: fixed;
}

.appointments-table th,
.appointments-table td {
  padding: 12px 15px;
  text-align: left;
  vertical-align: middle;
}

.appointments-table th {
  font-weight: 600;
  color: var(--blue);
  background-color: rgba(42, 33, 133, 0.05);
  position: sticky;
  top: 0;
}

.appointments-table tbody tr {
  border-bottom: 1px solid rgba(0, 0, 0, 0.1);
}

.appointments-table tbody tr:last-child {
  border-bottom: none;
}

.appointments-table tbody tr:hover {
  background: var(--blue);
  color: var(--white);
}


.appointments-table thead {
  display: table;
  width: 100%;
  table-layout: fixed;
  position: sticky;
  top: 0;
  background: var(--white);
  z-index: 10;
}
/* ===================== Main ===================== */
.main {
  position: absolute;
  width: calc(100% - 300px);
  left: 300px;
  min-height: 100vh;
  background: var(--white);
  transition: var(--transition);
  padding: 0;
  top: 0;
  margin: 0;
}
.main.active {
  width: calc(100% - 80px);
  left: 80px;
}
.topbar {
  width: 100%;
  height: 60px;
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 0 20px;
  background: var(--white);
  box-shadow: var(--shadow);
  position: sticky;
  top: 0;
  z-index: 10;
  margin-top: 0;
}
.toggle {
  position: relative;
  width: 60px;
  height: 60px;
  display: flex;
  justify-content: center;
  align-items: center;
  font-size: 2.5rem;
  cursor: pointer;
  color: var(--blue);
  transition: var(--transition);
}
.toggle:hover {
  transform: scale(1.1);
}
.search {
  position: relative;
  width: 400px;
  margin: 0 10px;
}
.search label {
  position: relative;
  width: 100%;
}
.search label input {
  width: 100%;
  height: 40px;
  border-radius: 40px;
  padding: 5px 20px;
  padding-left: 35px;
  font-size: 16px;
  outline: none;
  border: 1px solid var(--black2);
  transition: var(--transition);
}
.search label input:focus {
  border-color: var(--blue);
  box-shadow: 0 0 5px rgba(42, 33, 133, 0.3);
}
.search label ion-icon {
  position: absolute;
  top: 10px;
  left: 10px;
  font-size: 1.2rem;
  color: var(--black2);
}
.user {
  position: relative;
  width: 40px;
  height: 40px;
  border-radius: 50%;
  overflow: hidden;
  cursor: pointer;
  transition: var(--transition);
}
.user:hover {
  transform: scale(1.1);
}
.user img {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  object-fit: cover;
}
.user .dropdown {
  position: absolute;
  top: 50px;
  right: 0;
  background: var(--white);
  border-radius: 8px;
  box-shadow: var(--shadow);
  width: 150px;
  overflow: hidden;
  display: flex;
  flex-direction: column;
  z-index: 100;
}
.user .dropdown a {
  padding: 10px 15px;
  text-decoration: none;
  color: var(--black1);
  transition: var(--transition);
}
.user .dropdown a:hover {
  background: var(--blue);
  color: var(--white);
}
/* ======================= Cards ====================== */
.cardBox {
  position: relative;
  width: 100%;
  padding: 20px;
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  grid-gap: 30px;
}
.cardBox .card {
  position: relative;
  background: var(--white);
  padding: 30px;
  border-radius: 20px;
  display: flex;
  justify-content: space-between;
  cursor: pointer;
  box-shadow: var(--shadow);
  transition: var(--transition);
}
.cardBox .card:hover {
  transform: translateY(-5px);
}
.cardBox .card .numbers {
  position: relative;
  font-weight: 500;
  font-size: 2.5rem;
  color: var(--blue);
}
.cardBox .card .cardName {
  color: var(--black2);
  font-size: 1.1rem;
  margin-top: 5px;
}
.cardBox .card .iconBx {
  font-size: 3.5rem;
  color: var(--black2);
}
.cardBox .card:hover {
  background: var(--blue);
}
.cardBox .card:hover .numbers,
.cardBox .card:hover .cardName,
.cardBox .card:hover .iconBx {
  color: var(--white);
}
/* ================== Order Details List ============== */
.details {
  display: grid;
  grid-template-columns: 2fr 1fr;
  gap: 30px;
  padding: 20px;
  align-items: start;
}
.recentOrders {
  position: relative;
  display: flex;
  flex-direction: column;
  background: var(--white);
  padding: 20px;
  box-shadow: var(--shadow);
  border-radius: 20px;
  height: 100%;
  overflow: hidden;
  align-items: flex-start;
  justify-content: flex-start;
}
.recentOrders th, 
.recentOrders td {
  padding: 12px 15px;
  text-align: left;
  vertical-align: top; /* Align content to top */
}
.recentOrders tbody tr:last-child {
  border-bottom: none;
}
.recentOrders .cardHeader {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 0; /* Remove bottom margin */
  padding: 0 0 10px 0; /* Only padding at bottom */
}

.recentOrders table {
  width: 100%;
  border-collapse: collapse;
  margin-top: 0;
}

.recentOrders table thead tr {
  border-bottom: 1px solid rgba(0, 0, 0, 0.1);
}
.recentOrders table thead th {
  font-weight: 600;
  padding: 12px 10px;
  color: var(--blue);
  text-align: left;
  top: 0;
}
.recentOrders table tbody tr {
  color: var(--black1);
  border-bottom: 1px solid rgba(0, 0, 0, 0.1);
  transition: var(--transition);
}

.recentOrders table tbody tr:last-child {
  border-bottom: none;
}

.recentOrders table tbody tr:hover {
  background: var(--blue);
  color: var(--white);
}

recentOrders table tbody td {
  padding: 12px 10px;
  vertical-align: middle;
}

/* Status Badges */
.status {
  padding: 6px 12px;
  border-radius: 4px;
  font-size: 14px;
  font-weight: 500;
  color: var(--white);
  display: inline-block;
}

.status.confirmed {
  background: #8de02c;
}

.status.pending {
  background: #e9b10a;
}

.status.cancelled {
  background: #f00;
}

.status.in-progress {
  background: #1795ce;
}
.details .recentOrders {
  position: relative;
  display: flex;
  min-height: 500px;
  background: var(--white);
  padding: 20px;
  box-shadow: var(--shadow);
  border-radius: 20px;
  
  
}
.details .cardHeader {
  display: flex;
  justify-content: space-between;
  align-items: flex-start;
  margin-bottom:0;
}
.cardHeader h2 {
  font-weight: 600;
  color: var(--blue);
}
.cardHeader .btn {
  position: relative;
  padding: 5px 10px;
  background: var(--blue);
  text-decoration: none;
  color: var(--white);
  border-radius: 6px;
  transition: var(--transition);
  margin-left:350px;
}
.cardHeader .btn:hover {
  background: #1a1668;
}
.details table {
  width: 100%;
  border-collapse: collapse;
  margin-top: 10px;
}
.details table thead td {
  font-weight: 600;
  padding: 12px 10px;
  border-bottom: 1px solid rgba(0, 0, 0, 0.1);
}
.details .recentOrders table tr {
  color: var(--black1);
  border-bottom: 1px solid rgba(0, 0, 0, 0.1);
  transition: var(--transition);
}
.details .recentOrders table tr:last-child {
  border-bottom: none;
}
.details .recentOrders table tr:hover {
  background: var(--blue);
  color: var(--white);
}
.details .recentOrders table tr td {
  padding: 12px 10px;
}
.details .recentOrders table tr td:last-child {
  text-align: end;
}
.details .recentOrders table tr td:nth-child(2) {
  text-align: end;
}
.details .recentOrders table tr td:nth-child(3) {
  text-align: center;
}
.status {
  padding: 2px 4px;
  border-radius: 4px;
  font-size: 14px;
  font-weight: 500;
  color: var(--white);
}
.status.delivered {
  background: #8de02c;
}
.status.pending {
  background: #e9b10a;
}
.status.return {
  background: #f00;
}
.status.inProgress {
  background: #1795ce;
}
.recentCustomers {
  position: relative;
  display: flex;
  flex-direction: column;
  min-height: 500px;
  padding: 20px;
  background: var(--white);
  box-shadow: var(--shadow);
  border-radius: 20px;
}
.recentCustomers .imgBx {
  position: relative;
  width: 40px;
  height: 40px;
  border-radius: 50px;
  overflow: hidden;
  transition: var(--transition);
}

.recentCustomers .imgBx:hover {
  transform: scale(1.1);
}

.recentCustomers .imgBx img {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  object-fit: cover;
}


.recentCustomers table {
  width: 100%;
  border-collapse: collapse;
  margin-top: 15px;
}

.recentCustomers table tr {
  vertical-align: top; /* Align content to top */
  border-bottom: 1px solid rgba(0, 0, 0, 0.1);
  transition: var(--transition);
}

.recentCustomers table tr td {
  padding: 12px 10px;
}

.recentCustomers table tr:last-child {
  border-bottom: none;
}


.recentCustomers table tr td h4 {
  font-size: 16px;
  font-weight: 500;
  line-height: 1.2rem;
  margin: 0;
}

.recentCustomers table tr td h4 span {
  font-size: 14px;
  color: var(--black2);
}
.recentCustomers table tr td span {
  font-size: 14px;
  color: var(--black2);
}
.recentCustomers table tr:hover {
  background: var(--blue);
  color: var(--white);
  cursor: pointer;
}
.recentCustomers table tr:hover td span {
  color: var(--white);
}

.recentCustomers table tr:hover td h4 span {
  color: var(--white);
}
.recentCustomers table tr:only-child {
  border-bottom: 1px solid rgba(0, 0, 0, 0.1);
}
.recentCustomers table tr:only-child td {
  padding-top: 12px;
  padding-bottom: 12px;
}
/* Form Styles */
.form-container {
  padding: 20px;
}

.form-card {
  background: var(--white);
  padding: 30px;
  border-radius: 20px;
  box-shadow: var(--shadow);
  max-width: 600px;
  margin: 20px auto;
}

.form-card h2 {
  color: var(--blue);
  margin-bottom: 20px;
  text-align: center;
}

.form-group {
  margin-bottom: 20px;
}

.form-group label {
  display: block;
  margin-bottom: 8px;
  color: var(--black1);
  font-weight: 500;
}

.form-group input {
  width: 100%;
  padding: 12px 15px;
  border: 1px solid var(--black2);
  border-radius: 8px;
  font-size: 16px;
  transition: var(--transition);
}

.form-group input:focus {
  border-color: var(--blue);
  box-shadow: 0 0 5px rgba(42, 33, 133, 0.3);
  outline: none;
}

.submit-btn {
  width: 100%;
  padding: 12px;
  background: var(--blue);
  color: var(--white);
  border: none;
  border-radius: 8px;
  font-size: 16px;
  cursor: pointer;
  transition: var(--transition);
  margin-top: 10px;
}

.submit-btn:hover {
  background: #1a1668;
}

.message {
  text-align: left;
  margin-top: 20px;
  padding: 10px;
  border-radius: 5px;
  background: #e1f5e1;
  color: #2e7d32;
  border-radius: 20px;
}

.view-content {
  padding: 30px;
  background: var(--white);
  border-radius: 20px;
  box-shadow: var(--shadow);
  margin: 20px;
  min-height: 70vh;
}

.view-content h2 {
  color: var(--blue);
  margin-bottom: 20px;
}

.back-btn {
  padding: 10px 20px;
  background: var(--blue);
  color: var(--white);
  border: none;
  border-radius: 8px;
  cursor: pointer;
  transition: var(--transition);
  margin-top: 20px;
}

.back-btn:hover {
  background: #1a1668;
}

/* ====================== Responsive Design ========================== */
@media (max-width: 1200px) {
  .cardBox {
    grid-template-columns: repeat(2, 1fr);
  }
}

@media (max-width: 991px) {
  .navigation {
    left: -300px;
  }

  .navigation.active {
    width: 300px;
    left: 0;
  }

  .main {
    width: 100%;
    left: 0;
  }

  .main.active {
    left: 300px;
  }

  .details {
    grid-template-columns: 1fr;
  }

  .search {
    width: 300px;
  }
}

@media (max-width: 768px) {
  .cardBox {
    grid-template-columns: repeat(1, 1fr);
  }

  .recentOrders {
    overflow-x: auto;
  }

  .search {
    width: 200px;
  }

  .status.inProgress {
    white-space: nowrap;
  }
}

@media (max-width: 480px) {
  .topbar {
    padding: 0 10px;
  }

  .search {
    width: 150px;
    margin: 0 5px;
  }

  .search label input {
    padding-left: 30px;
    font-size: 14px;
  }

  .cardHeader h2 {
    font-size: 20px;
  }

  .navigation {
    width: 100%;
    left: -100%;
    z-index: 1000;
    top: 0;
  }

  .navigation.active {
    width: 100%;
    left: 0;
  }

  .toggle {
    z-index: 10001;
  }

  .main.active .toggle {
    color: #fff;
    position: fixed;
    right: 0;
    left: initial;
  }

  .user {
    min-width: 40px;
  }
}
</style>
