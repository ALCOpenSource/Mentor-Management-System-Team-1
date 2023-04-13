<script setup lang="ts">
import Sidebar from "../components/Navigation/Sidebar.vue";
import TopNavigation from "../components/Navigation/TopNavigation.vue";
</script>

<template>
  <div class="flex flex-col">
    <TopNavigation />
    <div class="dashboard_page flex">
      <Sidebar />
      <div class="content pl-72 w-full">
        <router-view></router-view>
      </div>
    </div>
  </div>
</template>
