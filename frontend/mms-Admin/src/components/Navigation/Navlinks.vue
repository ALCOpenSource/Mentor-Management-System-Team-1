<template>
  <div class="flex gap-8 items-center">
    <MessageIcon />
    <NotificationIcon />
    <v-menu>
        <template v-slot:activator="{ props }">
          <UserAvatar id="menu-activator" v-bind="props" :image-link="authStore.authUser?.avatar" />
        </template>
        <div class="bg-[#f7feff] border-2 border-green-200 rounded py-3 px-5">
          <router-link to="/admin/profile"><p class="cursor-pointer mb-2">View Profile</p></router-link>
          <v-divider></v-divider>
          <p class="cursor-pointer text-center" @click="handleLogout">Log Out</p>
        </div>
      </v-menu>
  </div>
</template>

<script setup lang="ts">
import UserAvatar from "../Common/UserAvatar.vue";
import MessageIcon from "../Icons/IconMessage.vue";
import NotificationIcon from "../Icons/IconNotification.vue";
import {useAuthStore} from "../../store/auth"

const authStore = useAuthStore();

const handleLogout = () => {
  // Handle Log out
}
</script>

<style></style>
