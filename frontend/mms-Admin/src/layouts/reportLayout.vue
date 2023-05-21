<template>
  <div class="flex gap-4">
    <ReportList />
    <ViewReport />
    <!-- <router-view></router-view> -->
  </div>
</template>

<script setup lang="ts">
import ReportList from "@/components/Reports/ReportList.vue";
import ViewReport from "@/components/Reports/ViewReport.vue";
</script>

<style></style>
