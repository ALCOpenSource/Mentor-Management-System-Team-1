import { createRouter, createWebHistory } from "vue-router";
import Dashboard from "../views/Dashboard/Dashboard.vue";
import dashboardLayout from "@/layouts/dashboardLayout.vue";
import settingsLayout from "@/layouts/settingsLayout.vue";
import {useAuthStore} from '@/store/auth'
import messageLayout from "@/layouts/messageLayout.vue";
import discussionLayout from "@/layouts/discussionLayout.vue";
import blankLayout from "@/layouts/blankLayout.vue"

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  scrollBehavior() {
    return { top: 0, behavior: "smooth" };
  },
  routes: [
    {
      path: "/",
      name: "home",
      redirect: "/admin/dashboard",
      meta: {
        requiresAuth:true
      }
    },
    {
      path: "/admin",
      name: "dashboardLayout",
      component: dashboardLayout,
      beforeEnter: dashboardLayout.onBeforeRouteEnter,
      redirect: "/admin/dashboard",
      meta: {
        requiresAuth:true
      },
      children: [
        {
          path: "dashboard",
          name: "dashboard",
          component: Dashboard,
          meta: {
            requiresAuth:true
          },
        },
        {
          path: "profile",
          name: "profile",
          component: () => import("@/views/Profile/Profile.vue"),
          meta: {
            requiresAuth:true
          },
        },
        {
          path: "programs",
          name: "programs",
          component: () => import("@/views/Programs/Programs.vue"),
          meta: {
            requiresAuth:true
          },
        },
        {
          path: "tasks",
          name: "tasks",
          component: blankLayout,
          meta: {
            requiresAuth:true
          },
          children: [
            {
              path: "all",
              name: "allTasks",
              component: () => import("@/views/Tasks/Tasks.vue")
            },
            {
              path: "create",
              name: "create",
              component: () => import("@/views/Tasks/Create.vue")
            },
            {
              path: "edit",
              name: "edit",
              component: () => import("@/views/Tasks/Edit.vue")
            },
          ]
        },
        {
          path: "reports",
          name: "reports",
          component: () => import("@/views/Reports/Reports.vue"),
          meta: {
            requiresAuth:true
          },
        },
        {
          path: "mentors",
          name: "mentors",
          component: () => import("@/views/Mentors/Mentors.vue"),
          meta: {
            requiresAuth:true
          },
        },
        {
          path: "mentor-managers",
          name: "mentor-managers",
          component: () => import("@/views/MentorManagers/MentorManagers.vue"),
          meta: {
            requiresAuth:true
          },
        },
        {
          path: "approval-requests",
          name: "approval-requests",
          component: () => import("@/views/Approval/ApprovalRequests.vue"),
          meta: {
            requiresAuth:true
          },
        },
        {
          path: "certificates",
          name: "certificates",
          component: () => import("@/views/Certificates/Certificates.vue"),
          meta: {
            requiresAuth:true
          },
        },
        {
          path: "messages",
          name: "messages",
          component: messageLayout,
          meta: {
            requiresAuth:true
          },
          redirect: () => "/admin/messages/inbox",
          children: [
            {
              path: "inbox",
              name: "inbox",
              component: () => import("@/views/Messages/Messages.vue"),
            },
            {
              path: "broadcast",
              name: "broadcast",
              component: () => import("@/views/Messages/Broadcast.vue"),
            },
            {
              path: "select-someone",
              name: "select-someone",
              component: () => import("@/views/Messages/SelectSomeone.vue"),
            }
          ],
        },
        {
          path: "discussion-forum",
          name: "discussion-forum",
          component: discussionLayout,
          redirect: () => "/admin/discussion-forum/discussions",
          children: [
            {
              path: "discussions",
              name: "discussions",
              component: () =>
                import("@/views/DiscussionForum/Discussions.vue"),
            },
            {
              path: "comments/:id",
              name: "comments",
              component: () => import("@/views/DiscussionForum/Comments.vue"),
            },
          ],
        },
        {
          path: "settings",
          name: "settings",
          component: settingsLayout,
          meta: {
            requiresAuth:true
          },
          redirect: () => "/admin/settings/general",
          children: [
            {
              path: "general",
              name: "general",
              component: () => import("@/views/Settings/General.vue"),
            },
            {
              path: "notifications",
              name: "notifications",
              component: () => import("@/views/Settings/Notifications.vue"),
            },
            {
              path: "privacy",
              name: "privacy",
              component: () => import("@/views/Settings/Privacy.vue"),
            },
            {
              path: "archive",
              name: "archive",
              component: () => import("@/views/Settings/Archive.vue"),
            },
            {
              path: "password",
              name: "password",
              component: () => import("@/views/Settings/Password.vue"),
            },
            {
              path: "FAQ",
              name: "FAQ",
              component: () => import("@/views/Settings/FAQ.vue"),
            },
            {
              path: "support",
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
      meta: {
        requiresAuth:false
      },
      children: [
        {
          path: "/login",
          name: "login",
          component: () => import("@/views/Auth/Login.vue"),
          meta: {
            requiresAuth:false
          },
        },
        {
          path: "/reset-password",
          name: "reset-password",
          component: () => import("@/views/Auth/ResetPassword.vue"),
          meta: {
            requiresAuth:false
          },
        },
        {
          path: "/change-password",
          name: "change-password",
          component: () => import("@/views/Auth/ChangePassword.vue"),
          meta: {
            requiresAuth:false
          },
        },
        {
          path: "/confirm-reset",
          name: "confirm-reset",
          component: () => import("@/views/Auth/AcknowledgePasswordReset.vue"),
          meta: {
            requiresAuth:false
          },
        },
      ],
    },
  ],
});

router.beforeEach((to, from) => {
  const authStore = useAuthStore();

  if(to.meta.requiresAuth && authStore.token == 0)
  {
    return {name: "login"}
  }
  if(to.meta.requiresAuth == false && authStore.token != 0)
  {
    return {name: "dashboard"}
  }
})
export default router;
