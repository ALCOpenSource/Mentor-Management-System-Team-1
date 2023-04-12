import { createRouter, createWebHistory } from "vue-router";
import Dashboard from "../views/Dashboard/Dashboard.vue";
import dashboardLayoutVue from "@/layouts/dashboardLayout.vue";
import adminLayout from "@/layouts/adminLayout.vue";
import {
  Mentors,
  Profile,
  Programs,
  Reports,
  Tasks,
  MentorManagers,
  Certificates,
  ApprovalRequests,
  Messages,
  Settings,
  DiscussionForum,
} from "@/views/Admin";

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  scrollBehavior() {
    return { top: 0, behavior: "smooth" };
  },
  routes: [
    {
      path: "/",
      name: "home",
      redirect: (to) => ({ path: "/admin/dashboard" }),
    },
    {
      path: "/admin",
      name: "admin",
      component: dashboardLayoutVue,
      children: [
        {
          path: "dashboard",
          name: "dashboard",
          component: Dashboard,
        },
        {
          path: "profile",
          name: "profile",
          component: Profile,
        },
        {
          path: "programs",
          name: "programs",
          component: Programs,
        },
        {
          path: "tasks",
          name: "tasks",
          component: Tasks,
        },
        {
          path: "reports",
          name: "reports",
          component: Reports,
        },
        {
          path: "mentors",
          name: "mentors",
          component: Mentors,
        },
        {
          path: "mentor-managers",
          name: "mentor-managers",
          component: MentorManagers,
        },
        {
          path: "approval-requests",
          name: "approval-requests",
          component: ApprovalRequests,
        },
        {
          path: "certificates",
          name: "certificates",
          component: Certificates,
        },
        {
          path: "messages",
          name: "messages",
          component: Messages,
        },
        {
          path: "discussion-forum",
          component: DiscussionForum,
        },
        {
          path: "settings",
          name: "settings",
          component: Settings,
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
