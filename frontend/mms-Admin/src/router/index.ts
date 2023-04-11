import { createRouter, createWebHistory } from "vue-router";
import Dashboard from "../views/Dashboard/Dashboard.vue";
import dashboardLayoutVue from "@/layouts/dashboardLayout.vue";

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: "/",
      name: "dashboardLayout",
      component: dashboardLayoutVue,
      children: [
        {
          path: "/",
          name: "dashboard",
          component: Dashboard,
        },
      ],
    },
    {
      path: "/login",
      name: "loginLayout",
      component: () => import("@/layouts/authLayout.vue"),
      children: [
        {
          path: "/login",
          name: "login",
          component: () => import("@/views/Auth/Login.vue"),
        },
        {
          path: "/reset-password",
          name: "reset-password",
          component: () => import("@/views/Auth/ResetPassword.vue"),
        },
        {
          path: "/change-password",
          name: "change-password",
          component: () => import("@/views/Auth/ChangePassword.vue"),
        },
        {
          path: "/confirm-reset",
          name: "confirm-reset",
          component: () => import("@/views/Auth/AcknowledgePasswordReset.vue"),
        },
      ],
    },
  ],
});

export default router;
