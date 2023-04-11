<template>
  <div>
    <h1 class="text-2xl font-semibold mb-6">Settings</h1>
    <div class="flex gap-8">
      <SideBar />
      <div class="card">
        <router-view></router-view>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import SideBar from "../components/Settings/SideBar.vue";
</script>

<style scoped>
.card {
  border: 1.7px solid var(--border);
  border-radius: 10px;
  box-shadow: 0px 5px 5px rgba(241, 241, 241, 0.25);
  margin-bottom: 3rem;
  width: 100%;
  padding: 20px;
}
</style>
