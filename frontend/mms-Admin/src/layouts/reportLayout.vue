<template>
  <div class="flex gap-4">
    <ReportList />
    <router-view></router-view>
  </div>
</template>

<script setup lang="ts">
import ReportList from "@/components/Reports/ReportList.vue";
</script>

<style></style>
