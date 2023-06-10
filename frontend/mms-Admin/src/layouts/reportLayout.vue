<template>
  <div class="flex gap-7 overflow-y-hidden">
    <ReportList />
    <router-view></router-view>
  </div>
</template>

<script setup lang="ts">
import ReportList from "@/components/Reports/ReportList.vue";
</script>

<style></style>
