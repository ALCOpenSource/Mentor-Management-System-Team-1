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
        {
          path: "/profile",
          name: "profile",
          component: () => import("@/views/Dashboard/Profile.vue"),
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
      ],
    },
  ],
});

export default router;
