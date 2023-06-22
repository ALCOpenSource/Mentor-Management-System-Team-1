<template>
  <div class="flex gap-8 items-center">
    <div class="relative">
      <router-link :to="{ name: 'messages' }">
        <MessageIcon />
        <span v-if="userStore.user.unread_messages_count !== 0" class="indicator">{{ userStore.user.unread_messages_count }}</span>
      </router-link>
    </div>
    <div class="relative">
      <router-link :to="{ name: 'notifications' }">
        <NotificationIcon />
        <span v-if="userStore.user.unread_notifications_count !== 0" class="indicator">{{ userStore.user.unread_notifications_count }}</span>
      </router-link>
    </div>
    <v-menu>
      <template v-slot:activator="{ props }">
        <UserAvatar
          id="menu-activator"
          v-bind="props"
          :image-link="userStore.avatar?.avatar_url"
        />
      </template>
      <div class="bg-[#f7feff] border-2 border-green-200 rounded py-3 px-5">
        <router-link to="/admin/profile"
          ><p class="cursor-pointer mb-2">View Profile</p></router-link
        >
        <v-divider></v-divider>
        <p class="cursor-pointer text-center" @click="handleLogout">Log Out</p>
      </div>
    </v-menu>
  </div>
</template>

<script setup lang="ts">
import { ref } from "vue";
import UserAvatar from "../Common/UserAvatar.vue";
import MessageIcon from "../Icons/IconMessage.vue";
import NotificationIcon from "../Icons/IconNotification.vue";
import { useUserStore } from "../../store/user";
import { useAuthStore } from "../../store/auth";

const userStore = useUserStore();
const authStore = useAuthStore();

// const notificationCount = ref(3);
// const messageCount = ref(4);

const handleLogout = async () => {
  await authStore.handleLogout();
};
</script>

<style scoped lang="scss">
.indicator {
  position: absolute;
  top: -5px;
  right: -5px;
  width: 17px;
  height: 17px;
  background-color: #cc000e;
  border-radius: 50%;
  border: 2px solid var(--bg-primary);
  color: #fff;
  font-size: 12px;
  display: flex;
  justify-content: center;
  align-items: center;
  font-weight: 400;
}
</style>
