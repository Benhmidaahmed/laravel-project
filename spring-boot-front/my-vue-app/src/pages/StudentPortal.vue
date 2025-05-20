<template>
  <div class="student-portal-container">
    <!-- ***** Preloader Start ***** -->
    <!-- <div id="js-preloader" class="js-preloader">
    <div class="preloader-inner">
      <span class="dot"></span>
      <div class="dots">
        <span></span>
        <span></span>
        <span></span>
      </div>
    </div>
  </div> -->
  <header class="header-area header-sticky wow slideInDown" data-wow-duration="0.75s" data-wow-delay="0s">
    <div class="container">
      <div class="row">
        <div class="col-12">
          <nav class="main-nav">
            <router-link to="/" class="logo">
  <h1 class="logo-text">UniWell</h1>
  <p class="logo-tagline">stronger minds, brighter future</p>
</router-link>
            <!-- ***** Logo Start ***** -->
            <!-- <a href="index.html" class="logo">
              <img src="/template/assets/images/logo.png" alt="Chain App Dev">
            </a> -->
            <!-- ***** Logo End ***** -->
            <!-- ***** Menu Start ***** -->
            <ul class="nav">
              <li class="scroll-to-section"><a href="#top" class="active">Home</a></li>
              <li class="scroll-to-section"><a href="#services">Services</a></li>
              <li class="scroll-to-section"><a href="#about">About</a></li>
              <li class="scroll-to-section"><a href="#pricing">Pyschologists</a></li>
              <li class="scroll-to-section"><a href="#newsletter">Newsletter</a></li>
              <li><div class="gradient-button"><a id="modal_trigger" href="#modal"><i class="fa fa-sign-in-alt"></i> Sign out </a></div></li> 
            </ul>        
            <a class='menu-trigger'>
                <span>Menu</span>
            </a>
            <!-- ***** Menu End ***** -->
          </nav>
        </div>
      </div>
    </div>
  </header>
  <!-- ***** Header Area End ***** -->
  
  <div id="modal" class="popupContainer" style="display:none;">
    <div class="popupHeader">
        <span class="header_title">Login</span>
        <span class="modal_close"><i class="fa fa-times"></i></span>
    </div>

    <section class="popupBody">
        <!-- Social Login -->
        <div class="social_login">
            <div class="">
                <a href="#" class="social_box fb">
                    <span class="icon"><i class="fab fa-facebook"></i></span>
                    <span class="icon_title">Connect with Facebook</span>

                </a>

                <a href="#" class="social_box google">
                    <span class="icon"><i class="fab fa-google-plus"></i></span>
                    <span class="icon_title">Connect with Google</span>
                </a>
            </div>

            <div class="centeredText">
                <span>Or use your Email address</span>
            </div>

            <div class="action_btns">
                <div class="one_half"><a href="#" id="login_form" class="btn">Login</a></div>
                <div class="one_half last"><a href="#" id="register_form" class="btn">Sign up</a></div>
            </div>
        </div>

        <!-- Username & Password Login form -->
        <div class="user_login">
            <form>
                <label>Email / Username</label>
                <input type="text" />
                <br />

                <label>Password</label>
                <input type="password" />
                <br />

                <div class="checkbox">
                    <input id="remember" type="checkbox" />
                    <label for="remember">Remember me on this computer</label>
                </div>

                <div class="action_btns">
                    <div class="one_half"><a href="#" class="btn back_btn"><i class="fa fa-angle-double-left"></i> Back</a></div>
                    <div class="one_half last"><a href="#" class="btn btn_red">Login</a></div>
                </div>
            </form>

            <a href="#" class="forgot_password">Forgot password?</a>
        </div>

        <!-- Register Form -->
        <div class="user_register">
            <form>
                <label>Full Name</label>
                <input type="text" />
                <br />
                <label>Email Address</label>
                <input type="email" />
                <br />
                <label>Password</label>
                <input type="password" />
                <br />
                <div class="checkbox">
                    <input id="send_updates" type="checkbox" />
                    <label for="send_updates">Send me occasional email updates</label>
                </div>
                <div class="action_btns">
                    <div class="one_half"><a href="#" class="btn back_btn"><i class="fa fa-angle-double-left"></i> Back</a></div>
                    <div class="one_half last"><a href="#" class="btn btn_red">Register</a></div>
                </div>
            </form>
        </div>
    </section>
</div>

  <div class="main-banner wow fadeIn" id="top" data-wow-duration="1s" data-wow-delay="0.5s">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <div class="row">
            <div class="col-lg-6 align-self-center">
              <div class="left-content show-up header-text wow fadeInLeft" data-wow-duration="1s" data-wow-delay="1s">
                <div class="row">
                  <div class="col-lg-12">
                    <!-- <h2>Get The Latest App From App Stores</h2> -->
                    <p><h3>Welcome to UniWell – Your Student Mental Health Companion</h3>
UniWell is a dedicated platform designed to support students' mental well-being. We offer a safe space to talk, access professional help, schedule therapy sessions, and connect with peers through forums. Whether you're feeling overwhelmed, anxious, or just need someone to talk to, UniWell is here to help you feel heard, supported, and empowered.

</p>
<!-- <div class="text-button">
  <router-link
    :to="{ name: 'AIAssistant' }"
    class="btn-link"
  >
    See more <i class="fa fa-arrow-right"></i>
  </router-link>
  white-button first-button scroll-to-section
</div> -->
                  </div>
                  <div class="col-lg-12">
                    <div class="white-button first-button scroll-to-section">
                      <a href="#/AIAssistant">Contact our AI Assistant <ion-icon name="logo-reddit"></ion-icon></a>
                    </div>
                  
                    <div class="white-button">
   <router-link :to="{ name:'StudentPortal', hash:'#pricing' }">
     Book an appointment
   </router-link>
 </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-6">
              <div class="right-image wow fadeInRight" data-wow-duration="1s" data-wow-delay="0.5s">
                <img  src="/template/assets/images/sliderr1.png" style="width: 550px; height: 200px;" alt="">
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div id="services" class="services section">
    <div class="container">
      <div class="row">
        <div class="col-lg-8 offset-lg-2">
          <div class="section-heading  wow fadeInDown" data-wow-duration="1s" data-wow-delay="0.5s">
            <h4 >Professional <em>Psychologists</em> for you</h4>
            <img src="/template/assets/images/heading-line-dec.png" alt="">
            <p>Our platform features a curated list of certified psychologists ready to support you. Browse profiles, read reviews, and choose the expert that best fits your needs—all in a few clicks.</p>
          </div>
        </div>
      </div>
    </div>
    <div class="container">
      <div class="row">
        <div class="col-lg-3">
          <div class="service-item first-service">
            <div class="icon"></div>
            <h4>Modify your profile-details</h4>
            <p>Keep your information up to date. Click here to update your informations.
</p>
            <div class="text-button">
              <a href="#">See more <i class="fa fa-arrow-right"></i></a>
            </div>
          </div>
        </div>
        <div class="col-lg-3">
          <div class="service-item second-service">
            <div class="icon"></div>
            <h4>List of psychologists</h4>
            <p>Browse our list of certified psychologists and choose the right support for you. Click here to view profiles, specialties, and availability.</p>
            <div class="text-button">
              <router-link
                :to="{ name: 'StudentPortal', hash: '#pricing' }"
                class="btn-link"
              >
                See more <i class="fa fa-arrow-right"></i>
              </router-link>
            </div>

                      </div>
        </div>
        <div class="col-lg-3">
          <div class="service-item third-service">
            <div class="icon"></div>
            <h4>Chat with AI</h4>
            <p>>Need quick support or someone to talk to anytime? Click here to start a private, judgment-free conversation with our intelligent chatbot—available 24/7.</p>
            <div class="text-button">
  <router-link
    :to="{ name: 'AIAssistant' }"
    class="btn-link"
  >
    See more <i class="fa fa-arrow-right"></i>
  </router-link>
</div>
          </div>
        </div>
        <div class="col-lg-3">
          <div class="service-item fourth-service">
            <div class="icon"></div>
            <h4>Forum &amp; private messages</h4>
            <p>access the forum and private messages. Share your thoughts, ask questions, and connect one-on-one with other students in a safe and supportive space.</p>
            <div class="text-button">
  <router-link
    :to="{ name: 'Forum' }"
    class="btn-link"
  >
    See more <i class="fa fa-arrow-right"></i>
  </router-link>
</div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div id="about" class="about-us section">
    <div class="container">
      <div class="row">
        <div class="col-lg-6 align-self-center">
          <div class="section-heading">
            <h4>About <em>What We Do</em> &amp; Who We Are</h4>
            <img src="/template/assets/images/heading-line-dec.png" alt="">
            <p>UniWell is your all-in-one wellness platform, designed to support your mental, physical and emotional wellbeing through expert resources, personalized tools and a caring community – helping you thrive in every aspect of life..</p>
          </div>
          <div class="row">
            <div class="col-lg-6">
              <div class="box-item">
                <h4><a href="#">Mission-Driven Support</a></h4>
                <p>UniWell is dedicated to empowering students with accessible tools and resources to prioritize mental, physical, and emotional wellness—because thriving starts from within.</p>
              </div>
            </div>
            <div class="col-lg-6">
              <div class="box-item">
                <h4><a href="#">Holistic Approach</a></h4>
                <p>We combine expert-backed guidance, community support, and personalized strategies to help you navigate stress, build resilience, and achieve balance in your daily life.</p>
              </div>
            </div>
            <div class="col-lg-6">
              <div class="box-item">
                <h4><a href="#">Tailored for You</a></h4>
                <p>Whether you're struggling with anxiety, burnout, or just need a productivity boost, our platform adapts to your unique needs with science-backed solutions.</p>
              </div>
            </div>
            <div class="col-lg-6">
              <div class="box-item">
                <h4><a href="#">Community & Connection</a></h4>
                <p>Join a network of peers and professionals who get it. Share experiences, find encouragement, and grow together in a safe, judgment-free space.</p>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-6">
          <div class="right-image">
            <img src="/template/assets/images/about-right-dec.png" alt="">
          </div>
        </div>
      </div>
    </div>
  </div>

    <!-- Dynamic Forum Threads Slider -->
    <div id="clients" class="the-clients" v-if="randomThreads.length">
      <div class="container">
        <div class="row">
          <div class="col-lg-8 offset-lg-2">
            <div class="section-heading">
              <h4>Check What <em>Students Discuss</em> On Our Forum</h4>
              <img src="/template/assets/images/heading-line-dec.png" alt="Decoration">
              <p>Explore real student conversations and find support through shared experiences.</p>
            </div>
          </div>
          <div class="col-lg-12">
            <div class="naccs">
              <div class="grid">
                <div class="row">

                  <!-- LEFT: Thread titles -->
                  <div class="col-lg-7 align-self-center">
                    <div class="menu">
                      <div
                        v-for="(thread, idx) in randomThreads"
                        :key="thread.id"
                        :class="[
                          { 'first-thumb': idx === 0, 'last-thumb': idx === randomThreads.length - 1 },
                          { active: idx === activeIndex }
                        ]"
                        @click="selectThread(idx)"
                      >
                        <div class="thumb">
                          <div class="row">
                            <div class="col-lg-4 col-sm-4 col-12">
                              <h4>{{ thread.title }}</h4>
                              <span class="date" v-if="thread.createdAt">{{ formatDate(thread.createdAt) }}</span>
                            </div>
                            <div class="col-lg-4 col-sm-4 d-none d-sm-block">
                              <span class="category">Posts: {{ thread.posts?.length || 0 }}</span>
                            </div>
                            <div class="col-lg-4 col-sm-4 col-12">
                              <i
                                class="fa fa-star"
                                v-for="i in 5"
                                :key="i"
                                :class="{ checked: i <= (thread.posts?.length || 0) }"
                              ></i>
                              <span class="rating">{{ (thread.posts?.length || 0).toFixed(1) }}</span>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <!-- RIGHT: Thread content panels -->
                  <div class="col-lg-5">
                    <ul class="nacc">
                      <li
                        v-for="(thread, idx) in randomThreads"
                        :key="thread.id"
                        :class="{ active: idx === activeIndex }"
                      >
                        <div class="thumb">
                          <div class="row">
                            <div class="col-lg-12">
                              <div class="client-content">
                                <img src="/template/assets/images/quote.png" alt="Quote">
                                <p>
                                  <!-- Show first post or fallback -->
                                  {{ thread.posts?.length ? thread.posts[0].content : 'No posts yet for this discussion.' }}
                                </p>
                              </div>
                              <div class="down-content">
                                <img
                                  :src="getImageUrl(thread.author.urlImage)"
                                  alt="Author"
                                  class="client-image"
                                >
                                <div class="right-content">
                                  <h6>{{ thread.author.username || thread.author.email }}</h6>
                                  <span>Post Author</span>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </li>
                    </ul>
                  </div>

                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- End Slider -->

  <div id="pricing" class="pricing-tables">
    <div class="container">
      <div class="row">
        <div class="col-lg-8 offset-lg-2">
          <div class="section-heading">
            <h4>Below, you’ll find our trusted network of partnered <em>Psychologists</em> ready to support you.</h4>
            <img src="/template/assets/images/heading-line-dec.png" alt="">
            <p>You’re not alone. Take the first step today—we’re here to help.</p>
          </div>
        </div>
        <div
         class="col-lg-4"
         v-for="psy in psychologists"
         :key="psy.id"
       >
         <div class="pricing-item-regular">
           <!-- you can swap to a different class if you like -->

           <!-- Avatar -->
           <div class="psy-icon" style="margin-bottom:10px">
             <img
               :src="getImageUrl(psy.urlImage)"
               :alt="psy.firstName + ' ' + psy.lastName"
             />
           </div>

           <!-- Name -->
           <h4>{{ psy.firstName }} {{ psy.lastName }}</h4>

           <!-- Specialization instead of price -->
          <span class="price">{{ psy.specialization }}</span>

           <!-- (Optional) Short bio or tagline -->
           <p class="bio">
             {{ psy.bio || 'No bio available.' }}
           </p>

           <!-- Action button -->
           <div class="border-button">
             <a href="#" @click.prevent="bookSession(psy.id)">
               Book a session
             </a>
           </div>
           <div class="border-button" style="margin-top: 10px;">
    <router-link
      :to="{ name: 'StudentChat', params: { psyId: psy.id } }"
      class="send-message-btn"
   >
      Send Message
    </router-link>
 </div>
         </div>
       </div>
      </div>
    </div>
  </div> 

  <footer id="newsletter">
    <div class="container">
      <div class="row">
        <div class="col-lg-8 offset-lg-2">
          <div class="section-heading">
            <h4>Join our mailing list to receive the news </h4>
          </div>
        </div>
        <div class="col-lg-6 offset-lg-3">
          <form id="search" action="#" method="GET">
            <div class="row">
              <div class="col-lg-6 col-sm-6">
                <fieldset>
                  <input type="address" name="address" class="email" placeholder="Email Address..." autocomplete="on" required>
                </fieldset>
              </div>
              <div class="col-lg-6 col-sm-6">
                <fieldset>
                  <button type="submit" class="main-button">Subscribe Now <i class="fa fa-angle-right"></i></button>
                </fieldset>
              </div>
            </div>
          </form>
        </div>
      </div>
      <div class="row">
        <div class="col-lg-3">
          <div class="footer-widget">
            <h4>Contact Us</h4>
            <p>Bizerte - Bizerte Nord Avenue 7 Novembre - Bizerte
            </p>
            <p><a href="#">+216 92530813</a></p>
            <p><a href="#">info.uniwell@iset-r.bizerte.tn</a></p>
          </div>
        </div>
        <div class="col-lg-3">
          <div class="footer-widget">
            <h4>About Us</h4>
            <ul>
              <li><a href="#">Home</a></li>
              <li><a href="#">Services</a></li>
              <li><a href="#">About</a></li>
              <li><a href="#">Testimonials</a></li>
              
            </ul>
            <ul>
              <li><a href="#">About</a></li>
              <li><a href="#">Testimonials</a></li>
              
            </ul>
          </div>
        </div>
        <div class="col-lg-3">
          <div class="footer-widget">
            <h4>Useful Links</h4>
            <ul>
              <li><a href="https://findahelpline.com/i/iasp">Crisis helpline</a></li>
              <li><a href="https://www.nami.org/">National alliance on mental illness</a></li>
              
            </ul>
            <ul>
              <li><a href="https://www.mind.org.uk/">Anxiety & Depression Toolkit </a></li>
              <li><a href="https://www.headspace.com/studentplan">Headspace for Students</a></li>
            
            </ul>
          </div>
        </div>
        <div class="col-lg-3">
          <div class="footer-widget">
            
            
            <p>Stronger minds, brighter futures.</p>
          </div>
        </div>
        <div class="col-lg-12">
          <div class="copyright-text">
            <p>Copyright © 2025 DSI22. All Rights Reserved. 
          </p>
          </div>
        </div>
      </div>
    </div>
  </footer>

  
</div>

</template>

<script>
import axios from 'axios';
export default {
  name: "StudentPortal",
  data(){
    return{
      psychologists: [],
      threads: [],
      randomThreads: [],
      activeIndex: 0,
    };
  },
  computed:{
    selectedThreadContent() {
      const thread = this.randomThreads[this.activeIndex];
      // display first post content or a fallback message
      return thread.posts && thread.posts.length
        ? thread.posts[0].content
        : 'No posts yet in this thread.';
    }
  }
  ,
  mounted() {
    axios.get('http://localhost:8084/api/psychologists')
      .then(({ data }) => {
      this.psychologists = data.map(p => ({
        ...p,
        firstName : p.first_name,
        lastName  : p.last_name,
        urlImage  : p.url_image,
        bio : p.bio,
      }));
    })
      .catch(error => {
        console.error("There was an error fetching the psychologists!", error);
      });
    this.loadResources();
     // load random threads
     axios.get('http://localhost:8084/api/forum/threads')
      .then(({ data }) => {
        this.threads = data;
        this.randomThreads = this.shuffle(data).slice(0, 5);
      })
      .catch(err => console.error('Error fetching forum threads:', err));

  },
  methods: {
    selectThread(idx) {
      this.activeIndex = idx;
    },
    shuffle(arr) {
      const a = arr.slice();
      for (let i = a.length - 1; i > 0; i--) {
        const j = Math.floor(Math.random() * (i + 1));
        [a[i], a[j]] = [a[j], a[i]];
      }
      return a;
    },
    getImageUrl(path) {
      if (!path) return '/default-avatar.png';
      // If it's already an absolute URL, just use it:
      if (path.startsWith('http')) return path;
      // Otherwise, prefix your backend origin:
      return `http://localhost:8084${path}`;
    },

    bookSession(psyId) {
    // redirect to booking form for the selected psychologist
    this.$router.push({ name: 'form', params: { psyId } });
  },
    hidePreloader() {
  const preloader = document.getElementById('js-preloader');
  if (preloader) {
    preloader.style.display = 'none';
  }
},
    async loadResources() {
      // Load CSS first
      await this.loadCSS([
        "https://fonts.googleapis.com/css2?family=Roboto:wght@100;300;400;500;700;900&display=swap",
        "https://use.fontawesome.com/releases/v5.8.1/css/all.css",
        "/template/vendor/bootstrap/css/bootstrap.min.css",
        "/template/assets/css/templatemo-chain-app-dev.css",
        "/template/assets/css/animated.css",
        "/template/assets/css/owl.css"
      ]);
      
      // Then load scripts
      this.loadScripts([
        "/template/vendor/jquery/jquery.min.js",
        "/template/vendor/bootstrap/js/bootstrap.bundle.min.js",
        "/template/assets/js/owl-carousel.js",
        "/template/assets/js/animation.js",
        "/template/assets/js/imagesloaded.js",
        "/template/assets/js/popup.js",
        "/template/assets/js/custom.js"
      ]);
    },
    loadCSS(urls) {
      return Promise.all(
        urls.map(url => {
          return new Promise((resolve) => {
            if (document.querySelector(`link[href="${url}"]`)) {
              return resolve();
            }
            const link = document.createElement('link');
            link.rel = 'stylesheet';
            link.href = url;
            link.onload = resolve;
            document.head.appendChild(link);
          });
        })
      );
    },
    loadScripts(urls) {
      urls.forEach(src => {
        if (!document.querySelector(`script[src="${src}"]`)) {
          const script = document.createElement('script');
          script.src = src;
          script.async = false;
          document.body.appendChild(script);
        }
      });
    },
    
  }
};
</script>
<style  >
.header-area .main-nav {
  display: flex;
  align-items: center;
  justify-content: space-between;
}

/* your logo wrapper */
.header-area .main-nav .logo {
  display: flex;
  flex-direction: column;
  align-items: flex-start;
  margin: 0;    /* kill any default browser margins */
  padding: 0;
  z-index: 10;  /* keep it above any background shapes */
}

/* the big “UniWell” */
.header-area .main-nav .logo-text {
  margin-top: 10px;
  font-size: 2rem;     /* tweak to taste */
  line-height: 1;
  color: #0cace6;         /* or whatever your theme wants */
}

/* the little tagline */
.header-area .main-nav .logo-tagline {
  margin: 0;
  font-size: 0.9rem;       /* tweak to taste */
  font-style: italic;
  color: rgba(31, 38, 41, 0.75);
}
.logo {
  display: inline-flex;
  flex-direction: column;
  align-items: flex-start;
  text-decoration: none;
}

.logo-text {
  font-family: 'Pacifico', cursive;   /* you can swap in any “fancy” font */
  font-size: 1.8rem;
  color: #2c3e50;
  margin: 0;
  line-height: 1;
}

.logo-tagline {
  font-size: 0.85rem;
  color: #7f8c8d;
  font-style: italic;
  margin: 0.1rem 0 0;
}

.box-item:hover{
  transform: scale(1.05);
  transition: transform 0.3s ease-in-out;
}
.psy-icon img {
  width: 150px;               /* pick your size */
  height: 150px;
  border-radius: 50%;
  object-fit: cover;          /* fill the circle without distortion */
}

/* 2) Add the glow */
.psy-icon img {
  /* subtle colored glow */
  box-shadow:
    0 0 10px rgba(74, 190, 255, 0.6),
    0 0 20px rgba(74, 190, 255, 0.4),
    0 0 30px rgba(74, 190, 255, 0.2);
  transition: box-shadow 0.3s ease-in-out;
}

/* 3) (Optional) Intensify glow on hover */
.psy-icon img:hover {
  box-shadow:
    0 0 20px rgba(74, 190, 255, 0.8),
    0 0 40px rgba(74, 190, 255, 0.6),
    0 0 60px rgba(74, 190, 255, 0.4);
}

/* 4) (Super‐fancy) Animate the glow */
@keyframes pulseGlow {
  0% {
    box-shadow:
      0 0 5px rgba(74, 190, 255, 0.4),
      0 0 15px rgba(74, 190, 255, 0.2);
  }
  50% {
    box-shadow:
      0 0 20px rgba(74, 190, 255, 0.8),
      0 0 40px rgba(74, 190, 255, 0.6);
  }
  100% {
    box-shadow:
      0 0 5px rgba(74, 190, 255, 0.4),
      0 0 15px rgba(74, 190, 255, 0.2);
  }
}

.psy-icon img.pulsing {
  animation: pulseGlow 2s infinite ease-in-out;
}
</style>