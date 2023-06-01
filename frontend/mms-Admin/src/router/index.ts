import { createRouter, createWebHistory } from "vue-router";
import Dashboard from "../views/Dashboard/Dashboard.vue";
import dashboardLayout from "@/layouts/dashboardLayout.vue";
import settingsLayout from "@/layouts/settingsLayout.vue";
import reportLayout from "@/layouts/reportLayout.vue"
import { useAuthStore } from "@/store/auth";
import blankLayout from "@/layouts/blankLayout.vue";

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
        requiresAuth: true,
      },
    },
    {
      path: "/admin",
      name: "dashboardLayout",
      component: dashboardLayout,
      beforeEnter: dashboardLayout.onBeforeRouteEnter,
      redirect: "/admin/dashboard",
      meta: {
        requiresAuth: true,
      },
      children: [
        {
          path: "dashboard",
          name: "dashboard",
          component: Dashboard,
          meta: {
            requiresAuth: true,
          },
        },
        {
          path: "profile",
          name: "profile",
          component: () => import("@/views/Profile/Profile.vue"),
          meta: {
            requiresAuth: true,
          },
        },
        {
          path: "programs",
          name: "programs",
          component: blankLayout,
          redirect: "/admin/programs/program/all",
          meta: {
            requiresAuth: true,
          },
          children: [
            {
              path: "program/:id",
              name: "program",
              component: () => import("@/views/Programs/Programs.vue"),
            },
            {
              path: "new-program",
              name: "new-program",
              component: () => import("@/views/Programs/CreateProgram.vue"),
            },
            {
              path: "mentors-assigned/:id",
              name: "mentors-assigned",
              component: () => import("@/views/Programs/MentorsAssigned.vue"),
            },
            {
              path: "mentor-managers-assigned/:id",
              name: "mentor-managers-assigned",
              component: () =>
                import("@/views/Programs/MentorManagersAssigned.vue"),
            },
            {
              path: "program-reports/:id",
              name: "program-reports",
              component: () => import("@/views/Programs/ProgramReports.vue"),
            },
            {
              path: "create-criteria/:id",
              name: "create-criteria",
              component: () => import("@/views/Programs/CreateCriteria.vue"),
            },
            {
              path: "edit-program/:id",
              name: "edit-program",
              component: () => import("@/views/Programs/EditProgram.vue"),
            },
          ],
        },
        {
          path: "tasks",
          name: "tasks",
          component: blankLayout,
          meta: {
            requiresAuth: true,
          },
          children: [
            {
              path: "all",
              name: "allTasks",
              component: () => import("@/views/Tasks/Tasks.vue"),
            },
            {
              path: "create",
              name: "create",
              component: () => import("@/views/Tasks/Create.vue"),
            },
            {
              path: "edit",
              name: "edit",
              component: () => import("@/views/Tasks/Edit.vue"),
            },
          ],
        },
        {
          path: "reports",
          name: "reports",
          component: reportLayout,
          redirect: "/admin/reports/tasks",
          children: [
            {
              path: "programs",
              name: "programs",
              component: () => import("@/views/Reports/EmptyReport.vue")
            },
            {
              path: "tasks",
              name: "tasks",
              component: () => import("@/views/Reports/EmptyReport.vue")
            },
            {
              path: "tasks/:id",
              name: "task-report",
              component: () => import("@/views/Reports/TaskReports.vue")
            },
            {
              path: "programs/:id",
              name: "programs-report",
              component: () => import("@/views/Reports/ProgramReports.vue")
            }
          ],
          meta: {
            requiresAuth: true,
          },
        },
        {
          path: "notifications",
          name: "notifications",
          component: () => import("@/views/Others/Notifications.vue"),
          meta: {
            requiresAuth: true,
          },
        },
        {
          path: "search-results/:search",
          name: "search-results",
          component: () => import("@/views/Others/SearchResults.vue"),
        },
        {
          path: "mentors",
          name: "mentors",
          component: blankLayout,
          meta: {
            requiresAuth: true,
          },
          redirect: () => "/admin/mentors/mentor-list",
          children: [
            {
              path: "mentor-list",
              name: "mentor-list",
              component: () => import("@/views/Mentors/MentorList.vue"),
            },
            {
              path: "mentor/:id",
              name: "mentor",
              component: () => import("@/views/Mentors/Mentor.vue"),
            },
          ],
        },
        {
          path: "mentor-managers",
          name: "mentor-managers",
          component: blankLayout,
          meta: {
            requiresAuth: true,
          },
          redirect: () => "/admin/mentor-managers/mentor-manager-list",
          children: [
            {
              path: "mentor-manager-list",
              name: "mentor-manager-list",
              component: () =>
                import("@/views/MentorManagers/MentorManagerList.vue"),
            },
            {
              path: "mentor-manager/:id",
              name: "mentor-manager",
              component: () =>
                import("@/views/MentorManagers/MentorManager.vue"),
            },
          ],
        },
        {
          path: "approval-requests",
          name: "approval-requests",
          component: () => import("@/views/Approval/ApprovalRequests.vue"),
          meta: {
            requiresAuth: true,
          },
        },
        {
          path: "certificates",
          name: "certificates",
          component: blankLayout,
          meta: {
            requiresAuth: true,
          },
          redirect: () => "/admin/certificates/certificate-list",
          children: [
            {
              path: "certificate-list",
              name: "certificate-list",
              component: () => import("@/views/Certificates/Certificates.vue"),
            },
            {
              path: "generate-certificate",
              name: "generate-certificate",
              component: () => import("@/views/Certificates/GenerateCerts.vue"),
            },
          ],
        },
        {
          path: "messages",
          name: "messages",
          component: blankLayout,
          meta: {
            requiresAuth: true,
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
            },
          ],
        },
        {
          path: "discussion-forum",
          name: "discussion-forum",
          component: blankLayout,
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
            requiresAuth: true,
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
              name: "settings-notifications",
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
        requiresAuth: false,
      },
      children: [
        {
          path: "/login",
          name: "login",
          component: () => import("@/views/Auth/Login.vue"),
          meta: {
            requiresAuth: false,
          },
        },
        {
          path: "/reset-password",
          name: "reset-password",
          component: () => import("@/views/Auth/ResetPassword.vue"),
          meta: {
            requiresAuth: false,
          },
        },
        {
          path: "/change-password",
          name: "change-password",
          component: () => import("@/views/Auth/ChangePassword.vue"),
          meta: {
            requiresAuth: false,
          },
        },
        {
          path: "/confirm-reset",
          name: "confirm-reset",
          component: () => import("@/views/Auth/AcknowledgePasswordReset.vue"),
          meta: {
            requiresAuth: false,
          },
        },
      ],
    },
  ],
});

router.beforeEach((to, from) => {
  const authStore = useAuthStore();

  if (to.meta.requiresAuth && authStore.token == 0) {
    return { name: "login" };
  }
  if (to.meta.requiresAuth == false && authStore.token != 0) {
    return { name: "dashboard" };
  }
});
export default router;
