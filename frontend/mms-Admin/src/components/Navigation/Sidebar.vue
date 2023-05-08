<template>
  <div class="w-72 z-10 pt-12 sidebar">
    <div class="pl-16 mb-14">
      <h2 class="font-bold text-xl">Hi, {{ userStore.user?.name }}</h2>
      <span class="text-mute"> {{ userStore.user?.tags[0] }} </span>
    </div>

    <section>
      <router-link
        :to="link.path"
        v-for="link in sidebarLinks"
        :key="link.pathname"
        active-class="active_link"
        class="flex link text-black gap-2 mb-6 items-center py-4 text-lg pl-16"
      >
        <div><component :is="link.icon" :color="'#808080'"></component></div>
        <span class="link_pathname">{{ link.pathname }}</span>
      </router-link>
    </section>
  </div>
</template>

<script setup lang="ts">
import {useUserStore} from "../../store/user"

const userStore = useUserStore();

import {
  IconDashboard,
  IconProfile,
  IconPrograms,
  IconTask,
  IconCertificate,
  IconMentor,
  IconDiscussionForum,
  IconMentorManagers,
  IconSettings,
  IconAdd,
  IconReport,
  IconMessage,
} from "@/components/Icons";

const parentPath = "/admin";

const sidebarLinks = [
  {
    pathname: "Profile",
    path: parentPath + "/profile",
    icon: IconProfile,
  },
  {
    pathname: "Dashboard",
    path: parentPath + "/dashboard",
    icon: IconDashboard,
  },
  {
    pathname: "Programs",
    path: parentPath + "/programs",
    icon: IconPrograms,
  },
  {
    pathname: "Tasks",
    path: parentPath + "/tasks",
    icon: IconTask,
  },
  {
    pathname: "Reports",
    path: parentPath + "/reports",
    icon: IconReport,
  },
  {
    pathname: "Mentors",
    path: parentPath + "/mentors",
    icon: IconMentor,
  },
  {
    pathname: "Mentor Managers",
    path: parentPath + "/mentor-managers",
    icon: IconMentorManagers,
  },
  {
    pathname: "Approval Requests",
    path: parentPath + "/approval-requests",
    icon: IconAdd,
  },
  {
    pathname: "Certificates",
    path: parentPath + "/certificates",
    icon: IconCertificate,
  },
  {
    pathname: "Messages",
    path: parentPath + "/messages",
    icon: IconMessage,
  },
  {
    pathname: "Discussion Forum",
    path: parentPath + "/discussion-forum",
    icon: IconDiscussionForum,
  },
  {
    pathname: "Settings",
    path: parentPath + "/settings",
    icon: IconSettings,
  },
];
</script>

<style lang="scss">
.sidebar {
  z-index: 1;
  height: 87vh;
  overflow-y: scroll;
  position: fixed;
  top: 13vh;
  left: 0;
  background: var(--light-grid-background);

  &::-webkit-scrollbar {
    width: 5px;
  }

  &::-webkit-scrollbar-track {
    background: transparent;
  }

  &::-webkit-scrollbar-thumb {
    background: rgb(240, 240, 240);
    height: 40px;
    border-radius: 50px;
  }

  &::-webkit-scrollbar-thumb:hover {
    background: var(--btn-primary);
    opacity: 0.2;
  }
}

.active_link {
  transition: background-color 200ms ease-out;
  background-color: #fff;

  .link_pathname {
    font-weight: bold;
  }
}
</style>
