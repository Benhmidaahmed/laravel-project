<template>
  <div class="auth-wrapper">
    <div class="container" id="container">
      <div class="form-container sign-up-container">
        <form @submit.prevent="handleRegister">
          <!-- Sélecteur de rôle -->
          <div class="role-selector">
            <button type="button" 
                    :class="{ active: userType === 'student' }"
                    @click="userType = 'student'">
              STUDENT
            </button>
            <button type="button"
                    :class="{ active: userType === 'psychologist' }"
                    @click="userType = 'psychologist'">
              PSYCHOLOGIST
            </button>
          </div>

          <!-- Champs communs -->
          <input v-model="registerData.first_name" type="text" placeholder="First name" required>
          <input v-model="registerData.last_name" type="text" placeholder="Last name" required>
          <input v-model="registerData.email" type="email" placeholder="Email" required>
          <input v-model="registerData.password" type="password" placeholder="Password" required>
          <input v-model="registerData.password_confirmation" type="password" placeholder="Confirm Password" required>
          <input v-model="registerData.num_tel" type="tel" placeholder="Phone number" required>
          <div class="form-group">
            <input
              type="file"
              id="profileImage"
              accept="image/*"
              @change="onFileChange"
            />
          </div>

          <!-- Champs spécifiques étudiants -->
          <div v-if="userType === 'student'" class="specific-fields">
            <input v-model="registerData.student_card_number" 
                   type="text" 
                   placeholder="student ID number (ex: AB123456)" 
                   required>
            <input v-model="registerData.university" type="text" placeholder="University" required>
            <select v-model="registerData.study_level" required>
              <option value="" disabled>Select your level</option>
              <option value="L1">Licence 1</option>
              <option value="L2">Licence 2</option>
              <option value="L3">Licence 3</option>
              <option value="M1">Master 1</option>
              <option value="M2">Master 2</option>
            </select>
          </div>

          <!-- Champs spécifiques psychologues -->
          <div v-if="userType === 'psychologist'" class="specific-fields">
            <input v-model="registerData.adeli_number" 
                   type="text" 
                   placeholder="ADELI number" 
                   required>
            <input v-model="registerData.specialization" 
                   type="text" 
                   placeholder="Specialization" 
                   required>
          </div>

          <button type="submit" :disabled="isLoading">
            {{ isLoading ? 'Signing up...' : 'Sign up' }}
          </button>

          <p v-if="registerMessage" :class="messageClass" style="margin-bottom:10px">
            {{ registerMessage }}
          </p>
        </form>
      </div>

      <div class="form-container sign-in-container">
        <form @submit.prevent="handleLogin">
          <h1>Login to your account</h1>
          <input v-model="loginData.email" type="email" placeholder="Email" required>
          <input v-model="loginData.password" type="password" placeholder="Password" required>
          <a href="#">Forgot password?</a>
          <button type="submit" :disabled="isLoading">
            {{ isLoading ? 'Connexion...' : 'Log in' }}
          </button>
          <p v-if="loginMessage" :class="loginMessageClass">
            {{ loginMessage }}
          </p>
        </form>
      </div>
      
      <div class="overlay-container">
        <div class="overlay">
          <div class="overlay-panel overlay-left">
            <h1>Welcome back!</h1>
            <p>Sign in to access your account</p>
            <button class="ghost" id="signIn">Sign in</button>
          </div>
          <div class="overlay-panel overlay-right">
            <h1>New here?</h1>
            <p>Sign up and start your journey with us!</p>
            <div class="signup-options">
              <button class="ghost student" @click="selectUserType('student')">Student</button>
              <button class="ghost psychologist" @click="selectUserType('psychologist')">Psychologist</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, reactive, computed, onMounted } from 'vue';
import axios from 'axios';
import { useRouter } from 'vue-router';

const router = useRouter();
const profileImageFile = ref<File | null>(null);

// État du formulaire
const userType = ref<'student' | 'psychologist'>('student');
const isLoading = ref(false);

// Données de formulaire
const registerData = reactive<{
  first_name: string;
  last_name: string;
  email: string;
  password: string;
  password_confirmation: string;
  num_tel: string;
  roles: string;
  student_card_number: string;
  university: string;
  study_level: string;
  adeli_number: string;
  specialization: string;
  url_image: string;
}>({
  first_name: '',
  last_name: '',
  email: '',
  password: '',
  password_confirmation: '',
  num_tel: '', // Changé de phone_number à num_tel
  roles: 'STUDENT', // Changé de role à roles et en majuscules
  // Étudiant
  student_card_number: '',
  university: '',
  study_level: '',
  // Psychologue
  adeli_number: '',
  specialization: '',
  url_image:'' // Changé de profile_image à url_image
});

const loginData = reactive({
  email: '',
  password: ''
});

// Messages et états
const registerMessage = ref('');
const registerSuccess = ref(false);
const loginMessage = ref('');
const loginSuccess = ref(false);

// Classes CSS calculées
const messageClass = computed(() => ({
  'success': registerSuccess.value,
  'error': !registerSuccess.value
}));

const loginMessageClass = computed(() => ({
  'success': loginSuccess.value,
  'error': !loginSuccess.value
}));

function onFileChange(e: Event) {
  const files = (e.target as HTMLInputElement).files;
  if (files && files.length > 0) {
    profileImageFile.value = files[0];
    // Do not assign File to url_image, keep it for FormData only
  }
}

// Sélection du type d'utilisateur depuis l'overlay
const selectUserType = (type: 'student' | 'psychologist') => {
  userType.value = type;
  registerData.roles = type === 'student' ? 'STUDENT' : 'PSYCHOLOGIST'; // Utiliser roles et majuscules
  const container = document.getElementById('container');
  container?.classList.add('right-panel-active');
};

// Inscription
async function handleRegister() {
  try {
    isLoading.value = true;
    registerMessage.value = '';

    // Définir le rôle correctement en majuscules
    registerData.roles = userType.value === 'student' ? 'STUDENT' : 'PSYCHOLOGIST';

    const formData = new FormData();
    
    // Ajouter les données au FormData avec les bons noms de champs
    Object.entries(registerData).forEach(([key, value]) => {
      if (key === 'url_image') {
        // Append the file if selected
        if (profileImageFile.value) {
          formData.append('url_image', profileImageFile.value);
        }
      } else if (value !== null && value !== undefined) {
        formData.append(key, String(value));
      }
    });

    // Utiliser le bon endpoint API
    const response = await axios.post('/api/register', formData, {
      headers: {
        'Content-Type': 'multipart/form-data',
        'Accept': 'application/json'
      }
    });

    registerMessage.value = 'Inscription réussie ! Veuillez vous connecter.';
    registerSuccess.value = true;

    // Réinitialisation du formulaire
    setTimeout(() => {
      Object.keys(registerData).forEach(key => {
        registerData[key as keyof typeof registerData] = key === 'roles' ? 'STUDENT' : '' as any; // Conserver le rôle par défaut
      });
      profileImageFile.value = null;
      registerMessage.value = '';
      document.getElementById('container')?.classList.remove('right-panel-active');
    }, 3000);

  } catch (error: any) {
    let errorMessage = "Erreur lors de l'inscription";
    
    if (error.response) {
      if (error.response.data.errors) {
        errorMessage = Object.values(error.response.data.errors).flat().join('\n');
      } else if (error.response.data.message) {
        errorMessage = error.response.data.message;
      }
    }
    registerMessage.value = errorMessage;
    registerSuccess.value = false;
  } finally {
    isLoading.value = false;
  }
}

// Connexion
const handleLogin = async () => {
  try {
    isLoading.value = true;
    loginMessage.value = '';

    const response = await axios.post('/api/login', {
      email: loginData.email,
      password: loginData.password
    });

    // Store authentication data
   localStorage.setItem('token', response.data.token);
    localStorage.setItem('userRole', response.data.role);
    localStorage.setItem('userId', response.data.user_id);
    localStorage.setItem('first_name',response.data.user.first_name);
    localStorage.setItem('email',response.data.user.email);
    
    loginMessage.value = 'Login successful!';
    loginSuccess.value = true;

    // Redirect based on role
    setTimeout(() => {
      if (response.data.role === 'STUDENT') {
        router.push('/StudentPortal');
      } else if (response.data.role === 'PSYCHOLOGIST') {
        router.push('/dashboard');
      } else {
        router.push('/');
      }
    }, 1000);

  } catch (error: any) {
    let errorMessage = "Login error";
    
    if (error.response) {
      if (error.response.data.message) {
        errorMessage = error.response.data.message;
      } else if (error.response.status === 401) {
        errorMessage = "Invalid credentials";
      }
    } else if (error.request) {
      errorMessage = "Server connection error";
    } else {
      errorMessage = error.message;
    }

    loginMessage.value = errorMessage;
    loginSuccess.value = false;
  } finally {
    isLoading.value = false;
  }
};

// Initialisation de l'animation
onMounted(() => {
  const signUpButton = document.getElementById('signUp');
  const signInButton = document.getElementById('signIn');
  const container = document.getElementById('container');

  signUpButton?.addEventListener('click', () => {
    container?.classList.add('right-panel-active');
  });

  signInButton?.addEventListener('click', () => {
    container?.classList.remove('right-panel-active');
  });
});
</script>


<style scoped>
#container {
  background: #fff;
  border-radius: 10px;
  box-shadow: 0 14px 28px rgba(0,0,0,0.25),
              0 10px 10px rgba(0,0,0,0.22);
  position: relative;
  overflow: hidden;
  width: 768px;
  max-width: 100%;
  height: auto;         /* grow to fit */
}
.auth-wrapper {
  display: flex;
  justify-content: center;
  align-items: center;
  min-height: 100vh;
  background: #f6f5f7;
}
  /* Votre CSS existant reste inchangé */
  @import url("https://fonts.googleapis.com/css?family=Montserrat:400,800");
  *, *::before, *::after { box-sizing: border-box; }
  * {
    box-sizing: border-box;
  }
  
/* Boutons ghost */
.ghost {
  background-color: transparent;
  border-color: #fff;
  margin: 5px 0;
}
input, select {
  background-color: #eee;
  border: none;
  padding: 12px 15px;
  margin: 8px 0;
  width: 100%;
  border-radius: 4px;
}
.student {
  background-color: #4CAF50;
}

.psychologist {
  background-color: #9C27B0;
}
/* Boutons */
button {
  border-radius: 20px;
  border: 1px solid #0056b3;
  background-color: #0056b3;
  color: #fff;
  font-size: 12px;
  font-weight: bold;
  padding: 12px 45px;
  letter-spacing: 1px;
  text-transform: uppercase;
  transition: transform 80ms ease-in;
  cursor: pointer;
}

button:active {
  transform: scale(0.95);
}

button:focus {
  outline: none;
}

button:disabled {
  opacity: 0.7;
  cursor: not-allowed;
}
/* Animation */
.right-panel-active .sign-in-container {
  transform: translateX(100%);
}

.right-panel-active .sign-up-container {
  transform: translateX(100%);
  opacity: 1;
  z-index: 5;
  animation: show 0.6s;
}

.right-panel-active .overlay-container {
  transform: translateX(-100%);
}

.right-panel-active .overlay {
  transform: translateX(50%);
}

.right-panel-active .overlay-left {
  transform: translateX(0);
}

.right-panel-active .overlay-right {
  transform: translateX(20%);
}

@keyframes show {
  0%, 49.99% {
    opacity: 0;
    z-index: 1;
  }
  
  50%, 100% {
    opacity: 1;
    z-index: 5;
  }
}

/* Sélecteur de rôle */
.role-selector {
  display: flex;
  gap: 10px;
  margin-bottom: 15px;
  width: 100%;
}

.role-selector button {
  flex: 1;
  padding: 10px;
  margin: 0;
  background-color: #eee;
  color: #333;
  border: none;
}

.role-selector button.active {
  background-color: #0056b3;
  color: #fff;
}

/* Champs spécifiques */
.specific-fields {
  width: 100%;
  animation: fadeIn 0.3s;
}

@keyframes fadeIn {
  from { opacity: 0; transform: translateY(-10px); }
  to { opacity: 1; transform: translateY(0); }
}

/* Options d'inscription */
.signup-options {
  display: flex;
  flex-direction: column;
  width: 100%;
  gap: 10px;
}

/* Messages */
.success {
  color: #4CAF50;
}

.error {
  color: #F44336;
}

  
  h1 {
    font-weight: bold;
    margin: 0;
  }
  #aa {
    color: white;
  }
 
  
  h2 {
    text-align: center;
  }
  
  p {
    font-size: 14px;
    font-weight: 100;
    line-height: 20px;
    letter-spacing: 0.5px;
    margin: 20px 0 30px;
  }
  
  span {
    font-size: 12px;
  }
  #nn {
    color: white;
  }
  
  a {
    color: #333;
    font-size: 14px;
    text-decoration: none;
    margin: 15px 0;
  }
  
  button {
    border-radius: 20px;
    background-color: #0056b3;
    color: #ffffff;
    font-size: 12px;
    font-weight: bold;
    padding: 12px 45px;
    letter-spacing: 1px;
    text-transform: uppercase;
    transition: transform 80ms ease-in;
  }
  
  button:active {
    transform: scale(0.95);
  }
  
  button:focus {
    outline: none;
  }
  
  button.ghost {
    background-color: transparent;
    border-color: #ffffff;
  }
  
  form {
    background-color: #ffffff;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-direction: column;
    padding: 0 50px;
    height: 100%;
    text-align: center;
  }
  
  input {
    background-color: #eee;
    border: none;
    padding: 12px 15px;
    margin: 8px 0;
    width: 100%;
  }
  
  .container {
    background-color: #fff;
    border-radius: 10px;
    box-shadow: 0 14px 28px rgba(0, 0, 0, 0.25), 0 10px 10px rgba(0, 0, 0, 0.22);
    position: relative;
    overflow: hidden;
    width: 768px;
    max-width: 100%;
    min-height: 650px;
  }
  
  .form-container {
    position: absolute;
    top: 0;
    height: 100%;
    transition: all 0.6s ease-in-out;
  }
  
  .sign-in-container {
    left: 0;
    width: 50%;
    z-index: 2;
  }
  
  .container.right-panel-active .sign-in-container {
    transform: translateX(100%);
  }
  
  .sign-up-container {
    left: 0;
    width: 50%;
    opacity: 0;
    z-index: 1;
  }
  
  .container.right-panel-active .sign-up-container {
    transform: translateX(100%);
    opacity: 1;
    z-index: 5;
    animation: show 0.6s;
  }
  
  @keyframes show {
    0%,
    49.99% {
      opacity: 0;
      z-index: 1;
    }
  
    50%,
    100% {
      opacity: 1;
      z-index: 5;
    }
  }
  
  .overlay-container {
    position: absolute;
    top: 0;
    left: 50%;
    width: 50%;
    height: 100%;
    overflow: hidden;
    transition: transform 0.6s ease-in-out;
    z-index: 100;
  }
  
  .container.right-panel-active .overlay-container {
    transform: translateX(-100%);
  }
  
  .overlay {
    background: #0056b3;
    background-repeat: no-repeat;
    background-size: cover;
    background-position: 0 0;
    color: #ffffff;
    position: relative;
    left: -100%;
    height: 100%;
    width: 200%;
    transform: translateX(0);
    transition: transform 0.6s ease-in-out;
  }
  
  .container.right-panel-active .overlay {
    transform: translateX(50%);
  }
  
  .overlay-panel {
    position: absolute;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-direction: column;
    padding: 0 40px;
    text-align: center;
    top: 0;
    height: 100%;
    width: 50%;
    transform: translateX(0);
    transition: transform 0.6s ease-in-out;
  }
  
  .overlay-left {
    transform: translateX(-20%);
  }
  
  .container.right-panel-active .overlay-left {
    transform: translateX(0);
  }
  
  .overlay-right {
    right: 0;
    transform: translateX(0);
  }
  
  .container.right-panel-active .overlay-right {
    transform: translateX(20%);
  }
  
  .social-container {
    margin: 20px 0;
  }
  
  .social-container a {
    border: 1px solid #dddddd;
    border-radius: 50%;
    display: inline-flex;
    justify-content: center;
    align-items: center;
    margin: 0 5px;
    height: 40px;
    width: 40px;
  }
  
  /* Styles pour les messages */
  .success {
    color: green;
  }
  
  .error {
    color: red;
  }
  </style>
  