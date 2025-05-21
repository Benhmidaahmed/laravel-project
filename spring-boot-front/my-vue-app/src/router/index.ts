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
    meta: { requiresAuth: true, roles: ["ADMIN","PSYCHOLOGIST"] },
  },
  {
    path: "/Forum",
    name: "Forum",
    component: Forum,
    meta: { requiresAuth: true, roles: ["STUDENT", "PSYCHOLOGIST", "ADMIN"] },
  },
  {
    path: "/",
    name: "UserAuthentification",
    component: UserAuthentification,
  },
  {
    path: "/form/:psyId",
    name: "form",
    component: form,
    meta: { requiresAuth: true, roles: ["STUDENT", "ADMIN"] },
  },
  {
    path: "/StudentPortal",
    name: "StudentPortal",
    component: StudentPortal,
    meta: { requiresAuth: true, roles: ["STUDENT", "ADMIN"] },
  },
  {
    path: "/AIAssistant",
    name: "AIAssistant",
    component: AIAssistant,
    meta: { requiresAuth: true, roles: ["STUDENT", "PSYCHOLOGIST", "ADMIN"] },
  },
  {
    path: "/chat/:psyId",
    name: "StudentChat",
    component: StudentChat,
    meta: { requiresAuth: true, roles: ["STUDENT", "ADMIN"] },
  },
  {
    path: "/about",
    name: "about",
    component: () => import("../views/AboutView.vue"),
  },
  {
    path: "/forbidden",
    name: "Forbidden",
    component: () => import("../views/Forbidden.vue"),
  },
];

const router = createRouter({
  history: createWebHashHistory(),
  routes,
  scrollBehavior(to, from, savedPosition) {
    if (to.hash) {
      return {
        el: to.hash,
        behavior: "smooth",
      };
    }
    return { top: 0 };
  },
});

router.beforeEach((to, from, next) => {
  const token = localStorage.getItem("token");
  const userRole = localStorage.getItem("userRole"); // e.g., STUDENT, PSYCHOLOGIST, ADMIN

  // Redirect unauthenticated users
  if (to.meta.requiresAuth && !token) {
    console.log("Access denied: not authenticated");
    return next("/");
  }

  // Restrict based on role if defined
  if (
    Array.isArray((to.meta as any).roles) &&
    userRole &&
    !(to.meta as any).roles.includes(userRole)
  ) {
    console.log(`Access denied: role "${userRole}" cannot access ${to.path}`);
    return next("/forbidden"); // or use "/" if you don't want to create a Forbidden.vue
  }

  next();
});

export default router;
