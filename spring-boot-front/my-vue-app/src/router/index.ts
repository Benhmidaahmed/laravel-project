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
  console.log(`Navigation de ${from.path} vers ${to.path}`); // [!code ++]
  const token = localStorage.getItem('token');
  console.log("Token trouvé:", token ? "Oui" : "Non"); // [!code ++]

  if (to.meta.requiresAuth && !token) {
    console.log("Accès refusé - Redirection vers /"); // [!code ++]
    next('/');
  } else {
    console.log("Accès autorisé"); // [!code ++]
    next();
  }
});
export default router;
