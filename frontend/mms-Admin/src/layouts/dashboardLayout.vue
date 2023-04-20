<script setup lang="ts">
import Sidebar from "../components/Navigation/Sidebar.vue";
import TopNavigation from "../components/Navigation/TopNavigation.vue";
import {onMounted} from 'vue';
import useAuthStore from "../store/auth"

const authStore = useAuthStore();

onMounted(async () => {
  await authStore.getUser();
})
</script>

<template>
  <div class="flex flex-col">
    <TopNavigation />
    <div class="dashboard_page flex">
      <Sidebar v-if="authStore.authUser" :name="authStore.authUser?.data.user.name"/>
      <div
        class="content sm:mt-16 md:mt-20 xl:mt-24 ml-72 w-full pl-8 py-8 pr-14"
      >
        <router-view></router-view>
      </div>
    </div>
  </div>
</template>
