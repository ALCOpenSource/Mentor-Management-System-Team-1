<script setup lang="ts">
import Sidebar from "../components/Navigation/Sidebar.vue";
import TopNavigation from "../components/Navigation/TopNavigation.vue";

</script>

<script lang="ts">
import { defineComponent } from 'vue'
import { useUserStore } from "../store/user"

export default defineComponent({
  components: { Sidebar, TopNavigation },
  
  beforeRouteEnter(to, from, next) {
    const userStore = useUserStore()
    if (userStore.avatar && userStore.user) {
      // The authentication state is already loaded, so proceed to the dashboard
      next()
    } else {
      // The authentication state is not loaded yet, so wait for it before proceeding
      userStore.fetchUser().then(() => {
        return userStore.fetchAvatar();
      }).then(() => {
        next();
      });
    }
  },
})
</script>

<template>
  <div class="flex flex-col">
    <TopNavigation />
    <div class="dashboard_page flex">
      <Sidebar />
      <div
        class="content sm:mt-16 md:mt-20 xl:mt-24 ml-72 w-full pl-8 py-8 pr-14"
      >
        <router-view></router-view>
      </div>
    </div>
  </div>
</template>
