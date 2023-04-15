<script setup lang="ts">
import Sidebar from "../components/Navigation/Sidebar.vue";
import TopNavigation from "../components/Navigation/TopNavigation.vue";
</script>

<template>
  <div class="flex flex-col">
    <TopNavigation />
    <div class="dashboard_page flex">
      <Sidebar />
      <div class="content mt-28 ml-72 w-full pl-8 py-8 pr-14">
        <router-view></router-view>
      </div>
    </div>
  </div>
</template>
