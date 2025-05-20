import { createRouter, createWebHashHistory, RouteRecordRaw } from "vue-router";
import AIAssistant from "@/pages/AIAssistant.vue";
import UserForm from "@/components/UserForm.vue";
import UserAuthentification from "@/components/UserAuthentification.vue";
import StudentPortal from "@/pages/StudentPortal.vue";
import Forum from "@/pages/Forum.vue";
import form from "@/pages/form.vue";
import StudentChat from "@/pages/StudentChat.vue";
const routes: Array<RouteRecordRaw> = [
  {
    path: "/dashboard",
    name: "UserForm",
    component: UserForm,
    meta: { requiresAuth: true }
    
  },
  {
    path: "/Forum",
    name: "Forum",
    component: Forum,
    
    
  },
  // {
  //   path: '/booking/:psyId',
  //   name: 'Booking',
  //   component: Booking,
    
  // },
{
    path: "/",
    name: "UserAuthentification",
    component: UserAuthentification,
  },
  {
    path: "/form/:psyId",
    name: "form",
    component: form,
  },
  {
    path:"/StudentPortal",
    name:"StudentPortal",
    component:StudentPortal,
  },
  {
    path:"/AIAssistant",
    name:"AIAssistant",
    component:AIAssistant,
  },
  {
    path: '/chat/:psyId',
    name: 'StudentChat',
    component: StudentChat,
    meta: { requiresAuth: true }
  },
  {
    path: "/about",
    name: "about",
    // route level code-splitting
    // this generates a separate chunk (about.[hash].js) for this route
    // which is lazy-loaded when the route is visited.
    component: () =>
      import(/* webpackChunkName: "about" */ "../views/AboutView.vue"),
  },
];

const router = createRouter({
  history: createWebHashHistory(),
  routes,
  scrollBehavior(to, from, savedPosition) {
    // if navigating to a hash, scroll to that element smoothly
    if (to.hash) {
      return {
        el: to.hash,
        behavior: 'smooth'
      };
    }
    // fallback to top
    return { top: 0 };
  },
});

router.beforeEach((to, from, next) => {
  const token = localStorage.getItem('token');
  if (to.meta.requiresGuest && token) {
    next('/dashboard');
    return;
  }
  if (to.meta.requiresAuth && !token) {
    next('/');
  } else {
    next();
  }
});
export default router;
