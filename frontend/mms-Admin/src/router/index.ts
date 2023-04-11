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
          component: () => import("@/views/Profile/Profile.vue"),
        },
        {
          path: "/settings/general",
          name: "settings",
          component: () => import("@/layouts/settingsLayout.vue"),
          children: [
            {
              path: "/settings/general",
              name: "general",
              component: () => import("@/views/Settings/General.vue"),
            },
            {
              path: "/settings/notifications",
              name: "notifications",
              component: () => import("@/views/Settings/Notifications.vue"),
            },
            {
              path: "/settings/privacy",
              name: "privacy",
              component: () => import("@/views/Settings/Privacy.vue"),
            },
            {
              path: "/settings/archive",
              name: "archive",
              component: () => import("@/views/Settings/Archive.vue"),
            },
            {
              path: "/settings/password",
              name: "password",
              component: () => import("@/views/Settings/Password.vue"),
            },
            {
              path: "/settings/FAQ",
              name: "FAQ",
              component: () => import("@/views/Settings/FAQ.vue"),
            },
            {
              path: "/settings/support",
              name: "support",
              component: () => import("@/views/Settings/Support.vue"),
            },
          ],
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
